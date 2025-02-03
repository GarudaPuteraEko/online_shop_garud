<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login dan memiliki role 'user'
        if (Auth::check() && Auth::user()->role === 'admin') { // Sesuaikan dengan database
            return $next($request);
        }

        // Redirect ke halaman utama jika tidak memiliki akses
        return redirect('/')->with('error', 'Access Denied');
    }
}