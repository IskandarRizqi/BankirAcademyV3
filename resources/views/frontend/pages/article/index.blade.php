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

            <!-- Form Pencarian -->
            <div class="article-search" style="margin-bottom: 2rem;">
                <form action="{{ url('/artikel') }}" method="GET" style="display: flex; gap: 10px; max-width: 400px;">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul, kata kunci, atau isi..."
                        style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <button type="submit"
                        style="padding: 10px 20px; background: #0056b3; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Cari
                    </button>
                </form>
            </div>

            @if ($articles->count())
                <div class="article-grid">
                    @foreach ($articles as $article)
                        <article class="article-card">
                            @if ($article->image_url)
                                <div class="article-card-image">
                                    <img src="{{ asset($article->image_url) }}" style="margin-bottom: 20px"
                                        alt="{{ $article->title }}" loading="lazy">
                                </div>
                            @endif

                            <div class="article-card-meta">
                                <span class="tag">{{ $article->keyword }}</span>
                                <time datetime="{{ optional($article->created_at)->toDateString() }}">
                                    {{ optional($article->created_at)->format('d M Y') ?? '-' }}
                                </time>
                            </div>
                            <h2>{{ $article->title }}</h2>
                            <a class="article-card-link" href="{{ route('frontend.articles.show', $article->slug) }}">
                                Baca artikel <span class="icon-arrow">-&gt;</span>
                            </a>
                        </article>
                    @endforeach
                </div>

                {{-- <div class="article-pagination">
                    {{ $articles->links() }}
                </div> --}}
            @else
                <div class="article-empty">
                    @if (request('search'))
                        <h2>Artikel tidak ditemukan</h2>
                        <p>Tidak ada artikel yang cocok dengan kata kunci "<strong>{{ request('search') }}</strong>".
                            Silakan coba kata kunci lain.</p>
                        <a href="{{ url('/artikel') }}"
                            style="display: inline-block; margin-top: 10px; color: #0056b3;">&larr; Kembali ke semua
                            artikel</a>
                    @else
                        <h2>Belum ada artikel</h2>
                        <p>Artikel yang sudah dipublikasikan akan tampil di halaman ini.</p>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
