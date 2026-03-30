<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $totalBuku = Buku::count();
        $totalPinjam = Peminjaman::where('status', 'Dikonfirmasi')->count();
        $totalKembali = Peminjaman::where('status', 'Dikembalikan')->count();

        return view('petugas.dashboard', compact('totalBuku', 'totalPinjam', 'totalKembali'));
    }

    public function buku()
    {
        $bukus = Buku::with('kategori')->latest()->get();
        $kategoris = Kategori::all();
        return view('petugas.buku', compact('bukus', 'kategoris'));
    }

    public function kategori()
    {
        $kategoris = Kategori::latest()->get();
        return view('petugas.kategori', compact('kategoris'));
    }

    public function peminjaman()
    {
        $peminjamans = Peminjaman::with('buku', 'user')->latest()->get();
        return view('petugas.peminjaman', compact('peminjamans'));
    }

    public function laporan()
    {
        $laporan = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->get();

        return view('petugas.laporan', compact('laporan'));
    }

    // CETAK LAPORAN PDF
    public function cetakLaporan()
    {
        $laporan = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('petugas.cetak_laporan', compact('laporan'));
        return $pdf->download('laporan-peminjaman-petugas-' . date('Y-m-d') . '.pdf');
    }

    // KONFIRMASI PEMINJAMAN
    public function konfirmasi($id)
    {
        $p = Peminjaman::findOrFail($id);
        $p->status = 'Dikonfirmasi';
        $p->dikonfirmasi_oleh = 'petugas';
        $p->save();

        return back()->with('success', 'Peminjaman dikonfirmasi');
    }

    // TOLAK PEMINJAMAN
    public function tolak($id)
    {
        $data = Peminjaman::findOrFail($id);
        $data->status = 'Ditolak';
        $data->save();

        return back()->with('success', 'Peminjaman ditolak');
    }

    // KONFIRMASI PENGEMBALIAN
    public function konfirmasiPengembalian($id)
    {
        $p = Peminjaman::findOrFail($id);
        $p->status = 'Dikembalikan';
        $p->save();

        return back()->with('success', 'Pengembalian dikonfirmasi. Buku telah diterima kembali.');
    }

    // TAMBAH BUKU
    public function storeBuku(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'cover' => 'nullable|image|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori_id' => $request->kategori_id,
            'cover' => $coverPath,
        ]);

        return redirect()->route('petugas.buku')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    // TAMBAH KATEGORI
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('petugas.kategori')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // LAPORAN BUKU
    public function laporanBuku()
    {
        $bukus = Buku::with('kategori')->latest()->get();
        return view('petugas.laporan_buku', compact('bukus'));
    }

    // CETAK LAPORAN BUKU PDF
    public function cetakLaporanBuku()
    {
        $bukus = Buku::with('kategori')->latest()->get();
        $pdf = Pdf::loadView('petugas.cetak_laporan_buku', compact('bukus'));
        return $pdf->download('laporan-buku-petugas-' . date('Y-m-d') . '.pdf');
    }

    // CETAK PEMINJAMAN (struk peminjaman)
    public function cetakPeminjaman($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('user.cetak_peminjaman', compact('peminjaman'));
        return $pdf->download('bukti-peminjaman-' . $peminjaman->id . '.pdf');
    }

    // CETAK PENGEMBALIAN (struk)
    public function cetakPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('petugas.cetak_pengembalian', compact('peminjaman'));
        return $pdf->download('struk-pengembalian-' . $peminjaman->id . '.pdf');
    }
}
