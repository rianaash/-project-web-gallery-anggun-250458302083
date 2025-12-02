<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // suruh login dulu
        if (!Auth::check()) {
            return redirect('/login');
        }

        // kalau yang login bukan admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hey hey no no ya ini halaman admin.');
        }

        // kalau lolos semua cek di atas, bolehmasuk
        return $next($request);
    }
}