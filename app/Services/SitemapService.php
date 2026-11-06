<?php

namespace App\Services;

use App\Models\Article;
use App\Models\LokerModel;
use App\Models\News;
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
            )
            ->add(
                Url::create(route('frontend.news.index'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            )
            ->add(
                Url::create(route('membernonanggota.loker.index'))
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

        News::published()
            ->latest('updated_at')
            ->get()
            ->each(function (News $news) use ($sitemap): void {
                $sitemap->add(
                    Url::create(route('frontend.news.show', $news->slug))
                        ->setLastModificationDate($news->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
            });

        LokerModel::query()
            ->where('status', 1)
            ->where(function ($query): void {
                $query->whereNull('tanggal_awal')
                    ->orWhereDate('tanggal_awal', '<=', now());
            })
            ->where(function ($query): void {
                $query->whereNull('tanggal_akhir')
                    ->orWhereDate('tanggal_akhir', '>=', now());
            })
            ->latest('updated_at')
            ->get()
            ->each(function (LokerModel $loker) use ($sitemap): void {
                $sitemap->add(
                    Url::create(route('membernonanggota.loker.show', $loker->id))
                        ->setLastModificationDate($loker->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
