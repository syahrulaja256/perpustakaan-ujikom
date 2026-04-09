<?php

namespace App\Http\Controllers\Auth; // <-- harus Auth sesuai folder

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrasiController extends Controller
{
    public function index()
    {
        return view('auth.registrasi'); // pastikan view ada
    }

    public function store(Request $request)
    {
        $cek = User::where('email', $request->email)->first();

        if ($cek) {
            return back()->with('error', 'Email sudah terdaftar');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => bcrypt($request->password),
            'role' => 'user', // jangan lupa role supaya redirect user_dashboard bisa jalan
        ]);

        // login otomatis setelah registrasi
        Auth::login($user);

        return redirect()->route('user.dashboard');
    }
}
