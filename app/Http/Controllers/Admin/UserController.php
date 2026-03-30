<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // tampilkan user
    public function index()
    {
        // hanya ambil user role user
        $users = User::where('role', 'user')->latest()->get();

        return view('admin.kelola_user', compact('users'));
    }


    // hapus user
    public function hapus($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
