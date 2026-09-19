@extends('layouts.appfrontend')

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

            .article-content .featured-image {
                max-height: 250px;
            }
        }
    </style>

    <div class="container article-wrapper">
        <div class="article-grid">

            {{-- Artikel Utama --}}
            <div class="article-content">
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

                {!! $article->content !!}
            </div>

            {{-- Sidebar Artikel Terkait --}}
            <aside class="related-sidebar">
                <h3>Artikel Terkait</h3>
                <div class="related-list">
                    @forelse ($relatedArticles as $related)
                        <a href="{{ route('articles.publicShow', $related->slug) }}" class="related-item">
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
