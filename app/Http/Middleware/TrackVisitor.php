<?php

namespace App\Http\Middleware;

use App\Services\VisitorTrackingService;
use Closure;
use Illuminate\Http\Request;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->isSuccessful()) {
            $tracking = app(VisitorTrackingService::class);
            $tracking->recordPageVisit($request);
            $deviceId = $tracking->deviceId($request);

            if ($request->cookie(VisitorTrackingService::DEVICE_COOKIE) !== $deviceId) {
                $response->withCookie($tracking->makeDeviceCookie($request, $deviceId));
            }
        }

        return $response;
    }
}
