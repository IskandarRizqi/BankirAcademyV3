<?php

namespace App\Http\Middleware;

use App\Helper\GlobalHelper;
use Closure;
use Illuminate\Http\Request;

class AksesByIpAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (GlobalHelper::getipaddress()) {
            return $next($request);
        }
        return response()->json([
            'status' => false,
            'message' => 'Akses dibatasi, harap hubungi admin',
            'ipaddress' => GlobalHelper::checkipaddress(),
        ]);
    }
}
