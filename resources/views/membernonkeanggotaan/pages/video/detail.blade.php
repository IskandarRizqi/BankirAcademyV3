@extends('layouts.appmembernonanggota')

@section('title', 'Detail Video - ' . $subMateri->nama)

@section('content')
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
        text-center;
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
                        <!-- <span class="video-section-kicker">Preview Video</span>
                        <h2 class="video-section-title">Pratinjau Materi</h2> -->
                           <div class="ebook-cover-card">
                          @if($coverImage)
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
                            @if($subMateri->keterangan)
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
                    <span class="video-register-card__price">
                        @if($hargaFinal > 0)
                            Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </span>
                    @if(isset($harga)  && $harga > $hargaFinal)
                        <span class="video-price-original">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                    @endif

                    @if($sudahAkses)
                        <a href="{{ route('video.belajar', $subMateri->id) }}" class="video-register-button">
                            <i class="fas fa-play-circle me-2"></i> Tonton Sekarang
                        </a>
                    @else
                        @if($hargaFinal > 0)
                            <a href="{{ route('video.belajar', $subMateri->id) }}" class="video-register-button">
                                Beli Video Sekarang
                            </a>
                        @else
                            <!-- <form action="{{ route('video.claim', $subMateri->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="video-register-button">
                                    <i class="fas fa-unlock me-2"></i> Dapatkan Akses Gratis
                                </button>
                            </form> -->
                              <a href="{{ route('video.belajar', $subMateri->id) }}" class="video-register-button">
                               Dapatkan Akses Gratis
                            </a>
                        @endif
                    @endif

                    <p class="video-register-note">
                        <i class="fas fa-info-circle me-1"></i> Setelah klaim atau beli, video ini dapat diakses langsung kapan saja melalui dashboard akun Anda.
                    </p>
                </section>
            </aside>
        </div>
    </div>
</div>
@endsection
