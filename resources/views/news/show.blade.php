@extends('layouts.appfrontend')

@php
    $canonicalUrl = route('frontend.news.show', $news->slug);
    $description = trim((string) ($news->meta_description ?: $news->excerpt));
    $description = $description ?: \Illuminate\Support\Str::limit(trim(strip_tags($news->content)), 160);
    $coverImage = $news->bannerImages->first();
    $shareImage = $coverImage?->absolute_url ?: asset('bankir-academy-icon.png');
    $contentParts = preg_split(
        '/(?<=<\/p>
)/i',
        $news->content,
        -1,
        PREG_SPLIT_NO_EMPTY,
    );
    $insertAt = max(1, (int) ceil(count($contentParts) / 2));
@endphp

@section('page-title', ($news->meta_title ?: $news->title) . ' | Bankir Academy')
@section('page-description', $description)
@section('page-url', $canonicalUrl)
@section('page-image', $shareImage)
@section('page-image-alt', $news->title)

@section('head')
    <meta name="robots" content="index, follow">
    @if ($news->meta_keywords)
        <meta name="keywords" content="{{ $news->meta_keywords }}">
    @endif
    <meta property="og:type" content="article">
    <meta property="og:locale" content="id_ID">
    <meta property="article:published_time"
        content="{{ optional($news->published_at ?? $news->created_at)->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ optional($news->updated_at)->toIso8601String() }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <script type="application/ld+json">
        {!! json_encode(['@context' => 'https://schema.org', '@type' => 'NewsArticle', 'headline' => $news->title, 'description' => $description, 'image' => $news->bannerImages->pluck('absolute_url')->values()->all() ?: [$shareImage], 'url' => $canonicalUrl, 'inLanguage' => 'id-ID', 'datePublished' => optional($news->published_at ?? $news->created_at)->toIso8601String(), 'dateModified' => optional($news->updated_at)->toIso8601String(), 'author' => ['@type' => 'Organization', 'name' => 'Bankir Academy', 'url' => url('/')], 'publisher' => ['@type' => 'Organization', 'name' => 'Bankir Academy', 'url' => url('/'), 'logo' => ['@type' => 'ImageObject', 'url' => asset('bankir-academy-icon.png')]], 'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonicalUrl]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
    </script>
@endsection

@section('content')
    <style>
        .news-detail-page {
            background: #f7f9fc;
            padding: 115px 0 75px;
            color: #202d48
        }

        .news-detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 305px;
            gap: 38px;
            align-items: start
        }

        .news-detail-main {
            background: #fff;
            border-radius: 20px;
            padding: clamp(22px, 4vw, 52px);
            box-shadow: 0 12px 35px rgba(31, 45, 72, .06)
        }

        .news-detail-kicker {
            display: inline-block;
            margin-bottom: 14px
        }

        .news-detail-main h1 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            line-height: 1.1;
            letter-spacing: -.045em;
            margin: 0 0 15px;
            font-weight: 800
        }

        .news-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            color: #8791a5;
            font-size: 13px;
            margin-bottom: 27px
        }

        .news-slider {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            background: #e9edf5;
            margin-bottom: 35px
        }

        .news-slider__track {
            display: flex;
            transition: transform .45s ease
        }

        .news-slide {
            min-width: 100%;
            height: clamp(220px, 38vw, 490px);
            object-fit: cover
        }

        .news-slider__button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .9);
            color: #273451;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .12);
            z-index: 2
        }

        .news-slider__button--prev {
            left: 14px
        }

        .news-slider__button--next {
            right: 14px
        }

        .news-slider__dots {
            position: absolute;
            bottom: 15px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 6px
        }

        .news-slider__dot {
            width: 8px;
            height: 8px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .55);
            padding: 0
        }

        .news-slider__dot.is-active {
            background: #fff;
            transform: scale(1.3)
        }

        .news-content {
            font-size: 17px;
            line-height: 1.85;
            color: #46526a;
            overflow-wrap: anywhere
        }

        .news-content p {
            margin: 0 0 1.35em
        }

        .news-content h2,
        .news-content h3 {
            color: #202d48;
            line-height: 1.3;
            margin: 1.8em 0 .65em
        }

        .news-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px
        }

        .news-content a {
            color: #5148c5
        }

        .news-share {
            border-top: 1px solid #edf0f5;
            margin-top: 34px;
            padding-top: 21px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px
        }

        .news-share__label {
            font-size: 13px;
            font-weight: 800;
            color: #303d58
        }

        .news-share__actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap
        }

        .news-share__button {
            border: 0;
            border-radius: 8px;
            width: 34px;
            height: 34px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none
        }

        .news-share__button--copy {
            background: #6c7890
        }

        .news-share__button--wa {
            background: #20b95a
        }

        .news-share__button--fb {
            background: #1877f2
        }

        .news-share__button--x {
            background: #111
        }

        .news-share__button--in {
            background: #0a66c2
        }

        .news-share__button--tg {
            background: #229ed9
        }

        .news-aside {
            position: sticky;
            top: 90px
        }

        .news-aside-card {
            background: #fff;
            border-radius: 17px;
            padding: 23px;
            box-shadow: 0 12px 30px rgba(31, 45, 72, .06);
            margin-bottom: 17px
        }

        .news-aside-card h2 {
            font-size: 18px;
            line-height: 1.3;
            margin: 0 0 16px
        }

        .news-aside-item {
            display: flex;
            gap: 10px;
            border-top: 1px solid #edf0f5;
            padding: 13px 0;
            text-decoration: none;
            color: #26334e
        }

        .news-aside-item:first-of-type {
            border-top: 0;
            padding-top: 0
        }

        .news-aside-item__image {
            width: 62px;
            height: 49px;
            object-fit: cover;
            border-radius: 7px;
            background: #e9edf5;
            flex-shrink: 0
        }

        .news-aside-item strong {
            display: block;
            font-size: 13px;
            line-height: 1.35
        }

        .news-aside-item small {
            display: block;
            color: #8b95a8;
            font-size: 10px;
            margin-top: 5px
        }

        .news-inline-related {
            background: linear-gradient(135deg, #f1f0ff, #f5f8ff);
            border: 1px solid #dfddfb;
            border-radius: 14px;
            padding: 22px;
            margin: 30px 0
        }

        .news-inline-related__eyebrow {
            color: #5d56d9;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase
        }

        .news-inline-related h2 {
            font-size: 20px;
            margin: 6px 0 15px
        }

        .news-inline-related__grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px
        }

        .news-inline-item {
            background: #fff;
            border: 1px solid #e5e5fa;
            border-radius: 10px;
            padding: 12px;
            text-decoration: none;
            color: #25324d;
            position: relative;
            min-height: 82px
        }

        .news-inline-item strong {
            display: block;
            font-size: 13px;
            line-height: 1.35;
            padding-right: 16px
        }

        .news-inline-item__type {
            display: block;
            color: #5d56d9;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 4px
        }

        .news-inline-item__arrow {
            position: absolute;
            right: 11px;
            bottom: 9px;
            color: #5d56d9
        }

        .news-inline-item--job .news-inline-item__type {
            color: #0b8f68
        }

        .news-inline-item--article .news-inline-item__type {
            color: #d17a00
        }

        @media(max-width:950px) {
            .news-detail-layout {
                grid-template-columns: 1fr
            }

            .news-aside {
                position: static;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 17px
            }

            .news-aside-card {
                margin: 0
            }
        }

        @media(max-width:600px) {
            .news-detail-page {
                padding: 84px 0 45px
            }

            .news-detail-layout {
                display: block
            }

            .news-detail-main {
                border-radius: 14px;
                padding: 21px 17px
            }

            .news-content {
                font-size: 16px
            }

            .news-share {
                align-items: flex-start;
                flex-direction: column
            }

            .news-aside {
                display: block;
                margin-top: 18px
            }

            .news-aside-card {
                margin-bottom: 14px
            }

            .news-inline-related__grid {
                grid-template-columns: 1fr
            }

            .news-slider__button {
                width: 32px;
                height: 32px
            }
        }
    </style>
    <section class="news-detail-page">
        <div class="container news-detail-layout">
            <article class="news-detail-main">
                <span class="news-detail-kicker">Berita Bankir Academy</span>
                <h1 style="font-size: clamp(24px, 5vw, 42px);">{{ $news->title }}</h1>
                <div class="news-detail-meta"><span><i
                            class="far fa-calendar-alt mr-1"></i>{{ optional($news->published_at ?? $news->created_at)->translatedFormat('d F Y') }}</span><span><i
                            class="far fa-eye mr-1"></i>{{ number_format($news->views) }} kali dibaca</span></div>

                @if ($news->bannerImages->isNotEmpty())
                    <div class="news-slider" data-news-slider>
                        <div class="news-slider__track">
                            @foreach ($news->bannerImages as $index => $image)
                                <img class="news-slide" style="object-fit: fill" src="{{ $image->url }}"
                                    alt="{{ $news->title }} - gambar {{ $index + 1 }}"
                                    @if ($index > 0) loading="lazy" @endif>
                            @endforeach
                        </div>
                        @if ($news->bannerImages->count() > 1)
                            <button class="news-slider__button news-slider__button--prev" type="button" data-slider-prev
                                aria-label="Gambar sebelumnya"><i class="fas fa-chevron-left"></i></button><button
                                class="news-slider__button news-slider__button--next" type="button" data-slider-next
                                aria-label="Gambar berikutnya"><i class="fas fa-chevron-right"></i></button>
                            <div class="news-slider__dots">
                                @foreach ($news->bannerImages as $index => $image)
                                    <button class="news-slider__dot {{ $index === 0 ? 'is-active' : '' }}" type="button"
                                        data-slider-dot="{{ $index }}"
                                        aria-label="Gambar {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <div class="news-content">
                    @forelse ($contentParts as $index => $part)
                        {!! $part !!}
                        @if ($index + 1 === $insertAt)
                            @include('news.partials.inline-related')
                        @endif
                    @empty
                        <p>Konten berita belum tersedia.</p>
                    @endforelse
                    @if (count($contentParts) > 0 && $insertAt > count($contentParts))
                        @include('news.partials.inline-related')
                    @endif
                </div>

                <div class="news-share"><span class="news-share__label">Bagikan berita ini</span>
                    <div class="news-share__actions"><button type="button"
                            class="news-share__button news-share__button--copy" data-copy-news-link title="Salin tautan"><i
                                class="fas fa-link"></i></button><a class="news-share__button news-share__button--wa"
                            target="_blank" rel="noopener"
                            href="https://wa.me/?text={{ rawurlencode($news->title . ' ' . $canonicalUrl) }}"
                            title="Bagikan ke WhatsApp"><i class="fab fa-whatsapp"></i></a><a
                            class="news-share__button news-share__button--fb" target="_blank" rel="noopener"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($canonicalUrl) }}"
                            title="Bagikan ke Facebook"><i class="fab fa-facebook-f"></i></a><a
                            class="news-share__button news-share__button--x" target="_blank" rel="noopener"
                            href="https://twitter.com/intent/tweet?text={{ rawurlencode($news->title) }}&url={{ rawurlencode($canonicalUrl) }}"
                            title="Bagikan ke X"><i class="fab fa-twitter"></i></a><a
                            class="news-share__button news-share__button--in" target="_blank" rel="noopener"
                            href="https://www.linkedin.com/sharing/share-offsite/?url={{ rawurlencode($canonicalUrl) }}"
                            title="Bagikan ke LinkedIn"><i class="fab fa-linkedin-in"></i></a><a
                            class="news-share__button news-share__button--tg" target="_blank" rel="noopener"
                            href="https://t.me/share/url?url={{ rawurlencode($canonicalUrl) }}&text={{ rawurlencode($news->title) }}"
                            title="Bagikan ke Telegram"><i class="fab fa-telegram-plane"></i></a></div>
                </div>
            </article>

            <aside class="news-aside">
                <div class="news-aside-card">
                    <h2>Berita lainnya</h2>
                    @forelse ($relatedNews as $item)
                        <a class="news-aside-item" href="{{ route('frontend.news.show', $item->slug) }}">
                            @if ($item->bannerImages->first())
                                <img class="news-aside-item__image" src="{{ $item->bannerImages->first()->url }}"
                                alt="">@else<div class="news-aside-item__image"></div>
                            @endif
                            <div>
                                <strong>{{ $item->title }}</strong><small>{{ optional($item->published_at)->translatedFormat('d M Y') }}</small>
                            </div>
                    </a>@empty<p class="text-muted small">Belum ada berita lain.</p>
                    @endforelse
                </div>
                <div class="news-aside-card">
                    <h2>Jelajahi Bankir Academy</h2><a class="btn btn-primary btn-block"
                        href="{{ route('frontend.news.index') }}">Semua berita</a><a
                        class="btn btn-outline-secondary btn-block mb-0" href="{{ route('frontend.articles.index') }}">Baca
                        artikel</a>
                </div>
            </aside>
        </div>
    </section>
