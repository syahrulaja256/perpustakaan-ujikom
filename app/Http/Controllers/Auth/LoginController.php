<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // jika admin
            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            // jika petugas
            if ($user->role == 'petugas') {
                return redirect('/petugas/dashboard');
            }

            // jika user
            if ($user->role == 'user') {
                return redirect('/user/dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
