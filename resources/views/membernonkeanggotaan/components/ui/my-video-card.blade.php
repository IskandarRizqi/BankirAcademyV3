@php
    $video = $video ?? null;
    $title = data_get($video, 'nama', 'Video Tanpa Nama');
    $description = trim(strip_tags((string) data_get($video, 'keterangan', '')));
    $description = $description !== ''
        ? \Illuminate\Support\Str::limit($description, 80)
        : 'Materi video pembelajaran untuk mendukung proses belajar Anda.';
    $thumbnail = data_get($video, 'thumbnail');
    $watchUrl = route('video.belajar', [$video->id]);
@endphp

@once
<style>
    .member-video-card {
        display: flex;
        flex-direction: column;
        border-radius: 16px;
        border: 1px solid #e7e9f0;
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .03);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .member-video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(185, 28, 28, .12);
    }

    .member-video-card__media {
        display: block;
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        background: linear-gradient(135deg, #1e293b, #0f172a);
        overflow: hidden;
    }

    .member-video-card__media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .2s ease;
    }

    .member-video-card:hover .member-video-card__media img {
        transform: scale(1.03);
    }

    .member-video-card__placeholder {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4F46E5;
        font-size: 2.8rem;
    }

    .member-video-card__body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .member-video-card__title {
        margin: 0 0 8px;
        color: #111827;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .member-video-card__description {
        margin: 0 0 14px;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .member-video-card__footer {
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .member-video-card__meta {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .member-video-card__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        background: var(--primary, #4F46E5);
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color .18s ease;
    }

    .member-video-card__button:hover {
        background: var(--primary-dark, #3D33D8);
        color: #ffffff;
    }

    @media (max-width: 575.98px) {
        .member-video-card__footer {
            align-items: stretch;
            flex-direction: column;
        }

        .member-video-card__button {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .member-video-card,
        .member-video-card *,
        .member-video-card__button {
            transition: none !important;
        }
    }
</style>
@endonce

<article class="member-video-card" role="listitem">
    <a href="{{ $watchUrl }}" class="member-video-card__media" aria-label="Tonton {{ $title }}">
        @if($thumbnail && file_exists(public_path($thumbnail)))
            <img src="{{ asset($thumbnail) }}" alt="{{ $title }}" loading="lazy">
        @else
            <div class="member-video-card__placeholder" aria-hidden="true">
                <i class="fas fa-play-circle"></i>
            </div>
        @endif
    </a>

    <div class="member-video-card__body">
        <h3 class="member-video-card__title">
            <a href="{{ $watchUrl }}" class="text-reset text-decoration-none">{{ $title }}</a>
        </h3>
        <p class="member-video-card__description">{{ $description }}</p>

        <div class="member-video-card__footer">
            <span class="member-video-card__meta">
                <i class="fas fa-play-circle text-primary mr-1" aria-hidden="true"></i>
                {{ $video->items->count() }} Modul Video
            </span>
            <a href="{{ $watchUrl }}" class="member-video-card__button">
                Tonton Video <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</article>
