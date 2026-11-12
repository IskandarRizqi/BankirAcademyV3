<?php

namespace App\Services;

use App\Models\Visitor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class VisitorTrackingService
{
    public const DEVICE_COOKIE = 'visitor_device_id';

    public function recordPageVisit(Request $request): ?Visitor
    {
        if (! $request->isMethod('GET') || $this->isInternalRequest($request)) {
            return null;
        }

        return $this->record($request, Visitor::TYPE_LANDING);
    }

    public function recordAuth(Request $request): ?Visitor
    {
        if ($this->isInternalRequest($request)) {
            return null;
        }

        $visitor = $this->record($request, Visitor::TYPE_AUTH);
        $this->queueDeviceCookie($request);

        return $visitor;
    }

    public function recordTransaction(Request $request): ?Visitor
    {
        if ($this->isInternalRequest($request)) {
            return null;
        }

        $visitor = $this->record($request, Visitor::TYPE_TRANSACTION);
        $this->queueDeviceCookie($request);

        return $visitor;
    }

    public function record(Request $request, string $type, ?string $pageUrl = null): ?Visitor
    {
        if (! in_array($type, [
            Visitor::TYPE_LANDING,
            Visitor::TYPE_AUTH,
            Visitor::TYPE_TRANSACTION,
        ], true) || ! $request->ip()) {
            return null;
        }

        $visitedAt = now();
        $pageUrl = $this->normalizeUrl($pageUrl ?: $request->getPathInfo());
        $deviceId = $this->deviceId($request);
        $attributes = [
            'ip_address' => $request->ip(),
            'device_id' => $deviceId,
            'page_url' => $pageUrl,
            'visitor_type' => $type,
            'visitor_date' => $visitedAt->toDateString(),
        ];
        $location = $this->resolveLocation($request->ip());
        $values = [
            'country_code' => $location['country_code'] ?? null,
            'country' => $location['country'] ?? null,
            'province' => $location['province'] ?? null,
            'city' => $location['city'] ?? null,
            'user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
            'page_label' => $this->pageLabel($request, $pageUrl),
            'visited_year' => $visitedAt->year,
            'visited_at' => $visitedAt,
        ];

        try {
            return Visitor::firstOrCreate($attributes, $values);
        } catch (QueryException $exception) {
            // A concurrent request can win the unique daily insert race.
            return Visitor::where($attributes)->first();
        }
    }

    public function deviceId(Request $request): string
    {
        $deviceId = $request->attributes->get(self::DEVICE_COOKIE) ?: $request->cookie(self::DEVICE_COOKIE);

        if (! is_string($deviceId) || ! preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $deviceId)) {
            $deviceId = (string) Str::uuid();
        }

        $request->attributes->set(self::DEVICE_COOKIE, $deviceId);

        return $deviceId;
    }

    public function makeDeviceCookie(Request $request, string $deviceId)
    {
        return cookie(
            self::DEVICE_COOKIE,
            $deviceId,
            60 * 24 * 365 * 5,
            '/',
            null,
            $request->isSecure(),
            true,
            false,
            'lax'
        );
    }

    public function normalizeUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        $path = '/'.ltrim($path, '/');
        $path = rtrim($path, '/');

        return $path === '' ? '/' : $path;
    }

    public function isMobile(string $userAgent): bool
    {
        return (bool) preg_match('/Android|iPhone|iPad|iPod|Windows Phone/i', $userAgent);
    }

    private function resolveLocation(string $ip): array
    {
        $config = config('services.visitor_geolocation');

        if (! ($config['enabled'] ?? false) || ! $this->isPublicIp($ip)) {
            return [];
        }

        $cacheKey = 'visitor-geolocation:'.hash('sha256', $ip);

        return Cache::remember($cacheKey, now()->addDays(max(1, (int) ($config['cache_days'] ?? 30))), function () use ($config, $ip) {
            try {
                $response = Http::acceptJson()
                    ->connectTimeout(1)
                    ->timeout(max(1, (int) ($config['timeout'] ?? 2)))
                    ->get(rtrim($config['url'], '/').'/'.rawurlencode($ip));
            } catch (ConnectionException) {
                return [];
            }

            if (! $response->successful() || $response->json('success') !== true) {
                return [];
            }

            return [
                'country_code' => $this->locationValue($response->json('country_code'), 2),
                'country' => $this->locationValue($response->json('country'), 100),
                'province' => $this->locationValue($response->json('region'), 150),
                'city' => $this->locationValue($response->json('city'), 150),
            ];
        });
    }

    private function isPublicIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
    }

    private function locationValue(mixed $value, int $limit): ?string
    {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        return Str::limit(trim($value), $limit, '');
    }

    private function queueDeviceCookie(Request $request): void
    {
        $deviceId = $this->deviceId($request);

        if ($request->cookie(self::DEVICE_COOKIE) !== $deviceId) {
            Cookie::queue($this->makeDeviceCookie($request, $deviceId));
        }
    }

    private function isInternalRequest(Request $request): bool
    {
        return $request->is('admin/*')
            || $request->is('api/*')
            || $request->is('storage/*')
            || $request->is('assets/*')
            || $request->is('Backend/*')
            || $request->is('cbtemplate/*')
            || $request->is('getBerkas*')
            || $request->is('getBerkasbukti*');
    }

    private function pageLabel(Request $request, string $pageUrl): string
    {
        $routeName = $request->route()?->getName();
        $labels = [
            'frontend.home' => 'Landing Page Utama',
            'frontend.articles.index' => 'Artikel',
            'frontend.articles.show' => 'Detail Artikel',
            'frontend.news.index' => 'Berita',
            'frontend.news.show' => 'Detail Berita',
            'frontend.classes.index' => 'Daftar Kelas',
            'frontend.class.landing' => 'Landing Page Kelas',
            'frontend.class.detail' => 'Detail Kelas',
            'membernonanggota.loker.index' => 'Lowongan Kerja',
            'membernonanggota.loker.show' => 'Detail Lowongan Kerja',
        ];

        if ($routeName && isset($labels[$routeName])) {
            return $labels[$routeName];
        }

        $segment = trim($pageUrl, '/');
        if ($segment === '') {
            return 'Landing Page Utama';
        }

        return Str::headline(str_replace(['/', '-', '_'], ' ', $segment));
    }
}
