<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, string $role)
    {

        if (!auth::check()) {
            return redirect()->route('login');
        }


        if (auth::user()->level !== $role) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
