<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{

    // KONFIRMASI PEMINJAMAN
    public function konfirmasi($id)
    {
        $p = Peminjaman::findOrFail($id);

        $p->status = 'Dikonfirmasi';
        $p->dikonfirmasi_oleh = 'admin';

        $p->save();

        return back()->with('success', 'Peminjaman dikonfirmasi');
    }


    // HAPUS PEMINJAMAN
    public function hapus($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->delete();

        return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus');
    }
}
