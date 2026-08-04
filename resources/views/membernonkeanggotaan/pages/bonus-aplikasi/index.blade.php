@extends('layouts.appmembernonanggota')

@section('title', 'Bonus Aplikasi Pendukung')

@section('content')
<style>
    .bonus-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .bonus-hero {
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

    .bonus-hero::after {
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

    .bonus-hero__content {
        position: relative;
        z-index: 1;
        max-width: 760px;
    }

    .bonus-hero__eyebrow {
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

    .bonus-hero__title {
        margin: 0;
        font-size: clamp(28px, 4vw, 46px);
        font-weight: 900;
        letter-spacing: -.05em;
        line-height: 1.05;
    }

    .bonus-hero__description {
        max-width: 620px;
        margin: 14px 0 0;
        color: rgba(255, 255, 255, .82);
        font-size: 15px;
        line-height: 1.7;
    }

    .bonus-content {
        min-width: 0;
    }

    .bonus-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .bonus-section-header h2 {
        margin: 0;
        color: #111827;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -.03em;
    }

    .bonus-section-header p {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .bonus-result-count {
        padding: 8px 14px;
        border-radius: 999px;
        background: #eef0fe;
        color: #4f46e5;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .bonus-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .bonus-card {
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

    .bonus-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
    }

    .bonus-card--upcoming {
        border-color: #d1d5db;
        background: #f3f4f6;
        box-shadow: none;
    }

    .bonus-card--upcoming:hover {
        transform: none;
        border-color: #d1d5db;
        box-shadow: none;
    }

    .bonus-card__media {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 3 / 2;
        overflow: hidden;
        background: #f8fafc;
    }

    .bonus-card__media img {
        width: 100%;
        height: 100%;
        padding: 10px;
        object-fit: contain;
    }

    .bonus-card--upcoming .bonus-card__media img {
        filter: grayscale(1);
        opacity: .62;
    }

    .bonus-card__placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        border: 1px solid #e0e7ff;
        border-radius: 20px;
        background: #eef0fe;
        color: #4f46e5;
        font-size: 30px;
    }

    .bonus-card--upcoming .bonus-card__media {
        background: #d1d5db;
    }

    .bonus-card--upcoming .bonus-card__placeholder {
        border-color: rgba(75, 85, 99, .22);
        background: rgba(255, 255, 255, .34);
        color: #4b5563;
    }

    .bonus-card__upcoming-badge {
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

    .bonus-card__body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 16px;
    }

    .bonus-card__title {
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

    .bonus-card__description {
        display: -webkit-box;
        margin: 0;
        overflow: hidden;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.55;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .bonus-card__footer {
        display: block;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .bonus-card--upcoming .bonus-card__footer {
        border-top-color: #e5e7eb;
    }

    .bonus-card__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        min-height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        background: #4f46e5;
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        transition: background-color .18s ease;
    }

    .bonus-card__button:hover,
    .bonus-card__button:focus-visible {
        background: #3730a3;
        color: #ffffff;
    }

    .bonus-card__button--disabled {
        background: #9ca3af;
        color: #f9fafb;
        cursor: not-allowed;
    }

    .bonus-empty-state {
        padding: 48px 24px;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
        background: #ffffff;
        text-align: center;
    }

    .bonus-empty-state h3 {
        margin: 12px 0 0;
        color: #111827;
        font-size: 20px;
        font-weight: 900;
    }

    .bonus-empty-state p {
        max-width: 460px;
        margin: 8px auto 0;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.6;
    }

    .bonus-infinite-scroll {
        display: flex;
        justify-content: center;
        min-height: 44px;
        margin-top: 22px;
    }

    .bonus-load-more {
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

    .bonus-load-more:disabled {
        cursor: wait;
        opacity: .72;
    }

    .bonus-load-more[hidden],
    .bonus-load-status[hidden] {
        display: none;
    }

    .bonus-load-status {
        align-self: center;
        color: #6b7280;
        font-size: 13px;
        font-weight: 700;
    }

    @media (max-width: 1199.98px) {
        .bonus-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .bonus-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .bonus-hero {
            padding: 22px;
            border-radius: 20px;
        }

        .bonus-section-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .bonus-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .bonus-card,
        .bonus-card__button {
            transition: none;
        }
    }
</style>

<div class="bonus-page">
    <section class="bonus-hero" aria-labelledby="bonus-page-title">
        <div class="bonus-hero__content">
            <span class="bonus-hero__eyebrow"><i class="fas fa-tools" aria-hidden="true"></i> Company Learning Library</span>
            <h1 class="bonus-hero__title" id="bonus-page-title">Bonus aplikasi pendukung</h1>
            <p class="bonus-hero__description">
                Manfaatkan aplikasi pendukung yang disiapkan untuk membantu aktivitas kerja dan pembelajaran Anda.
            </p>
        </div>
    </section>

    <section class="bonus-content" aria-labelledby="bonus-list-title">
        <div class="bonus-section-header">
            <div>
                <h2 id="bonus-list-title">Daftar bonus aplikasi</h2>
                <p>Aplikasi terbaru ditampilkan lebih dahulu.</p>
            </div>
            @if(method_exists($bonusAplikasi, 'total'))
                <span class="bonus-result-count">{{ $bonusAplikasi->total() }} aplikasi tersedia</span>
            @endif
        </div>

        @if($bonusAplikasi->count() > 0)
            <div class="bonus-grid" id="bonusGrid">
                @include('membernonkeanggotaan.components.ui.bonus-aplikasi-card-items', ['bonusAplikasi' => $bonusAplikasi])
            </div>

            @if($bonusAplikasi->hasPages())
                <div class="bonus-infinite-scroll" id="bonusInfiniteScroll" data-next-url="{{ $bonusAplikasi->nextPageUrl() }}">
                    <button type="button" class="bonus-load-more" id="bonusLoadMoreButton">Muat aplikasi lainnya</button>
                    <span class="bonus-load-status" id="bonusLoadStatus" hidden>Memuat aplikasi...</span>
                </div>
            @endif
        @else
            <div class="bonus-empty-state">
                <i class="fas fa-toolbox fa-3x text-muted" aria-hidden="true"></i>
                <h3>Belum ada bonus aplikasi</h3>
                <p>Bonus aplikasi pendukung belum tersedia untuk saat ini.</p>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const grid = document.getElementById('bonusGrid');
        const loader = document.getElementById('bonusInfiniteScroll');
        const loadMoreButton = document.getElementById('bonusLoadMoreButton');
        const loadStatus = document.getElementById('bonusLoadStatus');

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
                    throw new Error('Gagal memuat bonus aplikasi.');
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
