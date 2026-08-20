@extends('layouts.appmembernonanggota')

@section('title', 'Detail Video - ' . $subMateri->nama)

@section('content')
    @php($isUpcoming = (int) ($subMateri->upcoming ?? 0) === 1)
    <style>
        .video-detail-v2 {
            display: flex;
            flex-direction: column;
            gap: 24px;
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

        /* Layout Body Main/Sidebar */
        .video-body-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 22px;
            align-items: start;
        }

        .video-content-stack {
            display: grid;
            gap: 18px;
            min-width: 0;
        }

        .video-panel {
            border: 1px solid #e7e9f0;
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
            overflow: hidden;
        }

        .video-panel__body {
            padding: 24px;
        }

        .video-section-kicker {
            display: inline-flex;
            margin-bottom: 10px;
            color: var(--primary, #4F46E5);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .video-section-title {
            margin: 0 0 14px;
            color: #111827;
            font-size: 24px;
            font-weight: 950;
            letter-spacing: -.045em;
            line-height: 1.12;
        }

        .video-description {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.85;
        }

        .video-description p:last-child {
            margin-bottom: 0;
        }

        /* Video Frame Container */
        .video-embed-card {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            background: #000000;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .12);
        }

        .video-placeholder-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            background: #f8fafc;
            border-radius: 18px;
            border: 2px dashed #e2e8f0;
            text-align: center;
        }

        /* Sidebar Styling */
        .video-side-stack {
            position: sticky;
            top: calc(var(--topbar-h, 68px) + 18px);
            display: grid;
            gap: 16px;
        }

        .video-register-card {
            padding: 18px;
            border-radius: 24px;
            background: #111827;
            color: #ffffff;
            box-shadow: 0 18px 46px rgba(15, 23, 42, .18);
        }

        .video-register-card__label {
            display: block;
            color: rgba(255, 255, 255, .58);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        .video-upcoming-badge {
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

        .video-register-card__price {
            display: block;
            margin-top: 4px;
            font-size: 32px;
            font-weight: 950;
            letter-spacing: -.05em;
            line-height: 1;
        }

        .video-price-original {
            display: block;
            margin-top: 4px;
            color: rgba(255, 255, 255, .55);
            font-size: 13px;
            font-weight: 800;
            text-decoration: line-through;
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

        .video-register-note {
            margin: 13px 0 0;
            color: rgba(255, 255, 255, .68);
            font-size: 12.5px;
            line-height: 1.65;
        }

        .catalog-card__media {
            position: relative;
            width: 100%;
            aspect-ratio: 3 / 2;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            overflow: hidden;
        }

        .catalog-card__media img {
            width: 100%;
            height: 100%;
            object-fit: contain;
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

        /* Modal Payment Styling */
        .payment-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .payment-option-card {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.2s ease-in-out;
            background: #ffffff;
        }

        .payment-option-card:hover {
            border-color: #4F46E5;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.08);
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

        /* Responsive adjustments */
        @media (max-width: 1199.98px) {
            .video-body-layout {
                grid-template-columns: 1fr;
            }

            .video-side-stack {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .video-panel__body {
                padding: 18px;
            }
        }
    </style>

    <div class="container py-4">
        <div class="video-detail-v2">
            {{-- MAIN CONTENT & SIDEBAR --}}
            <div class="video-body-layout">
                <main class="video-content-stack">
                    {{-- Preview Section --}}
                    <section class="video-panel">
                        <div class="video-panel__body">
                            <div class="ebook-cover-card">
                                @if ($coverImage)
                                    <img src="{{ $coverImage }}" alt="{{ $subMateri->nama }}">
                                @else
                                    <div class="catalog-card__media">
                                        <div class="catalog-card__placeholder">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>

                    {{-- Description Section --}}
                    <section class="video-panel">
                        <div class="video-panel__body">
                            <span class="video-section-kicker">Tentang Video</span>
                            <h2 class="video-section-title">{{ $subMateri->nama }}</h2>
                            <div class="video-description">
                                @if ($subMateri->keterangan)
                                    {!! nl2br(e($subMateri->keterangan)) !!}
                                @else
                                    <p class="text-muted">Tidak ada deskripsi rinci yang tersedia untuk video ini.</p>
                                @endif
                            </div>
                        </div>
                    </section>
                </main>

                {{-- SIDEBAR --}}
                <aside class="video-side-stack">
                    <section class="video-register-card">
                        <span class="video-register-card__label">Harga Video</span>
                        @if ($isUpcoming)
                            <span class="video-upcoming-badge">Upcoming</span>
                        @endif
                        <span class="video-register-card__price">
                            @if ($isUpcoming)
                                Rp.-
                            @elseif($hargaFinal > 0)
                                Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </span>
                        @if (isset($harga) && $harga > $hargaFinal)
                            <span class="video-price-original">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                        @endif

                        @if ($isUpcoming)
                            <button type="button" class="video-register-button video-register-button--disabled" disabled
                                aria-disabled="true">
                                Upcoming
                            </button>
                        @elseif($sudahAkses)
                            <a href="{{ route('video.belajar', $subMateri->id) }}" class="video-register-button">
                                <i class="fas fa-play-circle me-2 mr-2"></i> Tonton Sekarang
                            </a>
                        @elseif($transaksiAktif || $paymentActive)
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
                                {{-- Membuka Modal Pembayaran --}}
                                <button type="button" class="video-register-button" data-toggle="modal"
                                    data-target="#paymentMethodModal" data-bs-toggle="modal"
                                    data-bs-target="#paymentMethodModal">
                                    Beli Video Sekarang
                                </button>
                            @else
                                <a href="{{ route('video.belajar', $subMateri->id) }}" class="video-register-button">
                                    Dapatkan Akses Gratis
                                </a>
                            @endif
                        @endif

                        <p class="video-register-note">
                            <i class="fas fa-info-circle me-1"></i> Setelah klaim atau beli, video ini dapat diakses
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
                                    <form action="{{ route('payment.order.video.manual') }}" method="POST">
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
