<?php

namespace App\Http\Middleware;

use App\Support\AdminPanel;
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
        $user = auth()->user();
        if (AdminPanel::canAccess($user)) {
            return $next($request);
        }

        abort(403, 'Hanya Akun Root Utama yang dapat mengakses halaman ini.');
    }
}
