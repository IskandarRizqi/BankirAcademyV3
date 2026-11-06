<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Loker\BerandaLoker as LegacyLokerController;
use App\Models\LokerModel;
use App\Services\SitemapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Throwable;

/**
 * Admin entry point for job vacancy management.
 */
class LokerController extends LegacyLokerController
{
    public function publish(int $id, SitemapService $sitemap)
    {
        $loker = LokerModel::findOrFail($id);
        $loker->update(['status' => 1]);
        $this->regenerateSitemap($sitemap);

        return Redirect::back()->with('success', 'Lowongan berhasil dipublikasikan.');
    }

    public function unpublish(int $id, SitemapService $sitemap)
    {
        $loker = LokerModel::findOrFail($id);
        $loker->update([
            'status' => 0,
            'n8n_webhook_sent_at' => null,
        ]);
        $this->regenerateSitemap($sitemap);

        return Redirect::back()->with('success', 'Lowongan berhasil di-unpublish.');
    }

    public function store(Request $request)
    {
        $response = parent::store($request);
        $this->regenerateSitemap(app(SitemapService::class));

        return $response;
    }

    public function destroy($id)
    {
        $response = parent::destroy($id);
        $this->regenerateSitemap(app(SitemapService::class));

        return $response;
    }

    private function regenerateSitemap(SitemapService $sitemap): void
    {
        try {
            $sitemap->generate();
        } catch (Throwable $exception) {
            Log::error('Gagal memperbarui sitemap loker.', [
                'exception' => $exception,
            ]);
        }
    }
}
