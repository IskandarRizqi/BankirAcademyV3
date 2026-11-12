@if ($relatedArticles->isNotEmpty() || $relatedJobs->isNotEmpty())
    <aside class="article-inline-related" aria-label="Rekomendasi artikel dan lowongan kerja">
        <div class="article-inline-related__eyebrow">Lanjutkan membaca</div>
        <h2>Rekomendasi untuk Anda</h2>
        <div class="article-inline-related__grid">
            @foreach ($relatedArticles->take(2) as $related)
                <a href="{{ route('frontend.articles.show', $related->slug) }}" class="article-inline-item">
                    <span class="article-inline-item__type">Artikel</span>
                    <strong>{{ $related->title }}</strong>
                    <span class="article-inline-item__arrow">&rarr;</span>
                </a>
            @endforeach
            @foreach ($relatedJobs->take(2) as $job)
                <a href="{{ route('membernonanggota.loker.show', $job->id) }}" class="article-inline-item article-inline-item--job">
                    <span class="article-inline-item__type">Loker</span>
                    <strong>{{ $job->title }}</strong>
                    <span class="article-inline-item__arrow">&rarr;</span>
                </a>
            @endforeach
        </div>
    </aside>
@endif
