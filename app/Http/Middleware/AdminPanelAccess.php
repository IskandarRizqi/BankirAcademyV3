<?php

namespace App\Http\Middleware;

use App\Support\AdminPanel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPanelAccess
{
    /**
     * Allow the legacy root account and the current CB root account.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (AdminPanel::canAccess($user)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses ke panel admin.');
    }
}
