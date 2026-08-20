@extends('layouts.appmembernonanggota')

@section('title', 'Detail Ebook - ' . $subMateri->nama)

@section('content')
    @php($isUpcoming = (int) ($subMateri->upcoming ?? 0) === 1)
    <style>
        .ebook-detail-v2 {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Hero Mesh Header */
        .ebook-hero-v2 {
            position: relative;
            overflow: hidden;
            border-radius: 32px;
            background: #0f172a;
            color: #ffffff;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .22);
        }

        .ebook-hero-v2::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 18% 18%, rgba(79, 70, 229, .52), transparent 30%),
                radial-gradient(circle at 82% 28%, rgba(6, 182, 212, .34), transparent 28%),
                linear-gradient(135deg, rgba(15, 23, 42, .95), rgba(49, 46, 129, .9));
        }

        .ebook-hero-v2::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .055) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .055) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(90deg, #000, transparent 92%);
            pointer-events: none;
        }

        .ebook-hero-v2__inner {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(320px, 420px);
            gap: 28px;
            padding: 30px;
            align-items: stretch;
        }

        .ebook-hero-v2__content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 420px;
        }

        .ebook-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 40px;
            color: rgba(255, 255, 255, .82);
            font-size: 13px;
            font-weight: 850;
            text-decoration: none;
        }

        .ebook-back-link:hover {
            color: #ffffff;
        }

        .ebook-eyebrow-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 22px 0 18px;
        }

        .ebook-pill {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .92);
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
            backdrop-filter: blur(12px);
        }

        .ebook-pill--owned {
            border-color: rgba(34, 197, 94, .28);
            background: rgba(220, 252, 231, .94);
            color: #166534;
        }

        .ebook-title-v2 {
            max-width: 820px;
            margin: 0;
            font-size: clamp(32px, 4.6vw, 35px);
            font-weight: 950;
            letter-spacing: -.06em;
            line-height: 1.1;
        }

        .ebook-hero-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 28px;
        }

        .ebook-stat-card {
            min-height: 86px;
            padding: 13px;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 18px;
            background: rgba(255, 255, 255, .1);
            backdrop-filter: blur(14px);
        }

        .ebook-stat-card__label {
            display: block;
            margin-bottom: 7px;
            color: rgba(255, 255, 255, .58);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .ebook-stat-card__value {
            display: block;
            color: #ffffff;
            font-size: 14px;
            font-weight: 900;
            line-height: 1.35;
        }

        .ebook-hero-visual {
            display: grid;
            grid-template-rows: minmax(260px, 1fr) auto;
            gap: 14px;
        }

        .ebook-cover-card {
            position: relative;
            aspect-ratio: 3 / 2;
            border-radius: 24px;
            overflow: hidden;
            background: rgba(255, 255, 255, .08);
            box-shadow: 0 24px 54px rgba(15, 23, 42, .32);
        }

        .ebook-cover-card img {
            width: 100%;
            height: 100%;
            min-height: 0;
            display: block;
            object-fit: contain;
        }

        .ebook-cover-card__shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 46%, rgba(15, 23, 42, .72));
        }

        .ebook-price-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 22px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(14px);
        }

        .ebook-price-label {
            display: block;
            color: rgba(255, 255, 255, .58);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .ebook-price-value {
            display: block;
            margin-top: 2px;
            color: #ffffff;
            font-size: 26px;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ebook-price-original {
            display: block;
            color: rgba(255, 255, 255, .55);
            font-size: 12px;
            font-weight: 800;
            text-decoration: line-through;
        }

        .ebook-primary-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 12px 18px;
            border: 0;
            border-radius: 999px;
            background: #ffffff;
            color: #312e81;
            font-size: 13px;
            font-weight: 950;
            white-space: nowrap;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 16px 28px rgba(15, 23, 42, .24);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .ebook-primary-cta:hover {
            color: #312e81;
            transform: translateY(-1px);
            box-shadow: 0 20px 34px rgba(15, 23, 42, .3);
        }

        /* Layout Body Main/Sidebar */
        .ebook-body-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 22px;
            align-items: start;
        }

        .ebook-content-stack {
            display: grid;
            gap: 18px;
            min-width: 0;
        }

        .ebook-panel {
            border: 1px solid #e7e9f0;
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
            overflow: hidden;
        }

        .ebook-panel__body {
            padding: 24px;
        }

        .ebook-section-kicker {
            display: inline-flex;
            margin-bottom: 10px;
            color: var(--primary, #4F46E5);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .ebook-section-title {
            margin: 0 0 14px;
            color: #111827;
            font-size: 24px;
            font-weight: 950;
            letter-spacing: -.045em;
            line-height: 1.12;
        }

        .ebook-description {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.85;
        }

        .ebook-description p:last-child {
            margin-bottom: 0;
        }

        .ebook-side-stack {
            position: sticky;
            top: calc(var(--topbar-h, 68px) + 18px);
            display: grid;
            gap: 16px;
        }

        .ebook-register-card {
            padding: 18px;
            border-radius: 24px;
            background: #111827;
            color: #ffffff;
            box-shadow: 0 18px 46px rgba(15, 23, 42, .18);
        }

        .ebook-register-card__label {
            display: block;
            color: rgba(255, 255, 255, .58);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        .ebook-upcoming-badge {
            display: inline-flex;
            margin-top: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #059669;
            color: #ffffff;
            font-size: 11px;
            font-weight: 850;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ebook-register-card__price {
            display: block;
            margin-top: 4px;
            font-size: 32px;
            font-weight: 950;
            letter-spacing: -.05em;
            line-height: 1;
        }

        .ebook-register-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 48px;
            margin-top: 18px;
            border: 0;
            border-radius: 999px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            font-weight: 950;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 14px 28px rgba(0, 0, 0, .2);
            transition: transform .18s ease;
        }

        .ebook-register-button:hover {
            color: #111827;
            transform: translateY(-1px);
        }

        .ebook-register-button--disabled,
        .ebook-register-button--disabled:hover {
            color: #f9fafb;
            background: #9ca3af;
            box-shadow: none;
            cursor: not-allowed;
            opacity: .85;
            transform: none;
        }

        .ebook-register-note {
            margin: 13px 0 0;
            color: rgba(255, 255, 255, .68);
            font-size: 12.5px;
            line-height: 1.65;
        }

        /* Responsive adjustments */
        @media (max-width: 1199.98px) {

            .ebook-hero-v2__inner,
            .ebook-body-layout {
                grid-template-columns: 1fr;
            }

            .ebook-hero-v2__content {
                min-height: auto;
            }

            .ebook-side-stack {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .ebook-hero-v2 {
                border-radius: 24px;
            }

            .ebook-hero-v2__inner {
                padding: 20px;
                gap: 20px;
            }

            .ebook-hero-stats {
                grid-template-columns: 1fr;
            }

            .ebook-cover-card img {
                min-height: 0;
            }

            .ebook-price-strip {
                align-items: stretch;
                flex-direction: column;
            }

            .ebook-primary-cta {
                width: 100%;
            }

            .ebook-panel__body {
                padding: 18px;
            }
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

        .payment-methods-grid {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .payment-methods-grid img {
            height: 22px;
            width: auto;
            object-fit: contain;
            filter: grayscale(20%);
            transition: filter 0.2s ease;
        }

        .payment-methods-grid img:hover {
            filter: grayscale(0%);
        }

        .video-register-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 48px;
            margin-top: 18px;
            border: 0;
            border-radius: 999px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            font-weight: 950;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 14px 28px rgba(0, 0, 0, .2);
            transition: transform .18s ease;
        }

        .video-register-button:hover {
            color: #111827;
            transform: translateY(-1px);
        }

        .video-register-button--disabled,
        .video-register-button--disabled:hover {
            color: #f9fafb;
            background: #9ca3af;
            box-shadow: none;
            cursor: not-allowed;
            opacity: .85;
            transform: none;
        }
    </style>

    <div class="container py-4">
        <div class="ebook-detail-v2">
            {{-- HERO SECTION --}}
            <!-- <section class="ebook-hero-v2" aria-labelledby="ebook-title">
                                                                        <div class="ebook-hero-v2__inner">
                                                                            <div class="ebook-hero-v2__content">
                                                                                <div>
                                                                                    <a href="javascript:history.back()" class="ebook-back-link">
                                                                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                                                                    </a>

                                                                                    <div class="ebook-eyebrow-row">
                                                                                        <span class="ebook-pill"><i class="fas fa-file-pdf me-1"></i> E-Book PDF</span>
                                                                                        @if ($sudahAkses)
    <span class="ebook-pill ebook-pill--owned"><i class="fas fa-check-circle me-1"></i> Sudah Dimiliki</span>
@else
    <span class="ebook-pill"><i class="fas fa-lock me-1"></i> Akses Terbatas</span>
    @endif
                                                                                    </div>

                                                                                    <h1 class="ebook-title-v2" id="ebook-title">{{ $subMateri->nama }}</h1>
                                                                                </div>

                                                                                <div class="ebook-hero-stats" aria-label="Ringkasan Ebook">
                                                                                    <div class="ebook-stat-card">
                                                                                        <span class="ebook-stat-card__label">Tipe File</span>
                                                                                        <span class="ebook-stat-card__value">PDF Document</span>
                                                                                    </div>
                                                                                    <div class="ebook-stat-card">
                                                                                        <span class="ebook-stat-card__label">Masa Aktif</span>
                                                                                        <span class="ebook-stat-card__value">{{ $subMateri->masa_aktif ? $subMateri->masa_aktif . ' Hari' : 'Selamanya' }}</span>
                                                                                    </div>
                                                                                    <div class="ebook-stat-card">
                                                                                        <span class="ebook-stat-card__label">Akses</span>
                                                                                        <span class="ebook-stat-card__value">Online Reader</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- Visual Cover & Action Strip --}}
                                                                            <div class="ebook-hero-visual">
                                                                                <div class="ebook-cover-card">
                                                                                    <img src="{{ $coverImage }}" alt="{{ $subMateri->nama }}" onerror="this.src='{{ asset('cbtemplate/assets/img/90x90.jpg') }}'">
                                                                                    <span class="ebook-cover-card__shade" aria-hidden="true"></span>
                                                                                </div>

                                                                                <div class="ebook-price-strip">
                                                                                    <div>
                                                                                        <span class="ebook-price-label">Investasi</span>
                                                                                        <span class="ebook-price-value">
                                                                                            @if ($hargaFinal > 0)
    Rp {{ number_format($hargaFinal, 0, ',', '.') }}
@else
    Gratis
    @endif
                                                                                        </span>
                                                                                        @if ($hargaFinal > 0 && $harga > $hargaFinal)
    <span class="ebook-price-original">Rp {{ number_format($harga, 0, ',', '.') }}</span>
    @endif
                                                                                    </div>

                                                                                    {{-- Action Buttons --}}
                                                                                    @if ($sudahAkses)
                                                                                        <a href="{{ route('ebook.belajar', $subMateri->id) }}" class="ebook-primary-cta">
                                                                                            <i class="fas fa-book-open me-2"></i> Baca Ebook
                                                                                        </a>
@else
    @if ($hargaFinal > 0)
    <a href="{{ route('ebook.belajar', $subMateri->id) }}" class="ebook-primary-cta">
                                                                                                Beli Ebook <i class="fas fa-arrow-right ms-2"></i>
                                                                                            </a>
@else
    <form action="{{ route('ebook.claim', $subMateri->id) }}" method="POST" class="m-0">
                                                                                                @csrf
                                                                                                <button type="submit" class="ebook-primary-cta">
                                                                                                    <i class="fas fa-download me-2"></i> Klaim Gratis
                                                                                                </button>
                                                                                            </form>
    @endif
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </section> -->

            {{-- MAIN CONTENT & SIDEBAR --}}
            <div class="ebook-body-layout">
                <main class="ebook-content-stack">
                    {{-- Preview Section --}}

                    <section class="ebook-panel">
                        <div class="ebook-panel__body">

                            <!-- <span class="ebook-section-kicker">Preview Content</span>
                                                                                    <h2 class="ebook-section-title">Pratinjau Ebook</h2> -->
                            <div class="ebook-cover-card">
                                @if ($coverImage)
                                    <img src="{{ $coverImage }}" alt="{{ $subMateri->nama }}">
                                @else
                                    <div class="catalog-card__media">
                                        <div class="catalog-card__placeholder">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                    </div>
                                @endif

                                <span class="ebook-cover-card__shade" aria-hidden="true"></span>
                            </div>
                        </div>
                    </section>

                    {{-- Description Section --}}
                    <section class="ebook-panel">
                        <div class="ebook-panel__body">
                            <span class="ebook-section-kicker">Tentang Ebook</span>
                            <h2 class="ebook-section-title">{{ $subMateri->nama }}</h2>
                            <div class="ebook-description">
                                @if ($subMateri->keterangan)
                                    {!! nl2br(e($subMateri->keterangan)) !!}
                                @else
                                    <p class="text-muted">Tidak ada deskripsi rinci yang tersedia untuk ebook ini.</p>
                                @endif
                            </div>
                        </div>
                    </section>
                </main>

                {{-- SIDEBAR --}}
                <aside class="ebook-side-stack">
                    <section class="ebook-register-card">
                        <span class="ebook-register-card__label">Harga Ebook</span>
                        @if ($isUpcoming)
                            <span class="ebook-upcoming-badge">Upcoming</span>
                        @endif
                        <span class="ebook-register-card__price">
                            @if ($isUpcoming)
                                Rp.-
                            @elseif($hargaFinal > 0)
                                Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </span>
                        @if ($hargaFinal > 0 && $harga > $hargaFinal)
                            <span class="ebook-price-original">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                        @endif

                        @if ($isUpcoming)
                            <button type="button" class="ebook-register-button ebook-register-button--disabled" disabled
                                aria-disabled="true">
                                Upcoming
                            </button>
                        @elseif($sudahAkses)
                            <a href="{{ route('ebook.belajar', $subMateri->id) }}" class="ebook-register-button">
                                <i class="fas fa-book-open me-2 mr-4"></i> Baca Sekarang
                            </a>
                        @elseif($transaksiAktif)
                            {{-- JIKA ADA PEMBAYARAN AKTIF: Arahkan ke Invoice existing, blokir pembuatan invoice baru --}}
                            <a href="#" class="video-register-button bg-warning text-dark font-weight-bold">
                                <i class="fas fa-clock me-2 mr-2"></i> Selesaikan Pembayaran
                            </a>
                            <p class="small text-warning mt-2 mb-0">
                                <i class="fas fa-exclamation-triangle me-1"></i> Anda memiliki transaksi yang belum
                                diselesaikan.
                            </p>
                        @else
                            @if ($hargaFinal > 0)
                                <button type="button" class="ebook-register-button" data-toggle="modal"
                                    data-target="#paymentMethodModal" data-bs-toggle="modal"
                                    data-bs-target="#paymentMethodModal">
                                    Beli Ebook Sekarang
                                </button>
                            @else
                                <!-- <form action="{{ route('ebook.claim', $subMateri->id) }}" method="POST" class="m-0">
                                                                                            @csrf
                                                                                            <button type="submit" class="ebook-register-button">
                                                                                                <i class="fas fa-download me-2"></i> Dapatkan Akses Gratis
                                                                                            </button>
                                                                                        </form> -->
                                <a href="{{ route('ebook.belajar', $subMateri->id) }}" class="ebook-register-button">
                                    Dapatkan Akses Gratis
                                </a>
                            @endif
                        @endif

                        <p class="ebook-register-note">
                            <i class="fas fa-info-circle me-1"></i> Setelah klaim atau beli, ebook ini dapat diakses
                            langsung kapan saja melalui dashboard akun Anda.
                        </p>
                    </section>
                </aside>
            </div>
        </div>
    </div>
    @if (!$isUpcoming && !$sudahAkses && $hargaFinal > 0)
        <div class="modal fade payment-modal" id="paymentMethodModal" tabindex="-1" role="dialog"
            aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h5 class="modal-title font-weight-bold fw-bold text-dark" id="paymentMethodModalLabel">Pilih
                                Metode Pembayaran</h5>
                            <p class="text-muted small mb-0">Silakan pilih opsi pembayaran yang paling nyaman untuk Anda.
                            </p>
                        </div>
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="row g-3">

                            {{-- Opsi 1: Virtual Account & Gateway Otomatis --}}
                            <div class="col-12 mb-4">
                                <div class="payment-option-card">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="font-weight-bold fw-bold mb-1 text-dark">
                                                <i class="fas fa-bolt text-warning me-2 mr-2"></i>Otomatis (Virtual Account
                                                / Retail)
                                            </h6>
                                            <p class="text-muted small mb-0">Pembayaran terverifikasi secara otomatis 24/7.
                                                Akses video langsung aktif.</p>
                                        </div>
                                        <span class="badge badge-success bg-success text-white">Rekomendasi</span>
                                    </div>

                                    <div class="payment-methods-grid my-3 p-2 bg-light rounded">
                                        <img src="{{ asset('frontend/demo/gateway/bri.png') }}" alt="BRI">
                                        <img src="{{ asset('frontend/demo/gateway/btn.png') }}" alt="BTN">
                                        <img src="{{ asset('frontend/demo/gateway/bni.png') }}" alt="BNI">
                                        <img src="{{ asset('frontend/demo/gateway/mandiri.png') }}" alt="Mandiri">
                                        <img src="{{ asset('frontend/demo/gateway/maybank.png') }}" alt="Maybank">
                                        <img src="{{ asset('frontend/demo/gateway/bsi.png') }}" alt="BSI">
                                        <img src="{{ asset('frontend/demo/gateway/danamon.png') }}" alt="Danamon">
                                        <img src="{{ asset('frontend/demo/gateway/permata.png') }}" alt="Permata">
                                        <img src="{{ asset('frontend/demo/gateway/sinarmas.png') }}" alt="Sinarmas">
                                        <img src="{{ asset('frontend/demo/gateway/indomaret.png') }}" alt="Indomaret">
                                        <img src="{{ asset('frontend/demo/gateway/alfamart.png') }}" alt="Alfamart">
                                        <img src="{{ asset('frontend/demo/gateway/bnc.png') }}" alt="BNC">
                                    </div>

                                    {{-- Form POST untuk Virtual Account --}}
                                    <form action="{{ route('payment.order.video') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="class_id" value="{{ $subMateri->id }}">
                                        <input type="hidden" name="price" value="{{ $hargaFinal }}">
                                        <input type="hidden" name="nama" value="{{ Auth::user()->name }}">
                                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                        <input type="hidden" name="nomor_handphone"
                                            value="{{ Auth::user()->siswa->no_telp ?? '08123456789' }}">
                                        <button type="submit"
                                            class="btn btn-primary w-100 font-weight-bold fw-bold py-2 mt-2">
                                            Bayar via Virtual Account
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Opsi 2: Transfer Manual --}}
                            <div class="col-12">
                                <div class="payment-option-card">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="font-weight-bold fw-bold mb-1 text-dark">
                                                <i class="fas fa-university text-primary me-2 mr-2"></i>Transfer Manual
                                            </h6>
                                            <p class="text-muted small mb-0">Lakukan transfer ke rekening resmi kami di
                                                bawah ini, lalu unduh invoice pembayaran Anda.</p>
                                        </div>
                                    </div>

                                    <div class="p-3 border rounded my-3"
                                        style="background-color: #fffdf5; border-color: #ffeeba !important;">
                                        <span class="text-muted d-block small font-weight-bold text-warning">REKENING
                                            PEMBAYARAN</span>
                                        <span class="d-block mt-1"><strong>Bank Central Asia (BCA)</strong></span>
                                        <span class="d-block text-monospace font-weight-bold text-dark"
                                            style="font-size: 1.15rem;">803 555 9091</span>
                                        <span class="small d-block text-muted">a.n. PT. Bankir Academy Indonesia</span>
                                    </div>

                                    {{-- Form POST untuk Pembayaran Manual --}}
                                    <form action="{{ route('payment.order.ebook.manual') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="class_id" value="{{ $subMateri->id }}">
                                        <input type="hidden" name="price" value="{{ $hargaFinal }}">
                                        <button type="submit"
                                            class="btn btn-outline-primary w-100 font-weight-bold fw-bold py-2 mt-1">
                                            <i class="fas fa-file-download me-1 mr-1"></i> Process & Unduh Invoice
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 justify-content-between">
                        <span class="small text-muted">Total Pembayaran: <strong class="text-dark fs-6">Rp
                                {{ number_format($hargaFinal, 0, ',', '.') }}</strong></span>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"
                            data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
