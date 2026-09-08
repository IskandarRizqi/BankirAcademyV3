@extends('layouts.appmembernonanggota')

@section('title', 'Segera Hadir')

@section('content')
    <style>
        .cs-page {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .cs-hero {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: clamp(32px, 6vw, 56px);
            background:
                radial-gradient(circle at 84% 18%, rgba(129, 140, 248, .35), transparent 28%),
                linear-gradient(135deg, #111827 0%, #312e81 55%, #4f46e5 100%);
            color: #ffffff;
            box-shadow: 0 20px 48px rgba(49, 46, 129, .2);
            text-align: center;
        }

        .cs-hero::after {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 38px 38px;
            content: "";
            mask-image: linear-gradient(180deg, transparent, #000 20%, #000 80%, transparent);
            pointer-events: none;
        }

        .cs-hero__content {
            position: relative;
            z-index: 1;
            max-width: 680px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cs-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding: 7px 14px;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .9);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .cs-hero__title {
            margin: 0;
            font-size: clamp(30px, 4.5vw, 50px);
            font-weight: 900;
            letter-spacing: -.04em;
            line-height: 1.1;
        }

        .cs-hero__description {
            margin: 16px 0 0;
            color: rgba(255, 255, 255, .84);
            font-size: 16px;
            line-height: 1.7;
        }

        .cs-card {
            padding: clamp(24px, 4vw, 36px);
            border: 1px solid #e7e9f0;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
            text-align: center;
        }

        .cs-icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            margin-bottom: 16px;
            border-radius: 18px;
            background: #e0e7ff;
            color: #4338ca;
            font-size: 26px;
        }

        .cs-card__title {
            margin: 0 0 8px;
            color: #111827;
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -.025em;
        }

        .cs-card__description {
            max-width: 540px;
            margin: 0 auto 24px;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .cs-notify-form {
            display: flex;
            max-width: 460px;
            margin: 0 auto;
            gap: 10px;
        }

        .cs-notify-input {
            flex: 1;
            min-height: 46px;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            outline: none;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            font-weight: 600;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .cs-notify-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .12);
        }

        .cs-notify-button {
            display: inline-flex;
            min-height: 46px;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: 0;
            border-radius: 10px;
            background: #4f46e5;
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition: background .18s ease, transform .18s ease;
            white-space: nowrap;
        }

        .cs-notify-button:hover,
        .cs-notify-button:focus-visible {
            background: #3730a3;
            transform: translateY(-1px);
        }

        .cs-action-link {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
            background: #ffffff;
            color: #3730a3;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .cs-action-link:hover,
        .cs-action-link:focus-visible {
            border-color: #4f46e5;
            background: #4f46e5;
            color: #ffffff;
        }

        .cs-cta {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 18px;
            align-items: center;
            padding: 22px;
            border: 1px solid #c7d2fe;
            border-radius: 18px;
            background: linear-gradient(135deg, #eef2ff, #ffffff 75%);
        }

        .cs-cta__eyebrow {
            margin: 0 0 5px;
            color: #4338ca;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .cs-cta h3 {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -.025em;
        }

        .cs-cta p {
            max-width: 680px;
            margin: 6px 0 0;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.6;
        }

        @media (max-width: 767.98px) {
            .cs-notify-form {
                flex-direction: column;
            }

            .cs-cta {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .cs-notify-button,
            .cs-action-link {
                transition: none;
            }

            .cs-notify-button:hover {
                transform: none;
            }
        }
    </style>

    <div class="cs-page">
        {{-- Hero Banner Section --}}
        <section class="cs-hero" aria-labelledby="cs-page-title">
            <div class="cs-hero__content">
                <span class="cs-hero__eyebrow">
                    <i class="fas fa-rocket" aria-hidden="true"></i>
                    Fitur Mendatang
                </span>
                <h1 class="cs-hero__title" id="cs-page-title">Sesuatu yang hebat sedang disiapkan</h1>
                <p class="cs-hero__description">
                    Kami sedang mengembangkan layanan baru untuk mendukung pengembangan karier perbankan Anda.
                    Fitur ini akan segera dapat diakses.
                </p>
            </div>
        </section>

        {{-- Main Feature Card Section --}}
        <main class="cs-card">
            <div class="cs-icon-box" aria-hidden="true">
                <i class="fas fa-tools"></i>
            </div>
            <h2 class="cs-card__title">Halaman Dalam Tahap Pengembangan</h2>
            <p class="cs-card__description">
                Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik bagi Anda.

            </p>

            {{-- Optional Form Notification --}}
            {{-- <form class="cs-notify-form" action="#" method="POST" onsubmit="event.preventDefault();">
                <input type="email" class="cs-notify-input" placeholder="Masukkan alamat email Anda" required
                    aria-label="Alamat Email">
                <button type="submit" class="cs-notify-button">Beritahu Saya</button>
            </form>

            <div style="margin-top: 28px;">
                <a href="{{ route('membernonanggota.loker.index') }}" class="cs-action-link">
                    <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Kembali ke Lowongan Kerja
                </a>
            </div> --}}
        </main>

        {{-- Membership CTA Section --}}
        {{-- @if (!($isMember ?? false))
            <section class="cs-cta" aria-labelledby="cs-cta-title">
                <div>
                    <p class="cs-cta__eyebrow">Keanggotaan Bankir Academy</p>
                    <h3 id="cs-cta-title">Tingkatkan Akses Karier Anda</h3>
                    <p>
                        Sambil menunggu fitur ini rilis, tingkatkan keanggotaan Anda untuk menikmati berbagai akses
                        eksklusif pelatihan dan lowongan kerja terpilih.
                    </p>
                </div>
                <div>
                    <a href="{{ route('membernonanggota.loker.index') }}" class="cs-action-link">
                        Lihat Keuntungan
                    </a>
                </div>
            </section>
        @endif --}}
    </div>
@endsection
