<?php

namespace App\Http\Middleware;

use App\Models\ScraperApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyScraperApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $plainTextKey = $request->header('X-Scraper-Api-Key');

        if (!$plainTextKey) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Missing API Key.'
            ], 401);
        }

        // Hash key yang masuk menggunakan SHA-256
        $hashedKey = hash('sha256', $plainTextKey);

        // Cari key yang aktif di database
        $apiKey = ScraperApiKey::where('key_hash', $hashedKey)
            ->where('is_active', true)
            ->first();

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Invalid API Key.'
            ], 401);
        }

        // Update timestamp terakhir digunakan (opsional)
        $apiKey->update(['last_used_at' => now()]);

        return $next($request);
    }
}
