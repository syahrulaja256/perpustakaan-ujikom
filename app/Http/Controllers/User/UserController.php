<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{

    // Dashboard
    public function dashboard(Request $request)
    {
        $search = $request->search;

        $bukus = Buku::with(['kategori', 'peminjaman' => function ($q) {
                $q->whereNotNull('rating')->whereNotNull('ulasan')->with('user')->latest();
            }])
            ->withAvg('peminjaman as rating_avg', 'rating')
            ->withCount(['peminjaman as total_ulasan' => function ($q) {
                $q->whereNotNull('rating');
            }])
            ->when($search, function ($query) use ($search) {

                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        return view('user.dashboard', compact('bukus'));
    }


    // Form peminjaman
    public function peminjamanForm($buku_id)
    {
        $buku = Buku::with('kategori')->findOrFail($buku_id);

        $tanggal_pinjam = date('Y-m-d');
        $tanggal_kembali = date('Y-m-d', strtotime('+3 days'));

        // Ambil ulasan dari pengguna lain untuk buku ini
        $ulasans = Peminjaman::where('buku_id', $buku_id)
            ->whereNotNull('rating')
            ->whereNotNull('ulasan')
            ->with('user')
            ->latest()
            ->get();

        return view('user.peminjaman_form', compact('buku', 'tanggal_pinjam', 'tanggal_kembali', 'ulasans'));
    }


    // Submit peminjaman → langsung redirect ke cetak PDF
    public function peminjamanSubmit(Request $request)
    {
        $buku = Buku::findOrFail($request->buku_id);

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1|max:' . $buku->stok,
        ]);

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'status' => 'Menunggu'
        ]);

        // Redirect ke halaman riwayat dengan flash untuk auto-download PDF
        return redirect()->route('user.riwayat')
            ->with('success', 'Peminjaman berhasil diajukan!')
            ->with('auto_cetak', $peminjaman->id);
    }


    // Riwayat peminjaman
    public function riwayat()
    {
        $pinjaman = Peminjaman::where('user_id', Auth::id())
            ->with(['buku', 'user'])
            ->latest()
            ->get();

        return view('user.peminjaman', compact('pinjaman'));
    }

    // Daftar ulasan pengguna
    public function ulasanList()
    {
        $ulasan = Peminjaman::where('user_id', Auth::id())
            ->whereNotNull('rating')
            ->whereNotNull('ulasan')
            ->with('buku')
            ->latest()
            ->get();

        return view('user.ulasan_list', compact('ulasan'));
    }

    // Form ulasan (sebelum pengembalian, saat buku masih dipinjam)
    public function kembalikanForm($id)
    {
        $data = Peminjaman::with('buku')->findOrFail($id);

        // Pastikan hanya bisa akses form ulasan jika status Dikonfirmasi (sedang dipinjam)
        if ($data->status !== 'Dikonfirmasi') {
            return redirect()->route('user.riwayat')
                ->with('error', 'Buku tidak dalam status dipinjam.');
        }

        return view('user.ulasan', compact('data'));
    }


    // Submit ulasan + kembalikan buku
    public function submitUlasan(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required'
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        // Cek apakah pengembalian terlambat
        $tanggalKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
        $sekarang = \Carbon\Carbon::now();

        if ($sekarang->gt($tanggalKembali)) {
            // Terlambat - redirect ke form alasan terlambat
            $peminjaman->rating = $request->rating;
            $peminjaman->ulasan = $request->ulasan;
            $peminjaman->status = 'Pengembalian Terlambat';
            $peminjaman->terlambat = true;
            $peminjaman->tanggal_pengembalian_aktual = $sekarang->toDateString();
            $peminjaman->save();

            return redirect()->route('user.alasan_terlambat.form', $peminjaman->id)
                ->with('warning', 'Pengembalian Anda terlambat. Silakan berikan alasan pengembalian terlambat.');
        } else {
            // Tepat waktu
            $peminjaman->rating = $request->rating;
            $peminjaman->ulasan = $request->ulasan;
            $peminjaman->status = 'Menunggu Pengembalian';
            $peminjaman->tanggal_pengembalian_aktual = $sekarang->toDateString();
            $peminjaman->save();

            return redirect()->route('user.riwayat')
                ->with('success', 'Ulasan berhasil dikirim & pengembalian diajukan. Menunggu konfirmasi admin/petugas.');
        }
    }


    // Form alasan pengembalian terlambat
    public function alasanTerlambatForm($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        // Pastikan hanya bisa akses jika status Pengembalian Terlambat
        if ($peminjaman->status !== 'Pengembalian Terlambat') {
            return redirect()->route('user.riwayat')
                ->with('error', 'Form ini hanya untuk pengembalian terlambat.');
        }

        // Hitung hari terlambat
        $tanggalKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
        $sekarang = \Carbon\Carbon::now();
        $hariTerlambat = $sekarang->diffInDays($tanggalKembali);

        return view('user.alasan_terlambat', compact('peminjaman', 'hariTerlambat'));
    }

    // Submit alasan pengembalian terlambat
    public function submitAlasanTerlambat(Request $request)
    {
        $request->validate([
            'alasan_terlambat' => 'required|string|min:10|max:500'
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        // Pastikan status masih Pengembalian Terlambat
        if ($peminjaman->status !== 'Pengembalian Terlambat') {
            return redirect()->route('user.riwayat')
                ->with('error', 'Status pengembalian sudah berubah.');
        }

        $peminjaman->alasan_terlambat = $request->alasan_terlambat;
        $peminjaman->status = 'Ditolak Terlambat'; // Status menunggu konfirmasi admin/petugas
        $peminjaman->save();

        return redirect()->route('user.riwayat')
            ->with('success', 'Alasan pengembalian terlambat berhasil dikirim. Menunggu konfirmasi admin/petugas.');
    }


    // Tambah buku ke favorit
    public function addFavorite(Request $request)
    {
        $user = Auth::user();
        $user->favorites()->syncWithoutDetaching([$request->buku_id]);
        return back()->with('success', 'Buku ditambahkan ke favorit');
    }


    // Halaman daftar favorit
    public function favorites()
    {
        $favorites = Auth::user()->favorites()
            ->with('kategori')
            ->latest()
            ->get();

        return view('user.favorites', compact('favorites'));
    }


    // Hapus favorit
    public function removeFavorite($id)
    {
        $user = Auth::user();
        $user->favorites()->detach($id);
        return back()->with('success', 'Buku dihapus dari favorit');
    }

    // User klik Kembalikan → status jadi "Menunggu Pengembalian" (butuh konfirmasi admin)
    public function kembalikanBuku($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->status = 'Menunggu Pengembalian';
        $pinjam->save();

        return redirect()->route('user.riwayat')
            ->with('success', 'Pengembalian berhasil diajukan. Menunggu konfirmasi admin/petugas.');
    }

    // CETAK PDF BUKTI PEMINJAMAN
    public function cetakPeminjaman($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('user.cetak_peminjaman', compact('peminjaman'));
        return $pdf->download('bukti-peminjaman-' . $peminjaman->id . '.pdf');
    }

    // CETAK PDF BUKTI PENGEMBALIAN
    public function cetakPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('user.cetak_pengembalian', compact('peminjaman'));
        return $pdf->download('bukti-pengembalian-' . $peminjaman->id . '.pdf');
    }
}
