<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyRoot
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya user dengan role 4 DAN email cb@bankir.academy yang lolos
        if (auth()->check() && auth()->user()->role == 4 && auth()->user()->email === 'cb@bankir.academy') {
            return $next($request);
        }

        abort(403, 'Hanya Akun Root Utama yang dapat mengakses halaman ini.');
    }
}