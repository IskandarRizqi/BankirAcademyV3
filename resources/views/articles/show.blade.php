@extends('layouts.appfrontend')

@php
    $canonicalUrl = route('frontend.articles.show', $article->slug);
    $description = trim((string) $article->meta_description);
    $description = $description !== ''
        ? $description
        : \Illuminate\Support\Str::limit(trim(strip_tags((string) $article->content)), 160);
    $articleImage = trim((string) ($article->image_url ?: $article->image_base64));
    $shareImage = $articleImage !== '' && !\Illuminate\Support\Str::startsWith($articleImage, 'data:')
        ? (\Illuminate\Support\Str::startsWith($articleImage, ['http://', 'https://'])
            ? $articleImage
            : asset(ltrim($articleImage, '/')))
        : asset('bankir-academy-icon.png');
    $contentParts = preg_split('/(?<=<\/p>)/i', (string) $article->content, -1, PREG_SPLIT_NO_EMPTY);
    $insertAt = max(1, (int) ceil(count($contentParts) / 2));
@endphp

@section('page-title')
    {{ $article->title }} | Bankir Academy
@endsection

@section('page-description')
    {{ $description }}
@endsection

@section('page-url', $canonicalUrl)
@section('page-image', $shareImage)
@section('page-image-alt', $article->title)

