<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        // ambil hanya role petugas
        $petugas = User::where('role', 'petugas')->get();

        return view('admin.kelola_petugas', compact('petugas'));
    }
}
