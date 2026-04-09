<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Petugas;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBuku = Buku::count();
        $totalUser = User::where('role', 'user')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPinjam = Peminjaman::where('status', 'Dikonfirmasi')->count();
        $totalKembali = Peminjaman::where('status', 'Dikembalikan')->count();
        $totalMenunggu = Peminjaman::where('status', 'Menunggu')->count();
        $totalKategori = Kategori::count();
        $totalUlasan = Peminjaman::whereNotNull('ulasan')->where('ulasan', '!=', '')->count();

        return view('admin.dashboard', compact(
            'totalBuku', 'totalUser','totalPetugas', 'totalPinjam', 'totalKembali', 'totalMenunggu', 'totalKategori', 'totalUlasan'
        ));
    }

    public function kelolaBuku()
    {
        $bukus = Buku::all();
        return view('admin.kelola_buku', compact('bukus'));
    }

    public function kelolaKategori()
    {
        $kategoris = Kategori::all();
        return view('admin.kelola_kategori', compact('kategoris'));
    }

    public function kelolaPetugas()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.kelola_petugas', compact('petugas'));
    }

    public function kelolaUser()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.kelola_user', compact('users'));
    }

    // HALAMAN PEMINJAMAN ADMIN
    public function peminjaman()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->get();

        return view('admin.peminjaman', compact('peminjamans'));
    }

    public function riwayat()
    {
        $riwayat = Peminjaman::with(['user', 'buku'])
            ->where('status', 'Dikembalikan')
            ->latest()
            ->get();

        return view('admin.riwayat', compact('riwayat'));
    }

    public function laporan()
    {
        $laporan = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->get();

        return view('admin.laporan', compact('laporan'));
    }

    // CETAK LAPORAN PDF
    public function cetakLaporan()
    {
        $laporan = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.cetak_laporan', compact('laporan'));
        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }

    // KONFIRMASI PENGEMBALIAN (Admin mengkonfirmasi bahwa buku sudah dikembalikan)
    public function konfirmasiPengembalian($id)
    {
        $p = Peminjaman::with('buku')->findOrFail($id);
        $p->status = 'Dikembalikan';
        $p->save();

        // Tambah stok buku kembali
        $buku = $p->buku;
        if ($buku) {
            $buku->stok += $p->jumlah;
            $buku->save();
        }

        return back()->with('success', 'Pengembalian dikonfirmasi. Buku telah diterima kembali.');
    }

    // KONFIRMASI PENGEMBALIAN TERLAMBAT (dengan alasan)
    public function konfirmasiPengembalianTerlambat($id)
    {
        $p = Peminjaman::with('buku')->findOrFail($id);

        // Pastikan status adalah Ditolak Terlambat
        if ($p->status !== 'Ditolak Terlambat') {
            return back()->with('error', 'Status peminjaman tidak sesuai untuk konfirmasi pengembalian terlambat.');
        }

        $p->status = 'Dikembalikan';
        $p->save();

        // Tambah stok buku kembali
        $buku = $p->buku;
        if ($buku) {
            $buku->stok += $p->jumlah;
            $buku->save();
        }

        return back()->with('success', 'Pengembalian terlambat dikonfirmasi. Buku telah diterima kembali.');
    }

    // LAPORAN BUKU
    public function laporanBuku()
    {
        $bukus = Buku::with('kategori')->latest()->get();
        return view('admin.laporan_buku', compact('bukus'));
    }

    // CETAK LAPORAN BUKU PDF
    public function cetakLaporanBuku()
    {
        $bukus = Buku::with('kategori')->latest()->get();
        $pdf = Pdf::loadView('admin.cetak_laporan_buku', compact('bukus'));
        return $pdf->download('laporan-buku-' . date('Y-m-d') . '.pdf');
    }

    // LAPORAN USER
    public function laporanUser()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.laporan_user', compact('users'));
    }

    // CETAK LAPORAN USER PDF
    public function cetakLaporanUser()
    {
        $users = User::where('role', 'user')->latest()->get();
        $pdf = Pdf::loadView('admin.cetak_laporan_user', compact('users'));
        return $pdf->download('laporan-user-' . date('Y-m-d') . '.pdf');
    }

    // CETAK PEMINJAMAN (struk peminjaman)
    public function cetakPeminjaman($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('user.cetak_peminjaman', compact('peminjaman'));
        return $pdf->download('bukti-peminjaman-' . $peminjaman->id . '.pdf');
    }

    // CETAK PENGEMBALIAN (struk pengembalian)
    public function cetakPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.cetak_pengembalian', compact('peminjaman'));
        return $pdf->download('struk-pengembalian-' . $peminjaman->id . '.pdf');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // TAMBAH PETUGAS
    public function storePetugas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('admin.petugas')
            ->with('success', 'Petugas berhasil ditambahkan!');
    }

    // HAPUS PETUGAS
    public function hapusPetugas($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.petugas')
            ->with('success', 'Petugas berhasil dihapus!');
    }
}
