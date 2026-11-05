<?php

namespace App\Services;

use App\Models\Visitor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VisitorTrackingService
{
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

        return $this->record($request, Visitor::TYPE_AUTH);
    }

    public function recordTransaction(Request $request): ?Visitor
    {
        if ($this->isInternalRequest($request)) {
            return null;
        }

        return $this->record($request, Visitor::TYPE_TRANSACTION);
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
        $attributes = [
            'ip_address' => $request->ip(),
            'page_url' => $pageUrl,
            'visitor_type' => $type,
            'visitor_date' => $visitedAt->toDateString(),
        ];
        $values = [
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
