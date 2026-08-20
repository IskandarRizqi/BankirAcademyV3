@extends('layouts.appmembernonanggota')

@section('title', 'Lowongan Kerja')

@section('content')
    <style>
        .loker-page {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .loker-hero {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: clamp(24px, 5vw, 42px);
            background:
                radial-gradient(circle at 84% 18%, rgba(129, 140, 248, .35), transparent 28%),
                linear-gradient(135deg, #111827 0%, #312e81 55%, #4f46e5 100%);
            color: #ffffff;
            box-shadow: 0 20px 48px rgba(49, 46, 129, .2);
        }

        .loker-hero::after {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 38px 38px;
            content: "";
            mask-image: linear-gradient(90deg, transparent, #000 22%, #000 88%, transparent);
            pointer-events: none;
        }

        .loker-hero__content {
            position: relative;
            z-index: 1;
            max-width: 760px;
        }

        .loker-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .9);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .loker-hero__title {
            margin: 0;
            font-size: clamp(28px, 4vw, 46px);
            font-weight: 900;
            letter-spacing: -.05em;
            line-height: 1.05;
        }

        .loker-hero__description {
            max-width: 650px;
            margin: 14px 0 0;
            color: rgba(255, 255, 255, .84);
            font-size: 15px;
            line-height: 1.7;
        }

        .loker-layout {
            display: grid;
            grid-template-columns: 240px minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .loker-filter-card {
            position: sticky;
            top: calc(var(--topbar-h, 68px) + 18px);
            padding: 16px;
            border: 1px solid #e7e9f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
        }

        .loker-filter-card__title {
            margin: 0 0 3px;
            color: #111827;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: -.02em;
        }

        .loker-filter-card__subtitle {
            margin: 0 0 16px;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.5;
        }

        .loker-filter-field {
            margin-bottom: 12px;
        }

        .loker-filter-field label {
            display: block;
            margin-bottom: 5px;
            color: #4b5563;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .loker-filter-control {
            width: 100%;
            min-height: 42px;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            outline: none;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
            font-weight: 600;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .loker-filter-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .12);
        }

        .loker-filter-card .select2-container {
            width: 100% !important;
        }

        .loker-filter-card .select2-container--default .select2-selection--single {
            min-height: 42px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: #ffffff;
        }

        .loker-filter-card .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 7px 30px 7px 10px;
            color: #111827;
            font-size: 13px;
            font-weight: 600;
            line-height: 26px;
        }

        .loker-filter-card .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px;
            right: 8px;
        }

        .loker-filter-card .select2-container--default.select2-container--focus .select2-selection--single,
        .loker-filter-card .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .12);
        }

        .loker-filter-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 16px;
        }

        .loker-filter-button,
        .loker-filter-reset {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .loker-filter-button {
            border: 0;
            background: #4f46e5;
            color: #ffffff;
            cursor: pointer;
        }

        .loker-filter-button:hover,
        .loker-filter-button:focus-visible {
            background: #3730a3;
            color: #ffffff;
        }

        .loker-filter-reset {
            background: #f3f4f6;
            color: #4b5563;
        }

        .loker-filter-reset:hover,
        .loker-filter-reset:focus-visible {
            background: #e0e7ff;
            color: #3730a3;
        }

        .loker-section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .loker-section-header h2 {
            margin: 0;
            color: #111827;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .loker-section-header p {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .loker-result-count {
            padding: 8px 14px;
            border-radius: 999px;
            background: #eef2ff;
            color: #4338ca;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .loker-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .loker-empty-state {
            padding: 44px 24px;
            border: 1px dashed #c7d2fe;
            border-radius: 18px;
            background: #f8faff;
            text-align: center;
        }

        .loker-empty-state__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            margin-bottom: 14px;
            border-radius: 16px;
            background: #e0e7ff;
            color: #4338ca;
            font-size: 22px;
        }

        .loker-empty-state h3 {
            margin: 0;
            color: #111827;
            font-size: 18px;
            font-weight: 900;
        }

        .loker-empty-state p {
            max-width: 520px;
            margin: 8px auto 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .loker-membership-cta {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 18px;
            align-items: center;
            padding: 22px;
            border: 1px solid #c7d2fe;
            border-radius: 18px;
            background: linear-gradient(135deg, #eef2ff, #ffffff 75%);
        }

        .loker-membership-cta__eyebrow {
            margin: 0 0 5px;
            color: #4338ca;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .loker-membership-cta h3 {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -.025em;
        }

        .loker-membership-cta p {
            max-width: 680px;
            margin: 6px 0 0;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.6;
        }

        .loker-membership-cta__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
        }

        .loker-membership-cta__button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border: 0;
            border-radius: 10px;
            background: #111827;
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            transition: background .18s ease, transform .18s ease;
        }

        .loker-membership-cta__button--secondary {
            background: #ffffff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
        }

        .loker-membership-cta__button:hover,
        .loker-membership-cta__button:focus-visible {
            background: #4f46e5;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .loker-infinite-scroll {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 72px;
            margin-top: 18px;
        }

        .loker-load-more-button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
            background: #ffffff;
            color: #3730a3;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .loker-load-more-button:hover,
        .loker-load-more-button:focus-visible {
            border-color: #4f46e5;
            background: #4f46e5;
            color: #ffffff;
        }

        .loker-load-more-button:disabled {
            cursor: wait;
            opacity: .65;
        }

        .loker-load-status {
            color: #6b7280;
            font-size: 13px;
            font-weight: 700;
        }

        @media (max-width: 1199.98px) {
            .loker-layout {
                grid-template-columns: 220px minmax(0, 1fr);
            }

            .loker-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .loker-layout {
                grid-template-columns: 1fr;
            }

            .loker-filter-card {
                position: static;
            }

            .loker-section-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .loker-membership-cta {
                grid-template-columns: 1fr;
            }

            .loker-membership-cta__actions {
                justify-content: stretch;
            }

            .loker-membership-cta__button {
                flex: 1 1 180px;
            }
        }

        @media (max-width: 575.98px) {
            .loker-grid {
                grid-template-columns: 1fr;
            }

            .loker-filter-actions {
                grid-template-columns: 1fr;
            }

            .loker-result-count {
                white-space: normal;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .loker-membership-cta__button {
                transition: none;
            }

            .loker-membership-cta__button:hover {
                transform: none;
            }
        }
    </style>

    <div class="loker-page">
        <section class="loker-hero" aria-labelledby="loker-page-title">
            <div class="loker-hero__content">
                <span class="loker-hero__eyebrow">
                    <i class="fas fa-briefcase" aria-hidden="true"></i>
                    Career Center
                </span>
                <h1 class="loker-hero__title" id="loker-page-title">Temukan peluang karier berikutnya</h1>
                <p class="loker-hero__description">
                    Jelajahi lowongan aktif dari perusahaan mitra Bankir Academy dan temukan posisi yang sesuai dengan
                    kompetensi Anda.
                </p>
            </div>
        </section>

        <div class="loker-layout">
            <aside class="loker-filter-card" aria-label="Filter lowongan kerja">
                <h2 class="loker-filter-card__title">Filter Lowongan</h2>
                <p class="loker-filter-card__subtitle">Gunakan filter untuk menemukan peluang yang paling sesuai.</p>

                <form method="GET" action="{{ route('membernonanggota.loker.index') }}">
                    <div class="loker-filter-field">
                        <label for="loker-search">Cari lowongan</label>
                        <input class="loker-filter-control" type="search" id="loker-search" name="q"
                            value="{{ $filters['q'] }}" placeholder="Contoh: Relationship Manager">
                    </div>

                    <div class="loker-filter-field">
                        <label for="loker-type">Tipe pekerjaan</label>
                        <select class="loker-filter-control" id="loker-type" name="type">
                            <option value="">Semua tipe</option>
                            @foreach ($filterOptions['type'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $filters['type'] === (string) $value ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="loker-filter-field">
                        <label for="loker-skill">Skill</label>
                        <select class="loker-filter-control" id="loker-skill" name="skill">
                            <option value="">Semua skill</option>
                            @foreach ($filterOptions['skill'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $filters['skill'] === (string) $value ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="loker-filter-field">
                        <label for="loker-province">Provinsi</label>
                        <select class="loker-filter-control loker-filter-select2" id="loker-province" name="provinsi">
                            <option value="">Semua provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ $filters['provinsi'] === (string) $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="loker-filter-field">
                        <label for="loker-city">Kabupaten / kota</label>
                        <select class="loker-filter-control loker-filter-select2" id="loker-city" name="kabupaten"
                            {{ $filters['provinsi'] === '' ? 'disabled' : '' }}>
                            <option value="">Semua kabupaten / kota</option>
                            @if ($selectedCityName)
                                <option value="{{ $filters['kabupaten'] }}" selected>{{ $selectedCityName }}</option>
                            @endif
                        </select>
                    </div>

                    <div class="loker-filter-actions">
                        <button class="loker-filter-button" type="submit">Terapkan</button>
                        <a class="loker-filter-reset" href="{{ route('membernonanggota.loker.index') }}">Reset</a>
                    </div>
                </form>
            </aside>

            <section aria-labelledby="loker-list-title">
                <div class="loker-section-header">
                    <div>
                        <h2 id="loker-list-title">Lowongan tersedia</h2>
                        <p>{{ $isMember ? 'Akses lowongan aktif dari perusahaan mitra.' : 'Peluang pilihan untuk memulai perjalanan karier Anda.' }}
                        </p>
                    </div>
                    {{-- <span class="loker-result-count">
                    @if ($isMember)
                        {{ $lokers->total() }} lowongan
                    @else
                        {{ $lokers->count() }} dari {{ $nonMembershipLimit }} lowongan
                    @endif
                </span> --}}
                </div>

                @if ($lokers->count() > 0)
                    <div class="loker-grid" id="lokerGrid">
                        @include('membernonkeanggotaan.components.ui.loker-card-items', [
                            'lokers' => $lokers,
                        ])

                        @for ($index = 0; $index < $lokerSkeletonCount; $index++)
                            @include('membernonkeanggotaan.components.ui.loker-skeleton-card')
                        @endfor
                    </div>

                    @if (method_exists($lokers, 'hasPages') && $lokers->hasPages())
                        <div class="loker-infinite-scroll" id="lokerInfiniteScroll"
                            data-next-url="{{ $lokers->nextPageUrl() }}">
                            <button type="button" class="loker-load-more-button" id="lokerLoadMoreButton">Muat lowongan
                                lainnya</button>
                            <span class="loker-load-status" id="lokerLoadStatus" hidden>Memuat lowongan...</span>
                        </div>
                    @endif
                @else
                    <div class="loker-empty-state">
                        <span class="loker-empty-state__icon" aria-hidden="true"><i class="fas fa-search"></i></span>
                        <h3>Belum ada lowongan yang sesuai</h3>
                        <p>Ubah kata kunci atau filter Anda untuk melihat peluang karier lain yang masih tersedia.</p>
                    </div>
                @endif
            </section>
        </div>

        @if (!$isMember)
            <section class="loker-membership-cta" aria-labelledby="loker-membership-title">
                <div>
                    <p class="loker-membership-cta__eyebrow">Buka akses lebih luas</p>
                    <h3 id="loker-membership-title">Ingin melihat lebih banyak peluang karier?</h3>
                    <p>
                        Non-member dapat melihat maksimal {{ $nonMembershipLimit }} lowongan. Bergabung sebagai member
                        untuk mendapatkan akses lowongan yang lebih lengkap dan manfaat karier lainnya.
                    </p>
                </div>
                <div class="loker-membership-cta__actions">
                    <button type="button" class="loker-membership-cta__button loker-membership-cta__button--secondary"
                        data-toggle="modal" data-target="#membershipPackageModal">
                        Member perusahaan
                    </button>
                    <button type="button" class="loker-membership-cta__button" data-toggle="modal"
                        data-target="#membershipIndividualModal">
                        Member perorangan
                    </button>
                </div>
            </section>

            @include('membernonkeanggotaan.components.ui.membership-package-modal')
            @include('membernonkeanggotaan.components.ui.membership-individual-modal')
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const provinceSelect = $('#loker-province');
            const citySelect = $('#loker-city');

            if (!provinceSelect.length || !citySelect.length || typeof $.fn.select2 !== 'function') {
                return;
            }

            provinceSelect.select2({
                width: '100%',
                placeholder: 'Semua provinsi',
                allowClear: true
            });

            citySelect.select2({
                width: '100%',
                placeholder: 'Semua kabupaten / kota',
                allowClear: true,
                ajax: {
                    url: '{{ route('membernonanggota.loker.cities') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term || '',
                            page: params.page || 1,
                            provinsi_id: provinceSelect.val() || ''
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results || [],
                            pagination: data.pagination || {
                                more: false
                            }
                        };
                    },
                    cache: true
                }
            });

            function syncCityState(resetValue) {
                const hasProvince = Boolean(provinceSelect.val());

                if (resetValue) {
                    citySelect.val(null).trigger('change');
                }

                citySelect.prop('disabled', !hasProvince);
            }

            provinceSelect.on('change', function() {
                syncCityState(true);
            });

            syncCityState(false);
        })();

        (function() {
            const grid = document.getElementById('lokerGrid');
            const loader = document.getElementById('lokerInfiniteScroll');
            const loadMoreButton = document.getElementById('lokerLoadMoreButton');
            const loadStatus = document.getElementById('lokerLoadStatus');

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
                        throw new Error('Gagal memuat data lowongan.');
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
                observer = new IntersectionObserver(function(entries) {
                    if (entries.some(function(entry) {
                            return entry.isIntersecting;
                        })) {
                        loadNextPage();
                    }
                }, {
                    rootMargin: '360px 0px'
                });

                observer.observe(loader);
            }
        })();
    </script>
@endpush