@endsection

@push('frontend-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.querySelector('[data-news-slider]');
            if (slider) {
                const track = slider.querySelector('.news-slider__track');
                const slides = slider.querySelectorAll('.news-slide');
                const dots = slider.querySelectorAll('[data-slider-dot]');
                let current = 0;
                let timer;
                const goTo = index => {
                    current = (index + slides.length) % slides.length;
                    track.style.transform = `translateX(-${current * 100}%)`;
                    dots.forEach((dot, dotIndex) => dot.classList.toggle('is-active', dotIndex === current));
                };
                const start = () => {
                    if (slides.length > 1) timer = setInterval(() => goTo(current + 1), 5000);
                };
                const reset = () => {
                    clearInterval(timer);
                    start();
                };
                slider.querySelector('[data-slider-prev]')?.addEventListener('click', () => {
                    goTo(current - 1);
                    reset();
                });
                slider.querySelector('[data-slider-next]')?.addEventListener('click', () => {
                    goTo(current + 1);
                    reset();
                });
                dots.forEach(dot => dot.addEventListener('click', () => {
                    goTo(Number(dot.dataset.sliderDot));
                    reset();
                }));
                slider.addEventListener('mouseenter', () => clearInterval(timer));
                slider.addEventListener('mouseleave', start);
                start();
            }
            const copyButton = document.querySelector('[data-copy-news-link]');
            if (copyButton) copyButton.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(window.location.href);
                    copyButton.innerHTML = '<i class="fas fa-check"></i>';
                    setTimeout(() => copyButton.innerHTML = '<i class="fas fa-link"></i>', 1600);
                } catch (error) {
                    window.prompt('Salin tautan berita:', window.location.href);
                }
            });
        });
    </script>
@endpush
