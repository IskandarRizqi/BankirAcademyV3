@if ($relatedNews->isNotEmpty() || $relatedJobs->isNotEmpty() || $relatedArticles->isNotEmpty())
    <aside class="news-inline-related" aria-label="Rekomendasi lainnya">
        <div class="news-inline-related__eyebrow">Lanjutkan membaca</div>
        <h2>Temukan informasi lainnya</h2>
        <div class="news-inline-related__grid">
            @foreach ($relatedNews->take(2) as $item)
                <a href="{{ route('frontend.news.show', $item->slug) }}" class="news-inline-item"><span class="news-inline-item__type">Berita</span><strong>{{ $item->title }}</strong><span class="news-inline-item__arrow">&rarr;</span></a>
            @endforeach
            @foreach ($relatedJobs->take(1) as $job)
                <a href="{{ route('membernonanggota.loker.show', $job->id) }}" class="news-inline-item news-inline-item--job"><span class="news-inline-item__type">Loker</span><strong>{{ $job->title }}</strong><span class="news-inline-item__arrow">&rarr;</span></a>
            @endforeach
            @foreach ($relatedArticles->take(1) as $article)
                <a href="{{ route('frontend.articles.show', $article->slug) }}" class="news-inline-item news-inline-item--article"><span class="news-inline-item__type">Artikel</span><strong>{{ $article->title }}</strong><span class="news-inline-item__arrow">&rarr;</span></a>
            @endforeach
        </div>
    </aside>
@endif
