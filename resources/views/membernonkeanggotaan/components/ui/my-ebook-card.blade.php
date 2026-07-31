@php
    $ebook = $ebook ?? null;
    $title = data_get($ebook, 'nama', 'Ebook Tanpa Nama');
    $description = trim(strip_tags((string) data_get($ebook, 'keterangan', '')));
    $description = $description !== ''
        ? \Illuminate\Support\Str::limit($description, 80)
        : 'Materi bacaan digital untuk mendukung pembelajaran Anda.';
    $thumbnail = data_get($ebook, 'thumbnail');
    $detailUrl = route('ebook.belajar', [$ebook->id]);
@endphp

@once
<style>
    .member-ebook-card {
        display: flex;
        flex-direction: column;
        border-radius: 16px;
        border: 1px solid #e7e9f0;
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .03);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .member-ebook-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
    }

    .member-ebook-card__media {
        display: block;
        position: relative;
        width: 100%;
        aspect-ratio: 3 / 2;
        background: #f3f4f6;
        overflow: hidden;
    }

    .member-ebook-card__media img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .member-ebook-card__placeholder {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 2.8rem;
    }

    .member-ebook-card__body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .member-ebook-card__title {
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

    .member-ebook-card__description {
        margin: 0 0 14px;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .member-ebook-card__footer {
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .member-ebook-card__meta {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .member-ebook-card__button {
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

    .member-ebook-card__button:hover {
        background: var(--primary-dark, #3D33D8);
        color: #ffffff;
    }

    @media (max-width: 575.98px) {
        .member-ebook-card__footer {
            align-items: stretch;
            flex-direction: column;
        }

        .member-ebook-card__button {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .member-ebook-card,
        .member-ebook-card *,
        .member-ebook-card__button {
            transition: none !important;
        }
    }
</style>
@endonce

<article class="member-ebook-card" role="listitem">
    <a href="{{ $detailUrl }}" class="member-ebook-card__media" aria-label="Baca {{ $title }}">
        @if($thumbnail && file_exists(public_path($thumbnail)))
            <img src="{{ asset($thumbnail) }}" alt="{{ $title }}" loading="lazy">
        @else
            <div class="member-ebook-card__placeholder" aria-hidden="true">
                <i class="fas fa-file-pdf"></i>
            </div>
        @endif
    </a>

    <div class="member-ebook-card__body">
        <h3 class="member-ebook-card__title">
            <a href="{{ $detailUrl }}" class="text-reset text-decoration-none">{{ $title }}</a>
        </h3>
        <p class="member-ebook-card__description">{{ $description }}</p>

        <div class="member-ebook-card__footer">
            <span class="member-ebook-card__meta">
                <i class="fas fa-file-alt text-emerald-600 mr-1" aria-hidden="true"></i>
                {{ $ebook->items->count() }} Modul PDF
            </span>
            <a href="{{ $detailUrl }}" class="member-ebook-card__button">
                Baca Ebook <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</article>
