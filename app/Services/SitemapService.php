<?php

namespace App\Services;

use App\Models\Article;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapService
{
    public function generate(): void
    {
        $sitemap = Sitemap::create()
            ->add(
                Url::create(route('frontend.home'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            )
            ->add(
                Url::create(route('frontend.articles.index'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            );

        Article::query()
            ->where('status', 1)
            ->latest('updated_at')
            ->get()
            ->each(function (Article $article) use ($sitemap): void {
                $sitemap->add(
                    Url::create(route('frontend.articles.show', $article->slug))
                        ->setLastModificationDate($article->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.7)
                );
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
