<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex, nofollow">

    <title>
        Aktivasi Akun | {{ config('app.name') }}
    </title>

    <style>
        :root {
            --primary: #0a1f44;
            --primary-light: #173b70;
            --primary-dark: #06152f;
            --accent: #f5b942;
            --accent-hover: #e3a62f;
            --success: #16a36a;
            --success-light: #e9f9f2;
            --warning: #d99310;
            --warning-light: #fff8e5;
            --danger: #d64545;
            --danger-light: #fff0f0;
            --text: #16243a;
            --muted: #69778d;
            --border: #e6ebf2;
            --background: #f5f7fb;
            --white: #ffffff;
            --shadow: 0 24px 60px rgba(3, 19, 48, 0.18);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family:
                Inter,
                ui-sans-serif,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 15% 20%,
                    rgba(245, 185, 66, 0.16),
                    transparent 32%),
                radial-gradient(circle at 88% 82%,
                    rgba(44, 93, 158, 0.28),
                    transparent 36%),
                linear-gradient(135deg,
                    var(--primary-dark),
                    var(--primary) 58%,
                    var(--primary-light));
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        .page {
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow: hidden;
        }

        .decoration {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(1px);
        }

        .decoration-one {
            top: -130px;
            right: -100px;
            width: 340px;
            height: 340px;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .decoration-two {
            right: -170px;
            bottom: -210px;
            width: 520px;
            height: 520px;
            background: rgba(255, 255, 255, 0.035);
        }

        .decoration-three {
            left: -75px;
            bottom: 85px;
            width: 150px;
            height: 150px;
            background: rgba(245, 185, 66, 0.08);
        }

        .navbar {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 28px 24px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 13px;
            color: var(--white);
            text-decoration: none;
        }

        .brand-logo {
            display: grid;
            width: 48px;
            height: 48px;
            place-items: center;
            border-radius: 14px;
            color: var(--primary);
            background: var(--accent);
            box-shadow: 0 10px 25px rgba(245, 185, 66, 0.22);
        }

        .brand-logo svg {
            width: 27px;
            height: 27px;
        }

        .brand-name {
            display: block;
            font-size: 18px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.25px;
        }

        .brand-tagline {
            display: block;
            margin-top: 3px;
            color: rgba(255, 255, 255, 0.67);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 1.6px;
            text-transform: uppercase;
        }

        .main-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 30px 24px 70px;
        }

        .activation-layout {
            display: grid;
            grid-template-columns:
                minmax(0, 0.9fr) minmax(420px, 1.1fr);
            width: 100%;
            max-width: 1080px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.07);
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
        }

        .info-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 580px;
            padding: 58px 50px;
            overflow: hidden;
            color: var(--white);
        }

        .info-panel::after {
            position: absolute;
            right: -70px;
            bottom: -60px;
            width: 240px;
            height: 240px;
            border: 48px solid rgba(245, 185, 66, 0.08);
            border-radius: 50%;
            content: "";
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            width: fit-content;
            margin-bottom: 26px;
            padding: 8px 13px;
            border: 1px solid rgba(245, 185, 66, 0.3);
            border-radius: 999px;
            color: #ffd782;
            background: rgba(245, 185, 66, 0.09);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 0 5px rgba(245, 185, 66, 0.12);
        }

        .info-title {
            max-width: 470px;
            font-size: clamp(36px, 4vw, 55px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -1.9px;
        }

        .info-title span {
            color: var(--accent);
        }

        .info-description {
            max-width: 470px;
            margin-top: 23px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 16px;
            line-height: 1.75;
        }

        .benefit-list {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 16px;
            margin-top: 42px;
        }

        .benefit {
            display: flex;
            align-items: flex-start;
            gap: 13px;
        }

        .benefit-icon {
            display: grid;
            flex: 0 0 31px;
            width: 31px;
            height: 31px;
            place-items: center;
            border-radius: 9px;
            color: var(--accent);
            background: rgba(255, 255, 255, 0.09);
        }

        .benefit-icon svg {
            width: 17px;
            height: 17px;
        }

        .benefit-text strong {
            display: block;
            margin-bottom: 3px;
            font-size: 14px;
        }

        .benefit-text span {
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            line-height: 1.5;
        }

        .secure-note {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 38px;
            color: rgba(255, 255, 255, 0.57);
            font-size: 12px;
        }

        .secure-note svg {
            width: 16px;
            height: 16px;
            color: var(--accent);
        }

        .card-panel {
            display: flex;
            align-items: center;
            padding: 38px;
            background: var(--background);
        }

        .activation-card {
            width: 100%;
            padding: 42px;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: var(--white);
            box-shadow: 0 18px 50px rgba(15, 35, 70, 0.1);
        }

        .status-icon {
            display: grid;
            width: 70px;
            height: 70px;
            margin-bottom: 27px;
            place-items: center;
            border-radius: 22px;
        }

        .status-icon svg {
            width: 36px;
            height: 36px;
        }

        .status-icon.pending {
            color: var(--primary);
            background:
                linear-gradient(135deg,
                    #fff7db,
                    #ffe5a3);
        }

        .status-icon.success {
            color: var(--success);
            background: var(--success-light);
        }

        .status-icon.processing {
            color: var(--warning);
            background: var(--warning-light);
        }

        .card-label {
            display: block;
            margin-bottom: 10px;
            color: var(--primary-light);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.25px;
            text-transform: uppercase;
        }

        .card-title {
            color: var(--primary);
            font-size: clamp(27px, 4vw, 36px);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.9px;
        }

        .card-description {
            margin-top: 15px;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.7;
        }

        .account-box {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 26px;
            padding: 17px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #f8fafc;
        }

        .account-avatar {
            display: grid;
            flex: 0 0 46px;
            width: 46px;
            height: 46px;
            place-items: center;
            border-radius: 14px;
            color: var(--white);
            background:
                linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .account-details {
            min-width: 0;
        }

        .account-name {
            overflow: hidden;
            color: var(--text);
            font-size: 14px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .account-email {
            overflow: hidden;
            margin-top: 4px;
            color: var(--muted);
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .expiration-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 17px;
            padding: 14px 15px;
            border: 1px solid #f3e0ad;
            border-radius: 14px;
            color: #795915;
            background: var(--warning-light);
            font-size: 13px;
            line-height: 1.55;
        }

        .expiration-box svg {
            flex: 0 0 18px;
            width: 18px;
            height: 18px;
            margin-top: 1px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 24px;
            padding: 16px;
            border-radius: 14px;
            font-size: 13px;
            line-height: 1.55;
        }

        .alert-success {
            color: #116144;
            border: 1px solid #bfe9d8;
            background: var(--success-light);
        }

        .alert-warning {
            color: #775811;
            border: 1px solid #f1dfad;
            background: var(--warning-light);
        }

        .alert-danger {
            color: #8a2929;
            border: 1px solid #f2c7c7;
            background: var(--danger-light);
        }

        .alert svg {
            flex: 0 0 19px;
            width: 19px;
            height: 19px;
        }

        .action-form {
            margin-top: 28px;
        }

        .activation-button {
            display: inline-flex;
            width: 100%;
            min-height: 54px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 22px;
            border: 0;
            border-radius: 14px;
            color: var(--primary-dark);
            background:
                linear-gradient(135deg,
                    #f8c75f,
                    var(--accent));
            box-shadow: 0 14px 25px rgba(245, 185, 66, 0.25);
            cursor: pointer;
            font-size: 15px;
            font-weight: 800;
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .activation-button:hover {
            background:
                linear-gradient(135deg,
                    #ffd26f,
                    var(--accent-hover));
            box-shadow: 0 17px 32px rgba(245, 185, 66, 0.34);
            transform: translateY(-2px);
        }

        .activation-button:active {
            transform: translateY(0);
        }

        .activation-button:disabled {
            cursor: not-allowed;
            opacity: 0.7;
            transform: none;
        }

        .activation-button svg {
            width: 19px;
            height: 19px;
        }

        .secondary-button {
            display: inline-flex;
            width: 100%;
            min-height: 52px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-top: 14px;
            padding: 13px 20px;
            border: 1px solid var(--border);
            border-radius: 14px;
            color: var(--primary);
            background: var(--white);
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition:
                border-color 0.2s ease,
                background 0.2s ease;
        }

        .secondary-button:hover {
            border-color: #c7d0dd;
            background: #f8fafc;
        }

        .secondary-button svg {
            width: 18px;
            height: 18px;
        }

        .privacy-note {
            margin-top: 18px;
            color: #8a95a6;
            font-size: 12px;
            line-height: 1.55;
            text-align: center;
        }

        .footer {
            position: relative;
            z-index: 2;
            padding: 0 24px 28px;
            color: rgba(255, 255, 255, 0.53);
            font-size: 12px;
            text-align: center;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.78);
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--accent);
        }

        .loading-spinner {
            display: none;
            width: 19px;
            height: 19px;
            border: 2px solid rgba(10, 31, 68, 0.3);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
        }

        .activation-button.loading .loading-spinner {
            display: block;
        }

        .activation-button.loading .button-icon {
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 900px) {
            .activation-layout {
                grid-template-columns: 1fr;
                max-width: 640px;
            }

            .info-panel {
                min-height: auto;
                padding: 45px 38px;
            }

            .info-title {
                max-width: 540px;
            }

            .benefit-list {
                display: none;
            }

            .secure-note {
                margin-top: 25px;
            }

            .card-panel {
                padding: 28px;
            }
        }

        @media (max-width: 560px) {
            .navbar {
                padding: 20px 18px;
            }

            .brand-logo {
                width: 43px;
                height: 43px;
                border-radius: 12px;
            }

            .brand-name {
                font-size: 16px;
            }

            .brand-tagline {
                font-size: 9px;
            }

            .main-content {
                align-items: flex-start;
                padding: 15px 14px 45px;
            }

            .activation-layout {
                border-radius: 22px;
            }

            .info-panel {
                padding: 35px 25px;
            }

            .info-title {
                font-size: 34px;
                letter-spacing: -1.1px;
            }

            .info-description {
                font-size: 14px;
            }

            .card-panel {
                padding: 15px;
            }

            .activation-card {
                padding: 28px 21px;
                border-radius: 19px;
            }

            .status-icon {
                width: 60px;
                height: 60px;
                border-radius: 18px;
            }

            .status-icon svg {
                width: 31px;
                height: 31px;
            }

            .card-title {
                font-size: 28px;
            }

            .account-box {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    @php
    $user = $activation ?? null;

    $userName = $user->name
    ?? $activation->name
    ?? 'Pengguna';

    $userEmail = $activation->email_destination
    ?? $user->email
    ?? 'Email terdaftar';

    $initials = collect(explode(' ', trim($userName)))
    ->filter()
    ->take(2)
    ->map(fn ($word) => mb_substr($word, 0, 1))
    ->implode('');

    $expiredAt = $activation->expires_at
    ? $activation->expires_at
    ->copy()
    ->timezone('Asia/Jakarta')
    ->format('d M Y, H:i') . ' WIB'
    : null;

    $isPasswordSent = $activation->is_active;
    $isActivated = ! is_null($activation->activated_at);
    @endphp

    <div class="page">
        <div class="decoration decoration-one"></div>
        <div class="decoration decoration-two"></div>
        <div class="decoration decoration-three"></div>

        <header class="navbar">
            <a href="{{ config('app.url') }}" class="brand">
                {{-- Ganti bagian ini dengan logo perusahaan bila tersedia. --}}
                <span class="brand-logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 10.5 12 4l9 6.5"></path>
                        <path d="M5 9.5V20h14V9.5"></path>
                        <path d="M9 20v-6h6v6"></path>
                    </svg>
                </span>

                <span>
                    <span class="brand-name">
                        {{ config('app.name', 'Bankir Academy') }}
                    </span>

                    <span class="brand-tagline">
                        Learning for better future
                    </span>
                </span>
            </a>
        </header>

        <main class="main-content">
            <section class="activation-layout">
                <div class="info-panel">
                    <div>
                        <div class="eyebrow">
                            <span class="eyebrow-dot"></span>
                            Portal Pengguna
                        </div>

                        <h1 class="info-title">
                            Satu langkah menuju
                            <span>akun aktif.</span>
                        </h1>

                        <p class="info-description">
                            Konfirmasikan email Anda agar dapat mengakses
                            seluruh layanan, program pembelajaran, dan fitur
                            yang tersedia pada platform kami.
                        </p>

                        <div class="benefit-list">
                            <div class="benefit">
                                <span class="benefit-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="m5 12 4 4L19 6"></path>
                                    </svg>
                                </span>

                                <div class="benefit-text">
                                    <strong>Konfirmasi email dengan aman</strong>
                                    <span>
                                        Link aktivasi dilindungi dan memiliki
                                        batas waktu penggunaan.
                                    </span>
                                </div>
                            </div>

                            <div class="benefit">
                                <span class="benefit-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round">
                                        <path d="M20 7 9 18l-5-5"></path>
                                    </svg>
                                </span>

                                <div class="benefit-text">
                                    <strong>Akses akun lebih cepat</strong>
                                    <span>
                                        Setelah aktivasi selesai, informasi login
                                        akan dikirim melalui WhatsApp.
                                    </span>
                                </div>
                            </div>

                            <div class="benefit">
                                <span class="benefit-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </span>

                                <div class="benefit-text">
                                    <strong>Data pengguna terlindungi</strong>
                                    <span>
                                        Jangan membagikan link aktivasi atau
                                        informasi login kepada pihak lain.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="secure-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>

                        Proses aktivasi dilindungi dengan signed URL.
                    </div> --}}
                </div>

                <div class="card-panel">
                    <div class="activation-card">

                        @if ($isPasswordSent ==1)
                        <div class="status-icon success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                        </div>

                        <span class="card-label">
                            Aktivasi selesai
                        </span>

                        <h2 class="card-title">
                            Akun Anda sudah aktif
                        </h2>

                        <p class="card-description">
                            Email berhasil dikonfirmasi dan password
                            sementara telah dikirimkan ke nomor WhatsApp
                            yang terdaftar.
                        </p>

                        <div class="account-box">
                            <div class="account-avatar">
                                {{ $initials ?: 'U' }}
                            </div>

                            <div class="account-details">
                                <div class="account-name">
                                    {{ $userName }}
                                </div>

                                <div class="account-email">
                                    {{ $userEmail }}
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m8 12 3 3 5-6"></path>
                            </svg>

                            <div>
                                Silakan periksa WhatsApp Anda. Setelah login,
                                segera ubah password sementara untuk menjaga
                                keamanan akun.
                            </div>
                        </div>

                        <a href="{{ route('login') }}" class="activation-button">
                            Masuk ke Akun

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="m13 6 6 6-6 6"></path>
                            </svg>
                        </a>

                        @elseif ($isActivated)
                        <div class="status-icon processing">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M12 7v5l3 2"></path>
                            </svg>
                        </div>

                        <span class="card-label">
                            Sedang diproses
                        </span>

                        <h2 class="card-title">
                            Akun berhasil diaktifkan
                        </h2>

                        <p class="card-description">
                            Konfirmasi email telah selesai. Sistem sedang
                            memproses pengiriman password sementara melalui
                            WhatsApp.
                        </p>

                        <div class="account-box">
                            <div class="account-avatar">
                                {{ $initials ?: 'U' }}
                            </div>

                            <div class="account-details">
                                <div class="account-name">
                                    {{ $userName }}
                                </div>

                                <div class="account-email">
                                    {{ $userEmail }}
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                            </svg>

                            <div>
                                Pengiriman WhatsApp diproses melalui antrean.
                                Anda dapat menutup halaman ini dan memeriksa
                                WhatsApp beberapa saat lagi.
                            </div>
                        </div>

                        <a href="{{ route('login') }}" class="secondary-button">
                            Kembali ke halaman login
                        </a>

                        @else
                        <div class="status-icon pending">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="m3 7 9 6 9-6"></path>
                            </svg>
                        </div>

                        <span class="card-label">
                            Konfirmasi email
                        </span>

                        <h2 class="card-title">
                            Aktifkan akun Anda
                        </h2>

                        <p class="card-description">
                            Pastikan informasi akun berikut sudah benar,
                            kemudian tekan tombol aktivasi untuk melanjutkan.
                        </p>

                        <div class="account-box">
                            <div class="account-avatar">
                                {{ $initials ?: 'U' }}
                            </div>

                            <div class="account-details">
                                <div class="account-name">
                                    {{ $userName }}
                                </div>

                                <div class="account-email">
                                    {{ $userEmail }}
                                </div>
                            </div>
                        </div>

                        @if ($expiredAt)
                        <div class="expiration-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M12 7v5l3 2"></path>
                            </svg>

                            <div>
                                Link aktivasi berlaku sampai
                                <strong>{{ $expiredAt }}</strong>.
                            </div>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M15 9l-6 6"></path>
                                <path d="m9 9 6 6"></path>
                            </svg>

                            <div>{{ session('error') }}</div>
                        </div>
                        @endif

                        @if($isExpired == 0)
                        <form action="{{ $consumeUrl }}" method="POST" class="action-form" id="activationForm">
                            @csrf

                            <button type="submit" class="activation-button" id="activationButton">
                                <span class="loading-spinner"></span>

                                <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>

                                <span class="button-text">
                                    Aktivasi Akun Sekarang
                                </span>
                            </button>
                        </form>

                        <p class="privacy-note">
                            Dengan mengaktifkan akun, Anda menyatakan bahwa
                            email tersebut benar milik Anda.
                        </p>
                        @else
                        <button class="activation-button" disabled>
                            <span class="loading-spinner"></span>

                            <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>

                            <span class="button-text">
                                Aktivasi Sudah Expired
                            </span>
                        </button>
                        @if($user)
                        @php
                        $sendActivationUrl = URL::temporarySignedRoute(
                        'activation.email.send-link',
                        now()->addMinutes(15),
                        [
                        'user' => $user->id,
                        'scope' => 'default',
                        'routing' => true
                        ]
                        );
                        @endphp
                        {{-- <a href="{{$sendActivationUrl}}">
                            Resend Email ...
                        </a> --}}
                        @endif
                        @endif
                        @endif
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            &copy; {{ date('Y') }}
            <a href="{{ config('app.url') }}">
                {{ config('app.name') }}
            </a>.
            Seluruh hak dilindungi.
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('activationForm');
        const button = document.getElementById('activationButton');

        if (!form || !button) {
            return;
        }

        form.addEventListener('submit', function () {
            button.disabled = true;
            button.classList.add('loading');

            const text = button.querySelector('.button-text');

            if (text) {
                text.textContent = 'Memproses Aktivasi...';
            }
        });
    });
    </script>
</body>

</html>