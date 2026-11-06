@extends('layouts.appfrontend')

@section('page-title', 'Berita Bankir Academy | Informasi Terbaru')
@section('page-description', 'Baca berita, kabar terbaru, dan informasi terpilih dari Bankir Academy untuk ekosistem perbankan Indonesia.')
@section('page-url', route('frontend.news.index'))

@section('head')
    <meta name="robots" content="index, follow">
    <script type="application/ld+json">
        {!! json_encode(['@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => 'Berita Bankir Academy', 'url' => route('frontend.news.index'), 'description' => 'Berita terbaru Bankir Academy.'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
    </script>
@endsection

@section('content')
    <style>
        .news-list-page{background:#f7f9fc;padding:120px 0 80px;color:#1e2b47}.news-list-hero{max-width:760px;margin-bottom:34px}.news-list-kicker,.news-detail-kicker{color:#5d56d9;font-size:12px;font-weight:800;letter-spacing:.14em;text-transform:uppercase}.news-list-hero h1{font-size:clamp(2.2rem,5vw,4.25rem);line-height:1.05;letter-spacing:-.05em;margin:12px 0 16px;font-weight:800}.news-list-hero p{color:#68738a;font-size:17px;line-height:1.7}.news-search{background:#fff;border:1px solid #e7ebf3;border-radius:14px;padding:8px;display:flex;max-width:580px;box-shadow:0 10px 28px rgba(40,51,83,.06)}.news-search input{border:0;outline:0;flex:1;padding:10px 13px;min-width:0}.news-search button{border:0;border-radius:10px;background:#5d56d9;color:#fff;padding:0 19px;font-weight:700}.news-list-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:23px}.news-card{background:#fff;border:1px solid #edf0f5;border-radius:18px;overflow:hidden;display:flex;flex-direction:column;transition:transform .2s,box-shadow .2s}.news-card:hover{transform:translateY(-5px);box-shadow:0 18px 34px rgba(40,51,83,.12)}.news-card-media{height:205px;background:#e9edf5;position:relative}.news-card-media img{width:100%;height:100%;object-fit:cover}.news-card-media--empty{display:flex;align-items:center;justify-content:center;color:#aab3c5;font-size:35px}.news-card-body{padding:20px 21px 22px;display:flex;flex-direction:column;flex:1}.news-card-date{font-size:12px;color:#8892a6;margin-bottom:10px}.news-card h2{font-size:19px;line-height:1.35;margin:0 0 10px;color:#202d48}.news-card-excerpt{color:#737e94;font-size:14px;line-height:1.6;margin:0 0 18px}.news-card-link{color:#5d56d9;font-size:13px;font-weight:800;text-decoration:none;margin-top:auto}.news-empty{background:#fff;border:1px dashed #d9deea;border-radius:16px;text-align:center;padding:50px;color:#718097}.news-pagination{margin-top:35px}.news-pagination nav{display:flex;justify-content:center}.news-pagination svg{width:18px}.news-pagination .relative{padding:7px 12px}@media(max-width:900px){.news-list-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:600px){.news-list-page{padding:90px 0 55px}.news-list-grid{grid-template-columns:1fr}.news-search button{padding:0 13px}}
    </style>
    <section class="news-list-page">
        <div class="container">
            <div class="news-list-hero">
                <span class="news-list-kicker">Bankir Academy Newsroom</span>
                <h1>Kabar yang membantu Anda melangkah lebih jauh.</h1>
                <p>Ikuti informasi dan cerita terbaru seputar pembelajaran, talenta, karier, dan ekosistem perbankan.</p>
                <form class="news-search" action="{{ route('frontend.news.index') }}" method="GET">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari berita..." aria-label="Cari berita">
                    <button type="submit">Cari</button>
                </form>
            </div>

            @if ($news->isNotEmpty())
                <div class="news-list-grid">
                    @foreach ($news as $item)
                        @php($image = $item->bannerImages->first())
                        <article class="news-card">
                            <a href="{{ route('frontend.news.show', $item->slug) }}" class="news-card-media" aria-label="Baca {{ $item->title }}">
                                @if ($image)<img src="{{ $image->url }}" alt="{{ $item->title }}" loading="lazy">@else<div class="news-card-media--empty h-100"><i class="far fa-newspaper"></i></div>@endif
                            </a>
                            <div class="news-card-body">
                                <time class="news-card-date" datetime="{{ optional($item->published_at ?? $item->created_at)->toDateString() }}">{{ optional($item->published_at ?? $item->created_at)->translatedFormat('d F Y') }}</time>
                                <h2><a href="{{ route('frontend.news.show', $item->slug) }}" class="text-reset text-decoration-none">{{ $item->title }}</a></h2>
                                <p class="news-card-excerpt">{{ $item->excerpt }}</p>
                                <a class="news-card-link" href="{{ route('frontend.news.show', $item->slug) }}">Baca berita <span aria-hidden="true">&rarr;</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="news-pagination">{{ $news->links() }}</div>
            @else
                <div class="news-empty"><i class="far fa-newspaper fa-2x mb-3"></i><h2>Berita belum ditemukan</h2><p>{{ request('search') ? 'Coba gunakan kata kunci lain.' : 'Berita yang sudah dipublikasikan akan muncul di sini.' }}</p></div>
            @endif
        </div>
    </section>
@endsection
