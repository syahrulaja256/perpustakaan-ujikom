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
        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
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

        $peminjaman->rating = $request->rating;
        $peminjaman->ulasan = $request->ulasan;
        $peminjaman->status = 'Menunggu Pengembalian';

        $peminjaman->save();

        return redirect()->route('user.riwayat')
            ->with('success', 'Ulasan berhasil dikirim & pengembalian diajukan. Menunggu konfirmasi admin/petugas.');
    }


    // List ulasan user
    public function ulasanList()
    {
        $ulasan = Peminjaman::where('user_id', Auth::id())
            ->whereNotNull('rating')
            ->with('buku')
            ->latest()
            ->get();

        return view('user.ulasan_list', compact('ulasan'));
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