@section('head')
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="article">
    <meta property="og:locale" content="id_ID">
    <meta property="article:published_time" content="{{ optional($article->created_at)->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ optional($article->updated_at)->toIso8601String() }}">
    <meta property="article:section" content="{{ $article->keyword }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $article->title,
            'description' => $description,
            'image' => [$shareImage],
            'url' => $canonicalUrl,
            'inLanguage' => 'id-ID',
            'datePublished' => optional($article->created_at)->toIso8601String(),
            'dateModified' => optional($article->updated_at)->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'Bankir Academy',
                'url' => url('/'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Bankir Academy',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('bankir-academy-icon.png'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $canonicalUrl,
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
    </script>
@endsection

@section('content')
    <style>
        .article-wrapper {
            padding-top: 120px;
            padding-bottom: 60px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #2d3748;
        }

        .article-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 40px;
            align-items: start;
        }

        .article-content {
            line-height: 1.8;
            background: #fff;
            border-radius: 20px;
            padding: clamp(22px, 4vw, 52px);
            box-shadow: 0 12px 35px rgba(31, 45, 72, 0.06);
        }

        .article-kicker {
            display: inline-block;
            margin-bottom: 14px;
            color: #5148c5;
            font-size: 13px;
            font-weight: 800;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            color: #8791a5;
            font-size: 13px;
            margin-bottom: 27px;
        }

        /* Styling untuk Tag Standard Img */
        .article-content .featured-image {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 28px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: block;
        }

        .article-content h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #1a202c;
            line-height: 1.3;
            margin-bottom: 24px;
            letter-spacing: -0.02em;
        }

        .article-content h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-top: 36px;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #edf2f7;
        }

        .article-content p {
            font-size: 1.1rem;
            color: #4a5568;
            margin-bottom: 20px;
        }

        .related-sidebar {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            position: sticky;
            top: 90px;
        }

        .related-sidebar h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .related-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .related-item {
            display: flex;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease;
        }

        .related-item:hover {
            transform: translateY(-2px);
        }

        .related-item .related-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .related-item-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2d3748;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-share {
            border-top: 1px solid #edf0f5;
            margin-top: 34px;
            padding-top: 21px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .article-share__label {
            font-size: 13px;
            font-weight: 800;
            color: #303d58;
        }

        .article-share__actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .article-share__button {
            border: 0;
            border-radius: 8px;
            width: 34px;
            height: 34px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .article-share__button--copy { background: #6c7890; }
        .article-share__button--wa { background: #20b95a; }
        .article-share__button--fb { background: #1877f2; }
        .article-share__button--x { background: #111; }
        .article-share__button--in { background: #0a66c2; }
        .article-share__button--tg { background: #229ed9; }

        .article-inline-related {
            background: linear-gradient(135deg, #f1f0ff, #f5f8ff);
            border: 1px solid #dfddfb;
            border-radius: 14px;
            padding: 22px;
            margin: 30px 0;
        }

        .article-inline-related__eyebrow {
            color: #5d56d9;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .article-inline-related h2 {
            font-size: 20px;
            margin: 6px 0 15px;
        }

        .article-inline-related__grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .article-inline-item {
            background: #fff;
            border: 1px solid #e5e5fa;
            border-radius: 10px;
            padding: 12px;
            text-decoration: none;
            color: #25324d;
            position: relative;
            min-height: 82px;
        }

        .article-inline-item strong {
            display: block;
            font-size: 13px;
            line-height: 1.35;
            padding-right: 16px;
        }

        .article-inline-item__type {
            display: block;
            color: #d17a00;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .article-inline-item__arrow {
            position: absolute;
            right: 11px;
            bottom: 9px;
            color: #5d56d9;
        }

        .article-inline-item--job .article-inline-item__type {
            color: #0b8f68;
        }

        @media (max-width: 992px) {
            .article-grid {
                grid-template-columns: 1fr;
            }

            .related-sidebar {
                position: static;
                margin-top: 40px;
            }
        }

        @media (max-width: 640px) {
            .article-wrapper {
                padding-top: 20px;
            }

            .article-content h1 {
                font-size: 1.75rem;
            }

            .article-content {
                border-radius: 14px;
                padding: 21px 17px;
            }

            .article-content .featured-image {
                max-height: 250px;
            }

            .article-share {
                align-items: flex-start;
                flex-direction: column;
            }

            .article-inline-related__grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container article-wrapper">
        <div class="article-grid">

            {{-- Artikel Utama --}}
            <div class="article-content">
                <span class="article-kicker">Artikel Bankir Academy</span>
                <h1>{{ $article->title }}</h1>
                <div class="article-meta">
                    <span><i class="far fa-calendar-alt mr-1"></i>{{ optional($article->created_at)->translatedFormat('d F Y') }}</span>
                    <span><i class="far fa-eye mr-1"></i>{{ number_format($article->views) }} kali dibaca</span>
                    @if ($article->keyword)
                        <span><i class="fas fa-tag mr-1"></i>{{ $article->keyword }}</span>
                    @endif
                </div>

                @php
                    $mainImg = !empty($article->image_base64)
                        ? $article->image_base64
                        : (!empty($article->image_url)
                            ? $article->image_url
                            : null);
                @endphp

                @if ($mainImg)
                    <img src="{{ $mainImg }}" alt="{{ $article->title }}" class="featured-image"
                        referrerpolicy="no-referrer" />
                @endif

                <div class="article-body">
                    @forelse ($contentParts as $index => $part)
                        {!! $part !!}
                        @if ($index + 1 === $insertAt)
                            @include('articles.partials.inline-related')
                        @endif
                    @empty
                        <p>Konten artikel belum tersedia.</p>
                    @endforelse
                    @if (count($contentParts) > 0 && $insertAt > count($contentParts))
                        @include('articles.partials.inline-related')
                    @endif
                </div>

                @include('frontend.partials.cv-ats-cta')

                <div class="article-share">
                    <span class="article-share__label">Bagikan artikel ini</span>
                    <div class="article-share__actions">
                        <button type="button" class="article-share__button article-share__button--copy"
                            data-copy-article-link title="Salin tautan"><i class="fas fa-link"></i></button>
                        <a class="article-share__button article-share__button--wa" target="_blank" rel="noopener"
                            href="https://wa.me/?text={{ rawurlencode($article->title . ' ' . $canonicalUrl) }}"
                            title="Bagikan ke WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a class="article-share__button article-share__button--fb" target="_blank" rel="noopener"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($canonicalUrl) }}"
                            title="Bagikan ke Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="article-share__button article-share__button--x" target="_blank" rel="noopener"
                            href="https://twitter.com/intent/tweet?text={{ rawurlencode($article->title) }}&url={{ rawurlencode($canonicalUrl) }}"
                            title="Bagikan ke X"><i class="fab fa-twitter"></i></a>
                        <a class="article-share__button article-share__button--in" target="_blank" rel="noopener"
                            href="https://www.linkedin.com/sharing/share-offsite/?url={{ rawurlencode($canonicalUrl) }}"
                            title="Bagikan ke LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a class="article-share__button article-share__button--tg" target="_blank" rel="noopener"
                            href="https://t.me/share/url?url={{ rawurlencode($canonicalUrl) }}&text={{ rawurlencode($article->title) }}"
                            title="Bagikan ke Telegram"><i class="fab fa-telegram-plane"></i></a>
                    </div>
                </div>
            </div>

            {{-- Sidebar Artikel Terkait --}}
            <aside class="related-sidebar">
                <h3>Artikel Terkait</h3>
                <div class="related-list">
                    @forelse ($relatedArticles as $related)
                        <a href="{{ route('frontend.articles.show', $related->slug) }}" class="related-item">
                            @php
                                $sideImg = !empty($related->image_base64)
                                    ? $related->image_base64
                                    : (!empty($related->image_url)
                                        ? $related->image_url
                                        : 'https://via.placeholder.com/80x60?text=No+Image');
                            @endphp

                            <img src="{{ $sideImg }}" alt="{{ $related->title }}" class="related-image"
                                referrerpolicy="no-referrer" />

                            <div class="related-item-title">{{ $related->title }}</div>
                        </a>
                    @empty
                        <p style="font-size: 0.9rem; color: #718096;">Tidak ada artikel terkait lainnya.</p>
                    @endforelse
                </div>
            </aside>

        </div>
    </div>
@endsection

@push('frontend-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButton = document.querySelector('[data-copy-article-link]');
            if (!copyButton) return;

            copyButton.addEventListener('click', async function() {
                try {
                    await navigator.clipboard.writeText(window.location.href);
                    copyButton.innerHTML = '<i class="fas fa-check"></i>';
                    setTimeout(() => copyButton.innerHTML = '<i class="fas fa-link"></i>', 1600);
                } catch (error) {
                    window.prompt('Salin tautan artikel:', window.location.href);
                }
            });
        });
    </script>
@endpush
