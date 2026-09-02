@extends('layouts.appfrontend')

@section('page-title')
    Artikel - Bankir Academy
@endsection

@section('page-description')
    Baca artikel dan wawasan terbaru seputar perbankan, pembelajaran, dan pengembangan talenta dari Bankir Academy.
@endsection

@section('content')
    <section class="articles-page">
        <div class="container">
            <div class="section-head left">
                <span class="eyebrow">Wawasan Bankir Academy</span>
                <h1>Artikel untuk Menambah <span class="gradient-text">Wawasan</span></h1>
                <p>Temukan insight dan informasi terbaru untuk mendukung pembelajaran serta perkembangan karier di ekosistem
                    perbankan.</p>
            </div>

            @if ($articles->count())
                <div class="article-grid">
                    @foreach ($articles as $article)
                        <article class="article-card">
                            @if ($article->image_url)
                                <div class="article-card-image">
                                    <img src="{{ asset($article->image_url) }}" alt="{{ $article->title }}" loading="lazy">
                                </div>
                            @endif

                            <div class="article-card-meta">
                                <span class="tag">{{ $article->keyword }}</span>
                                <time datetime="{{ optional($article->created_at)->toDateString() }}">
                                    {{ optional($article->created_at)->format('d M Y') ?? '-' }}
                                </time>
                            </div>
                            <h2>{{ $article->title }}</h2>
                            {{-- <p>{{ \Illuminate\Support\Str::limit(trim(strip_tags($article->content)), 180) }}</p> --}}
                            <a class="article-card-link" href="{{ route('frontend.articles.show', $article->slug) }}">
                                Baca artikel <span class="icon-arrow">-&gt;</span>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="article-pagination">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="article-empty">
                    <h2>Belum ada artikel</h2>
                    <p>Artikel yang sudah dipublikasikan akan tampil di halaman ini.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
