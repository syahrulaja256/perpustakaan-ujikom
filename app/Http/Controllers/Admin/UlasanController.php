<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    // Menampilkan list ulasan
    public function index()
    {
        $ulasans = Peminjaman::whereNotNull('ulasan')
            ->where('ulasan', '!=', '')
            ->with(['user', 'buku'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.ulasan.index', compact('ulasans'));
    }

    // Menampilkan detail ulasan
    public function show($id)
    {
        $ulasan = Peminjaman::findOrFail($id);
        
        if (!$ulasan->ulasan) {
            return redirect()->route('admin.ulasan.index')->with('error', 'Ulasan tidak ditemukan');
        }

        return view('admin.ulasan.show', compact('ulasan'));
    }

    // Menghapus ulasan
    public function destroy($id)
    {
        $ulasan = Peminjaman::findOrFail($id);
        $ulasan->ulasan = null;
        $ulasan->rating = null;
        $ulasan->save();

        return redirect()->route('admin.ulasan.index')->with('success', 'Ulasan berhasil dihapus');
    }
}
