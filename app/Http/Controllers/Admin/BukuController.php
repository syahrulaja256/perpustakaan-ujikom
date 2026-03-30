<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->get();
        $kategoris = Kategori::all();

        return view('admin.kelola_buku', compact('bukus', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.kelola_buku', compact('kategoris'));
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $bukus = Buku::with('kategori')->get();
        $kategoris = Kategori::all();

        return view('admin.kelola_buku', compact('buku', 'bukus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverPath = null;

        // Upload cover
        if ($request->hasFile('cover')) {
            $filename = time() . '.' . $request->cover->extension();
            $coverPath = $request->file('cover')->storeAs('covers', $filename, 'public');
        }

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori_id' => $request->kategori_id,
            'cover' => $coverPath,
        ]);

        return redirect()->route('admin.kelola_buku')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverPath = $buku->cover;

        // Kalau upload cover baru
        if ($request->hasFile('cover')) {

            // Hapus cover lama
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }

            // Simpan cover baru
            $filename = time() . '.' . $request->cover->extension();
            $coverPath = $request->file('cover')->storeAs('covers', $filename, 'public');
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori_id' => $request->kategori_id,
            'cover' => $coverPath
        ]);

        return redirect()->route('admin.kelola_buku')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus cover dari storage
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.kelola_buku')
            ->with('success', 'Buku berhasil dihapus');
    }
}
