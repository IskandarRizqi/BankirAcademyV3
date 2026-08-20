@extends('layouts.appmembernonanggota')

@section('title', 'Katalog Ebook')

@section('content')
    <style>
        .catalog-page {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .catalog-hero {
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

        .catalog-hero::after {
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

        .catalog-hero__content {
            position: relative;
            z-index: 1;
            max-width: 720px;
        }

        .catalog-hero__eyebrow {
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

        .catalog-hero__title {
            margin: 0;
            font-size: clamp(28px, 4vw, 46px);
            font-weight: 900;
            letter-spacing: -.05em;
            line-height: 1.05;
        }

        .catalog-hero__description {
            max-width: 620px;
            margin: 14px 0 0;
            color: rgba(255, 255, 255, .85);
            font-size: 15px;
            line-height: 1.7;
        }

        .catalog-layout {
            display: grid;
            grid-template-columns: 240px minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .catalog-filter-card {
            position: sticky;
            top: calc(var(--topbar-h, 68px) + 18px);
            padding: 16px;
            border: 1px solid #e7e9f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
        }

        .catalog-filter-card__title {
            margin: 0 0 2px;
            color: #111827;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: -.02em;
        }

        .catalog-filter-card__subtitle {
            margin: 0 0 14px;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.4;
        }

        .catalog-filter-field {
            margin-bottom: 12px;
        }

        .catalog-filter-field label {
            display: block;
            margin-bottom: 5px;
            color: #4b5563;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .catalog-filter-control {
            width: 100%;
            height: 38px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: #ffffff;
            color: #111827;
            padding: 0 10px;
            font-size: 12px;
            font-weight: 600;
            outline: none;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .catalog-filter-control:focus {
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, .1);
        }

        .catalog-filter-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 16px;
        }

        .catalog-filter-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            border: 0;
            border-radius: 9px;
            background: var(--primary, #4F46E5);
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .catalog-filter-reset {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            border-radius: 9px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .catalog-section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .catalog-section-header h2 {
            margin: 0;
            color: #111827;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .catalog-section-header p {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .catalog-result-count {
            padding: 8px 14px;
            border-radius: 999px;
            background: #ecfdf5;
            color: #047857;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .catalog-card {
            display: flex;
            flex-direction: column;
            border-radius: 16px;
            border: 1px solid #e7e9f0;
            background: #ffffff;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(15, 23, 42, .03);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .catalog-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
        }

        .catalog-card--upcoming {
            background: #f3f4f6;
            border-color: #d1d5db;
            box-shadow: none;
        }

        .catalog-card--upcoming:hover {
            transform: none;
            border-color: #d1d5db;
            box-shadow: none;
        }

        .catalog-card__media {
            position: relative;
            width: 100%;
            aspect-ratio: 3 / 2;
            background: #f3f4f6;
            overflow: hidden;
        }

        .catalog-card__media img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .catalog-card--upcoming .catalog-card__media img {
            filter: grayscale(1);
            opacity: .62;
        }

        .catalog-card__placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 2.8rem;
        }

        .catalog-card__badge {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(15, 23, 42, 0.75);
            color: #ffffff;
            backdrop-filter: blur(4px);
            font-weight: 800;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 11px;
            z-index: 2;
        }

        .catalog-card__badge--promo {
            background: #4F46E5;
            box-shadow: 0 2px 10px rgba(79, 70, 229, .4);
        }

        .catalog-card__upcoming-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 2;
            padding: 5px 10px;
            border-radius: 8px;
            background: #059669;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
        }

        .catalog-card__discount-tag {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #ef4444;
            color: #ffffff;
            font-weight: 900;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(239, 68, 68, .3);
            z-index: 2;
            letter-spacing: 0.02em;
        }

        .catalog-card__body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .catalog-card__title {
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

        .catalog-card__description {
            margin: 0 0 14px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Style Komponen Harga */
        .catalog-card__price-wrapper {
            margin-top: auto;
            margin-bottom: 12px;
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex-wrap: wrap;
        }

        .catalog-card__price-final {
            font-size: 16px;
            font-weight: 900;
            color: #111827;
        }

        .catalog-card__price-original {
            font-size: 12px;
            color: #9ca3af;
            text-decoration: line-through;
            font-weight: 600;
        }

        .catalog-card__footer {
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .catalog-card__meta {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
        }

        .catalog-card__button {
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
            transition: background-color .18s ease;
        }

        .catalog-card__button:hover {
            background: #047857;
            color: #ffffff;
        }

        .catalog-empty-state {
            padding: 48px 24px;
            border: 1px dashed #cbd5e1;
            border-radius: 20px;
            background: #ffffff;
            text-align: center;
        }

        .catalog-empty-state h3 {
            margin: 12px 0 0;
            color: #111827;
            font-size: 20px;
            font-weight: 900;
        }

        .catalog-empty-state p {
            max-width: 460px;
            margin: 8px auto 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 1199.98px) {
            .catalog-layout {
                grid-template-columns: 215px minmax(0, 1fr);
            }

            .catalog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .catalog-layout {
                grid-template-columns: 1fr;
            }

            .catalog-filter-card {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .catalog-hero {
                padding: 22px;
                border-radius: 20px;
            }

            .catalog-section-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .catalog-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="catalog-page">
        {{-- Hero Section --}}
        <section class="catalog-hero">
            <div class="catalog-hero__content">
                <span class="catalog-hero__eyebrow"><i class="fas fa-book-reader mr-1"></i> E-Library Academy</span>
                <h1 class="catalog-hero__title">Katalog Ebook & Dokumen Digital</h1>
                <p class="catalog-hero__description">
                    Akses modul pembelajaran, jurnal, dan e-book berkualitas dalam format digital untuk menunjang kompetensi
                    Anda.
                </p>
            </div>
        </section>

        <div class="catalog-layout">
            {{-- Filter Card --}}
            <aside class="catalog-filter-card" aria-label="Filter Ebook">
                <h2 class="catalog-filter-card__title">Filter & Urutkan</h2>
                <p class="catalog-filter-card__subtitle">Cari dan saring katalog ebook sesuai kebutuhan Anda.</p>

                <form method="GET" action="{{ url()->current() }}">
                    {{-- Input Pencarian --}}
                    <div class="catalog-filter-field">
                        <label for="ebook-search">Pencarian</label>
                        <input type="search" id="ebook-search" name="q" class="catalog-filter-control"
                            value="{{ request('q') }}" placeholder="Cari judul ebook...">
                    </div>

                    {{-- Filter Status Harga (Gratis / Berbayar) --}}
                    <div class="catalog-filter-field">
                        <label for="tipe-harga">Status Harga</label>
                        <select id="tipe-harga" name="tipe_harga" class="catalog-filter-control">
                            <option value="">Semua Harga</option>
                            <option value="gratis" {{ request('tipe_harga') == 'gratis' ? 'selected' : '' }}>Gratis</option>
                            <option value="berbayar" {{ request('tipe_harga') == 'berbayar' ? 'selected' : '' }}>Berbayar
                            </option>
                        </select>
                    </div>

                    {{-- Urutkan Harga --}}
                    <div class="catalog-filter-field">
                        <label for="sort-harga">Urutkan Harga</label>
                        <select id="sort-harga" name="sort_harga" class="catalog-filter-control">
                            <option value="">Default</option>
                            <option value="asc" {{ request('sort_harga') == 'asc' ? 'selected' : '' }}>Harga Terendah
                            </option>
                            <option value="desc" {{ request('sort_harga') == 'desc' ? 'selected' : '' }}>Harga Tertinggi
                            </option>
                        </select>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="catalog-filter-actions">
                        <button type="submit" class="catalog-filter-button">Terapkan</button>
                        <a href="{{ url()->current() }}" class="catalog-filter-reset">Reset</a>
                    </div>
                </form>
            </aside>

            {{-- Main Content --}}
            <section class="catalog-content">
                <div class="catalog-section-header">
                    <div>
                        <h2>Daftar Ebook</h2>
                        <p>Materi dan modul bacaan aktif yang dapat Anda pelajari.</p>
                    </div>
                    {{-- <span class="catalog-result-count">{{ $subMateriBaruCount }} Ebook terbaru</span> --}}
                </div>

                @if ($subMateriUmum->count() > 0)
                    <div class="catalog-grid">
                        @foreach ($subMateriUmum as $sub)
                            @php
                                $hargaAsli = $sub->harga ?? 0;
                                $hargaFinal = $sub->harga_final ?? $hargaAsli;
                                $diskon = $sub->diskon ?? 0;
                                $namaMateri = $sub->nama ?? ($sub->nama_kelas ?? 'Ebook Tanpa Nama');
                                $isUpcoming = (int) ($sub->upcoming ?? 0) === 1;
                                $hasDiscount =
                                    !$isUpcoming && ($diskon > 0 || $hargaAsli > $hargaFinal) && $hargaAsli > 0;
                            @endphp
                            <article class="catalog-card {{ $isUpcoming ? 'catalog-card--upcoming' : '' }}">
                                <div class="catalog-card__media">
                                    @if ($isUpcoming)
                                        <span class="catalog-card__upcoming-badge">Upcoming</span>
                                    @endif

                                    {{-- Discount Ribbon Badge --}}
                                    @if ($hasDiscount)
                                        <span class="catalog-card__discount-tag">
                                            DISKON {{ $diskon > 0 ? $diskon . '%' : 'PROMO' }}
                                        </span>
                                    @endif

                                    @if (!empty($sub->thumbnail) && str_contains($sub->thumbnail, 'uploads') && file_exists(public_path($sub->thumbnail)))
                                        <img src="{{ asset($sub->thumbnail) }}" alt="{{ $namaMateri }}">

                                        {{-- Cek Jika Mengandung Kata 'photos' --}}
                                    @elseif(!empty($sub->thumbnail) && str_contains($sub->thumbnail, 'photos'))
                                        <img src="{{ asset('storage/' . $sub->thumbnail) }}"
                                            alt="Banner {{ $sub->nama }}">
                                    @else
                                        <div class="catalog-card__placeholder">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                    @endif

                                    {{-- Status Label pada Thumbnail --}}
                                    <span
                                        class="catalog-card__badge {{ $hasDiscount ? 'catalog-card__badge--promo' : '' }}">
                                        @if ($isUpcoming)
                                            Rp.-
                                        @elseif($hargaFinal > 0)
                                            Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </span>
                                </div>

                                <div class="catalog-card__body">
                                    <h3 class="catalog-card__title">{{ $namaMateri }}</h3>
                                    <p class="catalog-card__description">
                                        {{ Str::limit($sub->keterangan ?? 'Tidak ada deskripsi ebook.', 80) }}
                                    </p>

                                    {{-- Rincian Harga & Diskon Coret --}}
                                    <div class="catalog-card__price-wrapper">
                                        @if ($isUpcoming)
                                            <span class="catalog-card__price-final">Rp.-</span>
                                        @elseif($hargaFinal > 0)
                                            <span class="catalog-card__price-final">
                                                Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                                            </span>
                                            @if ($hasDiscount)
                                                <span class="catalog-card__price-original">
                                                    Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="catalog-card__price-final text-emerald-600">
                                                Gratis
                                            </span>
                                            @if ($hasDiscount)
                                                <span class="catalog-card__price-original">
                                                    Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- Ganti bagian catalog-card__footer --}}
                                    <div class="catalog-card__footer">
                                        <span class="catalog-card__meta">
                                            <i class="fas fa-file-alt text-emerald-600 mr-1"></i>
                                            {{ $sub->items->count() }} Modul PDF
                                        </span>

                                        {{-- Tombol Selalu Mengarah ke Halaman Detail / Preview --}}
                                        <a href="{{ route('ebook.detail', [$sub->id]) }}" class="catalog-card__button">
                                            Detail Ebook <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="catalog-empty-state">
                        <i class="fas fa-folder-open fa-3x text-muted"></i>
                        <h3>Belum ada Ebook yang cocok</h3>
                        <p>Ubah kata kunci pencarian atau reset filter untuk melihat katalog ebook lainnya.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
