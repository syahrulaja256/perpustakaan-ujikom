<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

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
        // Ambil semua kategori dari database
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
            'cover' => 'nullable|image|max:2048',
        ]);

        // Upload cover jika ada
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

        return redirect()->route('admin.kelola_buku')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {

        $buku = Buku::findOrFail($id);

        $coverPath = $buku->cover;

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('cover', 'public');
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori_id' => $request->kategori_id,
            'cover' => $coverPath
        ]);

        return redirect()->route('admin.kelola_buku');
    }


    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        $buku->delete();

        return redirect()->route('admin.kelola_buku');
    }
}
