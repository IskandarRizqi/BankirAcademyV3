<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiswaIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Cek jika user adalah Siswa (role 6) dan belum aktif (is_active != 1)
        if ($user && (int)$user->role === 6 && (int)$user->is_active !== 1) {
            
            // Izinkan akses jika mengakses route logout atau resend email agar tidak terjebak redirect loop
            if ($request->routeIs('siswa.resend.verification') || $request->routeIs('logout')) {
                return $next($request);
            }

            // Jika mengakses route lain, biarkan tetap ke dashboard untuk melihat tampilan peringatan
            if (!$request->routeIs('dashboard') && !$request->is('/')) {
                return redirect()->route('/home');
            }
        }

        return $next($request);
    }
}