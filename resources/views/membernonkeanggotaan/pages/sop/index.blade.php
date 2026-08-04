@extends('layouts.appmembernonanggota')

@section('title', 'SOP Perusahaan')

@section('content')
<style>
    .sop-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .sop-hero {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        padding: 28px;
        background:
            radial-gradient(circle at 82% 18%, rgba(6, 182, 212, .26), transparent 30%),
            linear-gradient(135deg, #111827 0%, #312e81 52%, #4f46e5 100%);
        color: #ffffff;
        box-shadow: 0 20px 48px rgba(49, 46, 129, .18);
    }

    .sop-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
        background-size: 38px 38px;
        mask-image: linear-gradient(90deg, transparent, #000 22%, #000 88%, transparent);
        pointer-events: none;
    }

    .sop-hero__content {
        position: relative;
        z-index: 1;
        max-width: 760px;
    }

    .sop-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        padding: 7px 12px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 999px;
        background: rgba(255, 255, 255, .12);
        color: rgba(255, 255, 255, .9);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .sop-hero__title {
        margin: 0;
        font-size: clamp(28px, 4vw, 46px);
        font-weight: 900;
        letter-spacing: -.05em;
        line-height: 1.05;
    }

    .sop-hero__description {
        max-width: 620px;
        margin: 14px 0 0;
        color: rgba(255, 255, 255, .82);
        font-size: 15px;
        line-height: 1.7;
    }

    .sop-search {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
        padding: 12px;
        border: 1px solid #e7e9f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
    }

    .sop-search__input {
        min-width: 0;
        flex: 1;
        height: 42px;
        padding: 0 12px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        background: #ffffff;
        color: #111827;
        font-size: 13px;
        outline: none;
    }

    .sop-search__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 0 15px;
        border: 0;
        border-radius: 9px;
        background: #4f46e5;
        color: #ffffff;
        font-size: 12px;
        font-weight: 900;
        cursor: pointer;
        white-space: nowrap;
    }

    .sop-content {
        min-width: 0;
    }

    .sop-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .sop-section-header h2 {
        margin: 0;
        color: #111827;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -.03em;
    }

    .sop-section-header p {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .sop-result-count {
        padding: 8px 14px;
        border-radius: 999px;
        background: #eef0fe;
        color: #4f46e5;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sop-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .sop-card {
        display: flex;
        min-width: 0;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #e7e9f0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .03);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .sop-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
    }

    .sop-card--upcoming {
        border-color: #d1d5db;
        background: #f3f4f6;
        box-shadow: none;
    }

    .sop-card--upcoming:hover {
        transform: none;
        border-color: #d1d5db;
        box-shadow: none;
    }

    .sop-card__media {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 3 / 2;
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .sop-card--upcoming .sop-card__media {
        background: #d1d5db;
    }

    .sop-card__media-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 20px;
        background: rgba(255, 255, 255, .1);
        color: #ffffff;
        font-size: 30px;
    }

    .sop-card--upcoming .sop-card__media-icon {
        border-color: rgba(75, 85, 99, .22);
        background: rgba(255, 255, 255, .34);
        color: #4b5563;
    }

    .sop-card__media-icon img {
        width: 44px;
        height: 44px;
        object-fit: contain;
    }

    .sop-card__upcoming-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        display: inline-flex;
        align-items: center;
        min-height: 32px;
        padding: 7px 12px;
        border: 1px solid rgba(239, 68, 68, .34);
        border-radius: 999px;
        background: rgba(254, 226, 226, .96);
        color: #b91c1c;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .02em;
    }

    .sop-card__body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 16px;
    }

    .sop-card__title {
        display: -webkit-box;
        margin: 0 0 8px;
        overflow: hidden;
        color: #111827;
        font-size: 17px;
        font-weight: 850;
        line-height: 1.3;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .sop-card__description {
        display: -webkit-box;
        margin: 0;
        overflow: hidden;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.55;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .sop-card__footer {
        display: block;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .sop-card--upcoming .sop-card__footer {
        border-top-color: #e5e7eb;
    }

    .sop-card__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        min-height: 36px;
        padding: 8px 12px;
        border-radius: 8px;
        background: #4f46e5;
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        transition: background-color .18s ease;
        white-space: nowrap;
    }

    .sop-card__button:hover,
    .sop-card__button:focus-visible {
        background: #3730a3;
        color: #ffffff;
    }

    .sop-empty-state {
        padding: 48px 24px;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
        background: #ffffff;
        text-align: center;
    }

    .sop-empty-state h3 {
        margin: 12px 0 0;
        color: #111827;
        font-size: 20px;
        font-weight: 900;
    }

    .sop-empty-state p {
        max-width: 460px;
        margin: 8px auto 0;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.6;
    }

    .sop-infinite-scroll {
        display: flex;
        justify-content: center;
        min-height: 44px;
        margin-top: 22px;
    }

    .sop-load-more {
        min-height: 42px;
        padding: 10px 18px;
        border: 0;
        border-radius: 999px;
        background: #eef0fe;
        color: #4f46e5;
        font-size: 13px;
        font-weight: 850;
        cursor: pointer;
    }

    .sop-load-more:disabled {
        cursor: wait;
        opacity: .72;
    }

    .sop-load-more[hidden],
    .sop-load-status[hidden] {
        display: none;
    }

    .sop-load-status {
        align-self: center;
        color: #6b7280;
        font-size: 13px;
        font-weight: 700;
    }

    @media (max-width: 1199.98px) {
        .sop-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .sop-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .sop-hero {
            padding: 22px;
            border-radius: 20px;
        }

        .sop-search {
            align-items: stretch;
            flex-direction: column;
        }

        .sop-search__input {
            width: 100%;
            flex: 0 0 auto;
            min-height: 48px;
        }

        .sop-search__button {
            width: 100%;
            min-height: 48px;
        }

        .sop-section-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .sop-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .sop-card,
        .sop-card__button {
            transition: none;
        }
    }
</style>

<div class="sop-page">
    <section class="sop-hero" aria-labelledby="sop-page-title">
        <div class="sop-hero__content">
            <span class="sop-hero__eyebrow"><i class="fas fa-file-alt" aria-hidden="true"></i> Company Learning Library</span>
            <h1 class="sop-hero__title" id="sop-page-title">Standar operasional perusahaan</h1>
            <p class="sop-hero__description">
                Temukan panduan kerja dan dokumen SOP perusahaan dalam satu tempat agar aktivitas operasional berjalan konsisten.
            </p>

        </div>
    </section>

    <section class="sop-content" aria-labelledby="sop-list-title">
        <form method="GET" action="{{ route('membernonanggota.sop.index') }}" class="sop-search" role="search">
            <label class="sr-only" for="sop-search-input">Cari judul SOP</label>
            <input
                type="search"
                id="sop-search-input"
                name="q"
                class="sop-search__input"
                value="{{ $search }}"
                placeholder="Cari nama atau judul SOP..."
                autocomplete="off">
            <button type="submit" class="sop-search__button">
                <i class="fas fa-search" aria-hidden="true"></i> Cari SOP
            </button>
        </form>

        <div class="sop-section-header">
            <div>
                <h2 id="sop-list-title">Daftar SOP</h2>
                <p>Dokumen terbaru ditampilkan lebih dahulu.</p>
            </div>
            @if(method_exists($sops, 'total'))
                <span class="sop-result-count">{{ $sops->total() }} SOP tersedia</span>
            @endif
        </div>

        @if($sops->count() > 0)
            <div class="sop-grid" id="sopGrid">
                @include('membernonkeanggotaan.components.ui.sop-card-items', ['sops' => $sops])
            </div>

            @if($sops->hasPages())
                <div class="sop-infinite-scroll" id="sopInfiniteScroll" data-next-url="{{ $sops->nextPageUrl() }}">
                    <button type="button" class="sop-load-more" id="sopLoadMoreButton">Muat SOP lainnya</button>
                    <span class="sop-load-status" id="sopLoadStatus" hidden>Memuat SOP...</span>
                </div>
            @endif
        @else
            <div class="sop-empty-state">
                <i class="fas fa-folder-open fa-3x text-muted" aria-hidden="true"></i>
                <h3>SOP belum ditemukan</h3>
                <p>Belum ada SOP yang sesuai dengan kata kunci pencarian Anda.</p>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const grid = document.getElementById('sopGrid');
        const loader = document.getElementById('sopInfiniteScroll');
        const loadMoreButton = document.getElementById('sopLoadMoreButton');
        const loadStatus = document.getElementById('sopLoadStatus');

        if (!grid || !loader || !loadMoreButton || !loadStatus) {
            return;
        }

        let nextUrl = loader.dataset.nextUrl;
        let isLoading = false;
        let observer = null;

        function setLoadingState(isActive) {
            isLoading = isActive;
            loadMoreButton.disabled = isActive;
            loadMoreButton.hidden = isActive;
            loadStatus.hidden = !isActive;
        }

        function finishLoading(nextPageUrl) {
            nextUrl = nextPageUrl;
            loader.dataset.nextUrl = nextPageUrl || '';
            setLoadingState(false);

            if (!nextUrl) {
                if (observer) {
                    observer.disconnect();
                }

                loader.remove();
            }
        }

        async function loadNextPage() {
            if (isLoading || !nextUrl) {
                return;
            }

            setLoadingState(true);

            try {
                const response = await fetch(nextUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    throw new Error('Gagal memuat data SOP.');
                }

                const payload = await response.json();
                grid.insertAdjacentHTML('beforeend', payload.html || '');
                finishLoading(payload.has_more_pages ? payload.next_page_url : null);
            } catch (error) {
                setLoadingState(false);
                loadMoreButton.hidden = false;
                loadMoreButton.textContent = 'Coba muat lagi';
            }
        }

        loadMoreButton.addEventListener('click', loadNextPage);

        if ('IntersectionObserver' in window) {
            observer = new IntersectionObserver(function (entries) {
                if (entries.some(function (entry) {
                    return entry.isIntersecting;
                })) {
                    loadNextPage();
                }
            }, { rootMargin: '360px 0px' });

            observer.observe(loader);
        }
    })();
</script>
@endpush
