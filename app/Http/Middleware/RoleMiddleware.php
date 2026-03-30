<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if ($user->role != $role) {

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role == 'petugas') {
                return redirect('/petugas/dashboard');
            }

            if ($user->role == 'user') {
                return redirect('/user/dashboard');
            }
        }

        return $next($request);
    }
}
