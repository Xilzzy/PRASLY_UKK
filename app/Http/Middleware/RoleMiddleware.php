<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    // Membatasi akses rute berdasarkan param role string dari web.php ('admin'/'siswa')
    public function handle(Request $request, Closure $next, string $role)
    {
        // Tolak jika belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Tolak jika role tidak sesuai 
        if (auth()->user()->level !== $role) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
