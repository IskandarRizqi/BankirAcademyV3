<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IsAdminRoot
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
        if (!Auth::user()) {
            return Redirect::to('/');
        }
        // return $next($request);
        if (Auth::user()->role !== 2) {
            // return "hello";
            return $next($request);
        }
        if (Auth::user()->role == 2) {
            return response()->json(['data' => Auth::user()]);
        }
        // return response()->json('Your account is inactive');
        return Redirect::back()->with('error', 'The page you were not found');
    }
}
