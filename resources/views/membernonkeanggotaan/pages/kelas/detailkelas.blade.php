@extends('layouts.appmembernonanggota')

@section('title', data_get($class, 'title', 'Detail Kelas'))

@section('content')
    @php
        $levels = [
            1 => 'Pemula',
            2 => 'Menengah',
            3 => 'Lanjutan',
        ];
        $title = data_get($class, 'title', 'Detail Kelas');
        $level = $levels[(int) data_get($class, 'level')] ?? 'Semua Level';
        $category = data_get($class, 'category') ?: 'Kelas Bankir';
        $mode =
            [
                0 => 'Online',
                1 => 'Offline',
            ][(int) data_get($class, 'kategori')] ?? 'Kelas';
        $isIht = (int) data_get($class, 'iht') === 1;
        $endDate = data_get($class, 'date_end');
        $courseTime = data_get($class, 'jam_acara');
        $courseTimeLabel = $courseTime ? \Carbon\Carbon::parse($courseTime)->format('H:i') . ' WIB' : 'Menyesuaikan';
        $location = data_get($class, 'lokasi');
        $locationLabel = $mode === 'Online' ? 'Online Meeting' : ($location ?: 'Lokasi menyusul');
        $image = data_get($class, 'image_mobile') ?: data_get($class, 'image');
        $image = $image ?: asset('assets/img/90x90.jpg');
        $contents = collect($contents ?? []);
        $contentCount = $contents->count();
        $contentUnlocked = (bool) ($contentUnlocked ?? false);
        $contentUnlockLabel = $contentUnlockAt ? $contentUnlockAt->format('d/m/Y H:i') . ' WIB' : null;
        $contentLockedMessage = $contentUnlockLabel
            ? 'Materi pembelajaran akan tersedia setelah agenda terakhir selesai pada ' . $contentUnlockLabel . '.'
            : 'Materi pembelajaran akan tersedia setelah agenda kelas selesai.';
        $accessEvent = $accessEvent ?? null;
        $isOfflineEvent = $accessEvent && (int) data_get($accessEvent, 'type') === 1;
        $accessLink = trim((string) data_get($accessEvent, $isOfflineEvent ? 'location' : 'link', ''));
        $accessValue = trim((string) data_get($accessEvent, $isOfflineEvent ? 'description' : 'password_link', ''));
        $accessValue = in_array($accessValue, ['', '-'], true) ? null : $accessValue;
        $accessLinkIsUrl =
            filter_var($accessLink, FILTER_VALIDATE_URL) &&
            in_array(parse_url($accessLink, PHP_URL_SCHEME), ['http', 'https'], true);
        $accessLinkUrl = $accessLinkIsUrl
            ? $accessLink
            : ($isOfflineEvent && $accessLink !== '' && $accessLink !== '-'
                ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($accessLink)
                : null);
        $jenis = collect(json_decode((string) data_get($class, 'jenis'), true) ?: [])
            ->map(fn($value) => ucwords(strtolower(str_replace(['_', '-'], ' ', $value))))
            ->implode(', ');
        $today = now()->startOfDay();
        $courseStatus =
            $endDate && $today->greaterThan(\Carbon\Carbon::parse($endDate)->endOfDay()) ? 'Selesai' : 'Kelas Anda';
        $courseStatusClass = $courseStatus === 'Selesai' ? 'completed' : 'owned';
    @endphp

    @once
        <style>
            .member-owned-class-detail {
                display: flex;
                flex-direction: column;
                gap: 24px;
            }

            .member-owned-class-detail__hero {
                position: relative;
                overflow: hidden;
                border-radius: 32px;
                background: #0f172a;
                color: #ffffff;
                box-shadow: 0 24px 70px rgba(15, 23, 42, .22);
            }

            .member-owned-class-detail__hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 18% 18%, rgba(79, 70, 229, .52), transparent 30%),
                    radial-gradient(circle at 82% 28%, rgba(6, 182, 212, .34), transparent 28%),
                    linear-gradient(135deg, rgba(15, 23, 42, .95), rgba(49, 46, 129, .9));
            }

            .member-owned-class-detail__hero::after {
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

            .member-owned-class-detail__hero-inner {
                position: relative;
                z-index: 1;
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(320px, 420px);
                gap: 28px;
                padding: 30px;
                align-items: stretch;
            }

            .member-owned-class-detail__hero-content {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                min-height: 420px;
            }

            .member-owned-class-detail__back-link {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                min-height: 40px;
                color: rgba(255, 255, 255, .82);
                font-size: 13px;
                font-weight: 850;
            }

            .member-owned-class-detail__back-link:hover {
                color: #ffffff;
            }

            .member-owned-class-detail__eyebrow {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin: 22px 0 18px;
            }

            .member-owned-class-detail__pill {
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

            .member-owned-class-detail__pill--owned {
                border-color: rgba(134, 239, 172, .32);
                background: rgba(220, 252, 231, .94);
                color: #166534;
            }

            .member-owned-class-detail__pill--completed {
                border-color: rgba(239, 68, 68, .34);
                background: rgba(254, 226, 226, .96);
                color: #b91c1c;
            }

            .member-owned-class-detail__title {
                max-width: 820px;
                margin: 0;
                font-size: clamp(32px, 4.6vw, 35px);
                font-weight: 950;
                letter-spacing: -.06em;
                line-height: .98;
            }

            .member-owned-class-detail__summary {
                max-width: 700px;
                margin: 18px 0 0;
                color: rgba(255, 255, 255, .76);
                font-size: 15.5px;
                line-height: 1.75;
            }

            .member-owned-class-detail__stats {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 10px;
                margin-top: 28px;
            }

            .member-owned-class-detail__stat {
                min-height: 86px;
                padding: 13px;
                border: 1px solid rgba(255, 255, 255, .14);
                border-radius: 18px;
                background: rgba(255, 255, 255, .1);
                backdrop-filter: blur(14px);
            }

            .member-owned-class-detail__stat-label,
            .member-owned-class-detail__owner-label {
                display: block;
                color: rgba(255, 255, 255, .58);
                font-size: 11px;
                font-weight: 900;
                letter-spacing: .06em;
                text-transform: uppercase;
            }

            .member-owned-class-detail__stat-value {
                display: block;
                margin-top: 7px;
                color: #ffffff;
                font-size: 14px;
                font-weight: 900;
                line-height: 1.35;
                overflow-wrap: break-word;
            }

            .member-owned-class-detail__visual {
                display: grid;
                grid-template-rows: minmax(260px, 1fr) auto;
                gap: 14px;
            }

            .member-owned-class-detail__cover {
                position: relative;
                overflow: hidden;
                border-radius: 24px;
                background: rgba(255, 255, 255, .08);
                box-shadow: 0 24px 54px rgba(15, 23, 42, .32);
            }

            .member-owned-class-detail__cover img {
                width: 100%;
                height: 100%;
                min-height: 300px;
                display: block;
                object-fit: cover;
            }

            .member-owned-class-detail__cover::after {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 46%, rgba(15, 23, 42, .72));
            }

            .member-owned-class-detail__ownership {
                display: flex;
                align-items: center;
                gap: 16px;
                padding: 16px;
                border: 1px solid rgba(255, 255, 255, .14);
                border-radius: 22px;
                background: rgba(255, 255, 255, .12);
                backdrop-filter: blur(14px);
            }

            .member-owned-class-detail__owner-value {
                display: block;
                margin-top: 4px;
                padding: 7px 11px;
                border: 1px solid rgba(134, 239, 172, .42);
                border-radius: 999px;
                background: #dcfce7;
                color: #166534;
                font-size: 12px;
                font-weight: 950;
                line-height: 1;
                animation: member-owned-class-detail-pulse 1.8s ease-in-out infinite;
            }

            .member-owned-class-detail__owner-value::before {
                content: "";
                display: inline-block;
                width: 7px;
                height: 7px;
                margin-right: 6px;
                border-radius: 50%;
                background: #16a34a;
                vertical-align: 1px;
            }

            @keyframes member-owned-class-detail-pulse {

                0%,
                100% {
                    opacity: 1;
                    box-shadow: 0 0 0 0 rgba(34, 197, 94, .3);
                }

                50% {
                    opacity: .62;
                    box-shadow: 0 0 0 7px rgba(34, 197, 94, 0);
                }
            }

            .member-owned-class-detail__body {
                display: grid;
                grid-template-columns: minmax(0, 1fr) 360px;
                gap: 22px;
                align-items: start;
            }

            .member-owned-class-detail__content,
            .member-owned-class-detail__sidebar {
                display: grid;
                gap: 18px;
                min-width: 0;
            }

            .member-owned-class-detail__panel {
                overflow: hidden;
                border: 1px solid #e7e9f0;
                border-radius: 24px;
                background: #ffffff;
                box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
            }

            .member-owned-class-detail__panel-body {
                padding: 24px;
            }

            .member-owned-class-detail__kicker {
                display: inline-flex;
                margin-bottom: 10px;
                color: var(--primary, #4F46E5);
                font-size: 11px;
                font-weight: 950;
                letter-spacing: .08em;
                text-transform: uppercase;
            }

            .member-owned-class-detail__section-title {
                margin: 0 0 14px;
                color: #111827;
                font-size: 24px;
                font-weight: 950;
                letter-spacing: -.045em;
                line-height: 1.12;
            }

            .member-owned-class-detail__description {
                color: #4b5563;
                font-size: 15px;
                line-height: 1.85;
            }

            .member-owned-class-detail__description p:last-child {
                margin-bottom: 0;
            }

            .member-owned-class-detail__content-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 18px;
                margin-bottom: 18px;
            }

            .member-owned-class-detail__content-count {
                flex: 0 0 auto;
                padding: 7px 11px;
                border-radius: 999px;
                background: var(--primary-soft, #EEF0FE);
                color: var(--primary, #4F46E5);
                font-size: 12px;
                font-weight: 900;
                white-space: nowrap;
            }

            .member-owned-class-detail__content-note {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 18px;
                padding: 13px 15px;
                border: 1px solid #bfdbfe;
                border-radius: 16px;
                background: #eff6ff;
                color: #1e40af;
                font-size: 13px;
                line-height: 1.6;
            }

            .member-owned-class-detail__content-note i {
                margin-top: 3px;
            }

            .member-owned-class-detail__content-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 14px;
            }

            .member-owned-class-detail__content-card {
                display: flex;
                min-width: 0;
                flex-direction: column;
                overflow: hidden;
                border: 1px solid #e7e9f0;
                border-radius: 18px;
                background: #ffffff;
                transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
            }

            .member-owned-class-detail__content-card:hover {
                border-color: rgba(79, 70, 229, .24);
                box-shadow: 0 14px 28px rgba(15, 23, 42, .08);
                transform: translateY(-2px);
            }

            .member-owned-class-detail__content-preview {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 150px;
                overflow: hidden;
                background-color: #eef0fe;
                background-image: linear-gradient(rgba(238, 240, 254, .84), rgba(248, 250, 252, .9)),
                    url('{{ asset(' bankir-academy-icon.png') }}');
                background-position: center, center;
                background-repeat: no-repeat;
                background-size: cover, 108px auto;
                color: var(--primary, #4F46E5);
            }

            .member-owned-class-detail__content-preview--image {
                display: block;
                min-height: 150px;
            }

            .member-owned-class-detail__content-preview--image img {
                width: 100%;
                height: 150px;
                display: block;
                object-fit: cover;
            }

            .member-owned-class-detail__content-preview i {
                position: relative;
                z-index: 1;
                font-size: 42px;
                text-shadow: 0 2px 8px rgba(255, 255, 255, .7);
            }

            .member-owned-class-detail__content-logo {
                position: absolute;
                z-index: 0;
                top: 50%;
                left: 50%;
                width: 82px;
                height: 82px;
                transform: translate(-50%, -50%);
                opacity: .42;
                pointer-events: none;
            }

            .member-owned-class-detail__content-logo img {
                width: 100% !important;
                height: 100% !important;
                display: block;
                object-fit: contain !important;
            }

            .member-owned-class-detail__content-preview--pdf {
                background-color: #fef2f2;
                background-image: linear-gradient(rgba(254, 242, 242, .84), rgba(255, 247, 247, .9)),
                    url('{{ asset(' bankir-academy-icon.png') }}');
                color: #dc2626;
            }

            .member-owned-class-detail__content-preview--image {
                background-color: #ecfeff;
                background-image: linear-gradient(rgba(236, 254, 255, .84), rgba(240, 253, 250, .9)),
                    url('{{ asset(' bankir-academy-icon.png') }}');
                color: #0891b2;
            }

            .member-owned-class-detail__content-preview--video {
                background-color: #f5f3ff;
                background-image: linear-gradient(rgba(245, 243, 255, .84), rgba(250, 245, 255, .9)),
                    url('{{ asset(' bankir-academy-icon.png') }}');
                color: #7c3aed;
            }

            .member-owned-class-detail__content-preview-button {
                width: 100%;
                padding: 0;
                border: 0;
                cursor: pointer;
                font: inherit;
            }

            .member-owned-class-detail__content-body {
                display: flex;
                flex: 1;
                flex-direction: column;
                padding: 15px;
            }

            .member-owned-class-detail__content-meta {
                display: flex;
                align-items: center;
                gap: 7px;
                margin-bottom: 8px;
                color: #6b7280;
                font-size: 11px;
                font-weight: 900;
                letter-spacing: .04em;
                text-transform: uppercase;
            }

            .member-owned-class-detail__content-title {
                display: -webkit-box;
                margin: 0;
                overflow: hidden;
                color: #111827;
                font-size: 15px;
                font-weight: 900;
                line-height: 1.4;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
            }

            .member-owned-class-detail__content-description {
                display: -webkit-box;
                margin: 7px 0 0;
                overflow: hidden;
                color: #6b7280;
                font-size: 12.5px;
                line-height: 1.55;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
            }

            .member-owned-class-detail__content-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: auto;
                padding-top: 14px;
            }

            .member-owned-class-detail__content-button {
                display: inline-flex;
                flex: 1 1 110px;
                align-items: center;
                justify-content: center;
                gap: 6px;
                min-height: 36px;
                padding: 8px 10px;
                border: 1px solid #e5e7eb;
                border-radius: 999px;
                background: #ffffff;
                color: var(--primary, #4F46E5);
                font-size: 11px;
                font-weight: 900;
                text-align: center;
            }

            .member-owned-class-detail__content-button:hover {
                border-color: var(--primary, #4F46E5);
                background: var(--primary-soft, #EEF0FE);
                color: var(--primary-dark, #3D33D8);
            }

            .member-owned-class-detail__content-button--primary {
                border-color: var(--primary, #4F46E5);
                background: var(--primary, #4F46E5);
                color: #ffffff;
            }

            .member-owned-class-detail__content-button--primary:hover {
                background: var(--primary-dark, #3D33D8);
                color: #ffffff;
            }

            .member-owned-class-detail__content-empty {
                padding: 30px 18px;
                border: 1px dashed #dbe2ea;
                border-radius: 16px;
                background: #f9fafb;
                color: #6b7280;
                font-size: 13px;
                line-height: 1.6;
                text-align: center;
            }

            .member-owned-class-detail__sidebar {
                position: sticky;
                top: calc(var(--topbar-h, 68px) + 18px);
            }

            .member-owned-class-detail__access-card {
                padding: 20px;
                border-radius: 24px;
                background: #111827;
                color: #ffffff;
                box-shadow: 0 18px 46px rgba(15, 23, 42, .18);
            }

            .member-owned-class-detail__access-title {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 150px;
                min-height: 38px;
                margin: 8px 0 12px;
                padding: 9px 18px;
                border: 1px solid rgba(134, 239, 172, .42);
                border-radius: 999px;
                background: #dcfce7;
                color: #166534;
                font-size: 15px;
                font-weight: 950;
                line-height: 1;
                animation: member-owned-class-detail-pulse 1.8s ease-in-out infinite;
            }

            .member-owned-class-detail__access-title::before {
                content: "";
                display: inline-block;
                width: 7px;
                height: 7px;
                margin-right: 6px;
                border-radius: 50%;
                background: #16a34a;
            }

            .member-owned-class-detail__access-text {
                margin: 0;
                color: rgba(255, 255, 255, .68);
                font-size: 13px;
                line-height: 1.65;
            }

            .member-owned-class-detail__meeting-card {
                padding: 20px;
                border: 1px solid #e7e9f0;
                border-radius: 24px;
                background: #ffffff;
                box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
            }

            .member-owned-class-detail__meeting-title {
                margin: 5px 0 16px;
                color: #111827;
                font-size: 21px;
                font-weight: 950;
                letter-spacing: -.04em;
                line-height: 1.15;
            }

            .member-owned-class-detail__meeting-field {
                padding: 12px;
                border: 1px solid #eef2f7;
                border-radius: 14px;
                background: #f9fafb;
            }

            .member-owned-class-detail__meeting-label {
                display: block;
                margin-bottom: 5px;
                color: #6b7280;
                font-size: 11px;
                font-weight: 900;
                letter-spacing: .05em;
                text-transform: uppercase;
            }

            .member-owned-class-detail__meeting-value {
                display: block;
                color: #111827;
                font-size: 14px;
                font-weight: 850;
                line-height: 1.5;
                overflow-wrap: anywhere;
            }

            .member-owned-class-detail__meeting-actions {
                display: grid;
                gap: 9px;
                margin-top: 12px;
            }

            .member-owned-class-detail__meeting-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                width: 100%;
                min-height: 42px;
                padding: 10px 13px;
                border: 1px solid var(--primary, #4F46E5);
                border-radius: 999px;
                background: var(--primary, #4F46E5);
                color: #ffffff;
                font-size: 12px;
                font-weight: 900;
                text-align: center;
                cursor: pointer;
            }

            .member-owned-class-detail__meeting-button:hover {
                background: var(--primary-dark, #3D33D8);
                color: #ffffff;
            }

            .member-owned-class-detail__meeting-button--secondary {
                border-color: #e5e7eb;
                background: #ffffff;
                color: var(--primary, #4F46E5);
            }

            .member-owned-class-detail__meeting-button--secondary:hover {
                border-color: var(--primary, #4F46E5);
                background: var(--primary-soft, #EEF0FE);
                color: var(--primary-dark, #3D33D8);
            }

            .member-owned-class-detail__meeting-empty {
                margin: 0;
                color: #6b7280;
                font-size: 13px;
                line-height: 1.6;
            }

            @media (max-width: 1199.98px) {

                .member-owned-class-detail__hero-inner,
                .member-owned-class-detail__body {
                    grid-template-columns: 1fr;
                }

                .member-owned-class-detail__hero-content,
                .member-owned-class-detail__sidebar {
                    min-height: auto;
                    position: static;
                }
            }

            @media (max-width: 767.98px) {
                .member-owned-class-detail__hero {
                    border-radius: 24px;
                }

                .member-owned-class-detail__hero-inner {
                    padding: 20px;
                    gap: 20px;
                }

                .member-owned-class-detail__stats {
                    grid-template-columns: 1fr;
                }

                .member-owned-class-detail__cover img {
                    min-height: 220px;
                }

                .member-owned-class-detail__ownership {
                    align-items: stretch;
                    flex-direction: column;
                }

                .member-owned-class-detail__panel-body {
                    padding: 18px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .member-owned-class-detail * {
                    transition: none !important;
                    animation: none !important;
                }
            }
        </style>
    @endonce

    <div class="member-owned-class-detail">
        <section class="member-owned-class-detail__hero" aria-labelledby="owned-class-title">
            <div class="member-owned-class-detail__hero-inner">
                <div class="member-owned-class-detail__hero-content">
                    <div>
                        <a href="{{ url('/kelas-event') }}" class="member-owned-class-detail__back-link">&larr; Kembali ke
                            kelas Anda</a>

                        <div class="member-owned-class-detail__eyebrow">
                            <span class="member-owned-class-detail__pill">{{ $category }}</span>
                            <span class="member-owned-class-detail__pill">{{ $level }}</span>
                            <span
                                class="member-owned-class-detail__pill member-owned-class-detail__pill--{{ $courseStatusClass }}">{{ $courseStatus }}</span>
                            @if ($isIht)
                                <span class="member-owned-class-detail__pill">IHT</span>
                            @endif
                            @if ($jenis !== '')
                                <span class="member-owned-class-detail__pill">{{ $jenis }}</span>
                            @endif
                        </div>

                        <h1 class="member-owned-class-detail__title" id="owned-class-title">{{ $title }}</h1>
                    </div>

                    <div class="member-owned-class-detail__stats" aria-label="Ringkasan kelas">
                        <div class="member-owned-class-detail__stat">
                            <span class="member-owned-class-detail__stat-label">Peserta terdaftar</span>
                            <span class="member-owned-class-detail__stat-value">{{ $participantCount }} orang</span>
                        </div>
                        <div class="member-owned-class-detail__stat">
                            <span class="member-owned-class-detail__stat-label">Waktu</span>
                            <span class="member-owned-class-detail__stat-value">{{ $courseTimeLabel }}</span>
                        </div>
                        <div class="member-owned-class-detail__stat">
                            <span class="member-owned-class-detail__stat-label">Metode</span>
                            <span class="member-owned-class-detail__stat-value">{{ $mode }}</span>
                        </div>
                        <div class="member-owned-class-detail__stat">
                            <span class="member-owned-class-detail__stat-label">Lokasi</span>
                            <span class="member-owned-class-detail__stat-value">{{ $locationLabel }}</span>
                        </div>
                    </div>
                </div>

                <div class="member-owned-class-detail__visual">
                    <div class="member-owned-class-detail__cover">
                        <img src="{{ $image }}" alt="{{ $title }}" loading="eager"
                            onerror="this.src='{{ asset('assets/img/90x90.jpg') }}'">
                    </div>

                    <!-- <div class="member-owned-class-detail__ownership">
                            <div>
                                <span class="member-owned-class-detail__owner-label">Status akses</span>
                                <span class="member-owned-class-detail__owner-value">Kelas Aktif</span>
                            </div>
                        </div> -->
                </div>
            </div>
        </section>

        <div class="member-owned-class-detail__body">
            <main class="member-owned-class-detail__content">
                <section class="member-owned-class-detail__panel" aria-labelledby="owned-class-about-title">
                    <div class="member-owned-class-detail__panel-body">
                        <span class="member-owned-class-detail__kicker">Tentang Kelas</span>
                        <h2 class="member-owned-class-detail__section-title" id="owned-class-about-title">Ringkasan
                            pembelajaran</h2>
                        <div class="member-owned-class-detail__description">
                            @if (data_get($class, 'content'))
                                {!! data_get($class, 'content') !!}
                            @else
                                <p>Deskripsi kelas belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="member-owned-class-detail__panel" aria-labelledby="owned-class-content-title">
                    <div class="member-owned-class-detail__panel-body">
                        <div class="member-owned-class-detail__content-header">
                            <div>
                                <span class="member-owned-class-detail__kicker">Materi</span>
                                <h2 class="member-owned-class-detail__section-title mb-0" id="owned-class-content-title">
                                    Materi pembelajaran</h2>
                            </div>
                            <span class="member-owned-class-detail__content-count">{{ $contentCount }} materi</span>
                        </div>

                        @if (!$contentUnlocked)
                            <div class="member-owned-class-detail__content-note" role="status">
                                <i class="fas fa-lock" aria-hidden="true"></i>
                                <span>{{ $contentLockedMessage }}</span>
                            </div>
                        @endif

                        @if ($contentCount === 0)
                            <p class="member-owned-class-detail__content-empty">Belum ada materi pembelajaran yang tersedia
                                untuk kelas ini.</p>
                        @else
                            <div class="member-owned-class-detail__content-grid">
                                @foreach ($contents as $content)
                                    @php
                                        $contentType = (int) $content->type;
                                        $typeMeta = [
                                            0 => ['label' => 'PDF', 'icon' => 'fa-file-pdf', 'class' => 'pdf'],
                                            \App\Models\ClassContentModel::TYPE_DOCUMENT => [
                                                'label' => 'PDF',
                                                'icon' => 'fa-file-pdf',
                                                'class' => 'pdf',
                                            ],
                                            \App\Models\ClassContentModel::TYPE_IMAGE => [
                                                'label' => 'Gambar',
                                                'icon' => 'fa-image',
                                                'class' => 'image',
                                            ],
                                            \App\Models\ClassContentModel::TYPE_VIDEO => [
                                                'label' => 'Video',
                                                'icon' => 'fa-play-circle',
                                                'class' => 'video',
                                            ],
                                        ][$contentType] ?? [
                                            'label' => 'Materi',
                                            'icon' => 'fa-file',
                                            'class' => 'file',
                                        ];
                                        $contentPath = trim((string) $content->url);
                                        $hasStoredFile = $contentPath !== '' && $contentPath !== '-';
                                        $contentUrl = route('membernonanggota.class.content', [
                                            'contentId' => $content->id,
                                        ]);
                                        $downloadUrl = $contentUrl . '?download=1';
                                        $videoUrl =
                                            filter_var($contentPath, FILTER_VALIDATE_URL) &&
                                            in_array(parse_url($contentPath, PHP_URL_SCHEME), ['http', 'https'], true)
                                                ? $contentPath
                                                : null;
                                        $description = trim((string) $content->description);
                                        $description = $description === '-' ? '' : $description;
                                    @endphp

                                    <article class="member-owned-class-detail__content-card">
                                        @if ($contentType === \App\Models\ClassContentModel::TYPE_IMAGE && $hasStoredFile)
                                            @if ($contentUnlocked)
                                                <a href="{{ $contentUrl }}" target="_blank" rel="noopener"
                                                    class="member-owned-class-detail__content-preview member-owned-class-detail__content-preview--image"
                                                    aria-label="Lihat {{ $content->title }}">
                                                    <img src="{{ $contentUrl }}" alt="{{ $content->title }}"
                                                        loading="lazy">
                                                </a>
                                            @else
                                                <button type="button"
                                                    class="member-owned-class-detail__content-preview member-owned-class-detail__content-preview--image member-owned-class-detail__content-preview-button"
                                                    data-content-locked data-alert-text="{{ $contentLockedMessage }}"
                                                    aria-label="Materi {{ $content->title }} terkunci">
                                                    <span class="member-owned-class-detail__content-logo"
                                                        aria-hidden="true">
                                                        <img src="{{ asset('bankir-academy-icon.png') }}" alt="">
                                                    </span>
                                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        @elseif(!$contentUnlocked)
                                            <button type="button"
                                                class="member-owned-class-detail__content-preview member-owned-class-detail__content-preview--{{ $typeMeta['class'] }} member-owned-class-detail__content-preview-button"
                                                data-content-locked data-alert-text="{{ $contentLockedMessage }}"
                                                aria-label="Materi {{ $content->title }} terkunci">
                                                <span class="member-owned-class-detail__content-logo" aria-hidden="true">
                                                    <img src="{{ asset('bankir-academy-icon.png') }}" alt="">
                                                </span>
                                                <i class="fas fa-lock" aria-hidden="true"></i>
                                            </button>
                                        @else
                                            <div class="member-owned-class-detail__content-preview member-owned-class-detail__content-preview--{{ $typeMeta['class'] }}"
                                                aria-hidden="true">
                                                <span class="member-owned-class-detail__content-logo">
                                                    <img src="{{ asset('bankir-academy-icon.png') }}" alt="">
                                                </span>
                                                <i class="fas {{ $typeMeta['icon'] }}"></i>
                                            </div>
                                        @endif

                                        <div class="member-owned-class-detail__content-body">
                                            <div class="member-owned-class-detail__content-meta">
                                                <i class="fas {{ $typeMeta['icon'] }}" aria-hidden="true"></i>
                                                {{ $typeMeta['label'] }}
                                            </div>
                                            <h3 class="member-owned-class-detail__content-title">
                                                {{ $content->title ?: 'Materi kelas' }}</h3>
                                            @if ($description !== '')
                                                <p class="member-owned-class-detail__content-description">
                                                    {{ $description }}</p>
                                            @endif

                                            <div class="member-owned-class-detail__content-actions">
                                                @if (!$contentUnlocked)
                                                    <button type="button"
                                                        class="member-owned-class-detail__content-button member-owned-class-detail__content-button--primary"
                                                        data-content-locked data-alert-text="{{ $contentLockedMessage }}">
                                                        <i class="fas fa-lock" aria-hidden="true"></i> Materi Terkunci
                                                    </button>
                                                @elseif($contentType === \App\Models\ClassContentModel::TYPE_VIDEO && $videoUrl)
                                                    <a href="{{ $videoUrl }}" target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="member-owned-class-detail__content-button member-owned-class-detail__content-button--primary">
                                                        <i class="fas fa-play" aria-hidden="true"></i> Tonton Video
                                                    </a>
                                                @elseif(in_array(
                                                        $contentType,
                                                        [0, \App\Models\ClassContentModel::TYPE_DOCUMENT, \App\Models\ClassContentModel::TYPE_IMAGE],
                                                        true) && $hasStoredFile)
                                                    <a href="{{ $contentUrl }}" target="_blank" rel="noopener"
                                                        class="member-owned-class-detail__content-button">
                                                        <i class="fas fa-eye" aria-hidden="true"></i> Buka
                                                    </a>
                                                    <a href="{{ $downloadUrl }}"
                                                        class="member-owned-class-detail__content-button member-owned-class-detail__content-button--primary">
                                                        <i class="fas fa-download" aria-hidden="true"></i> Unduh
                                                    </a>
                                                @else
                                                    <span class="member-owned-class-detail__content-button">Materi belum
                                                        tersedia</span>
                                                @endif
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>

            </main>

            <aside class="member-owned-class-detail__sidebar" aria-label="Status kelas">
                <section class="member-owned-class-detail__access-card">
                    <span class="member-owned-class-detail__owner-label">Akses pembelajaran</span>
                    <h2 class="member-owned-class-detail__access-title">Kelas Aktif</h2>
                    <p class="member-owned-class-detail__access-text">Anda sudah membeli kelas ini. Tidak ada proses
                        pendaftaran atau pembelian ulang yang diperlukan.</p>
                </section>

                <section class="member-owned-class-detail__meeting-card" aria-labelledby="owned-class-meeting-title">
                    <span class="member-owned-class-detail__kicker">Pertemuan kelas</span>
                    <h2 class="member-owned-class-detail__meeting-title" id="owned-class-meeting-title">
                        {{ $isOfflineEvent ? 'Informasi lokasi' : 'Video Conference' }}
                    </h2>

                    @if ($accessEvent)
                        <div class="member-owned-class-detail__meeting-field">
                            <span
                                class="member-owned-class-detail__meeting-label">{{ $isOfflineEvent ? 'Alamat' : 'Passcode Zoom' }}</span>
                            <span
                                class="member-owned-class-detail__meeting-value">{{ $accessValue ?: ($isOfflineEvent ? 'Alamat belum tersedia' : 'Passcode belum tersedia') }}</span>
                        </div>

                        <div class="member-owned-class-detail__meeting-actions">
                            @if ($accessValue)
                                <button type="button"
                                    class="member-owned-class-detail__meeting-button member-owned-class-detail__meeting-button--secondary"
                                    data-copy-value="{{ $accessValue }}">
                                    <i class="fas fa-copy" aria-hidden="true"></i> Salin
                                    {{ $isOfflineEvent ? 'Alamat' : 'Passcode' }}
                                </button>
                            @endif

                            @if ($accessLinkUrl)
                                <a href="{{ $accessLinkUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="member-owned-class-detail__meeting-button">
                                    <i class="fas {{ $isOfflineEvent ? 'fa-map-marker-alt' : 'fa-video' }}"
                                        aria-hidden="true"></i>
                                    {{ $isOfflineEvent ? 'Buka Link Lokasi' : 'Buka Link Zoom' }}
                                </a>
                            @endif
                        </div>
                    @else
                        <p class="member-owned-class-detail__meeting-empty">
                            Informasi agenda belum tersedia.
                        </p>
                    @endif
                </section>

            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(event) {
            var copyButton = event.target.closest('[data-copy-value]');

            if (copyButton) {
                event.preventDefault();

                copyToClipboard(copyButton.dataset.copyValue || '').then(function() {
                    var originalContent = copyButton.innerHTML;
                    copyButton.innerHTML = '<i class="fas fa-check" aria-hidden="true"></i> Tersalin';

                    window.setTimeout(function() {
                        copyButton.innerHTML = originalContent;
                    }, 1600);
                }).catch(function() {
                    if (window.Swal && typeof window.Swal.fire === 'function') {
                        window.Swal.fire({
                            icon: 'warning',
                            title: 'Gagal menyalin',
                            text: 'Silakan salin informasi ini secara manual.'
                        });
                    }
                });

                return;
            }

            var lockedMaterial = event.target.closest('[data-content-locked]');

            if (!lockedMaterial) {
                return;
            }

            event.preventDefault();

            var message = lockedMaterial.dataset.alertText || 'Materi pembelajaran belum tersedia.';

            if (window.Swal && typeof window.Swal.fire === 'function') {
                window.Swal.fire({
                    icon: 'info',
                    title: 'Materi belum tersedia',
                    text: message,
                    confirmButtonText: 'Mengerti'
                });
            } else {
                window.alert(message);
            }
        });

        function copyToClipboard(value) {
            if (navigator.clipboard && window.isSecureContext) {
                return navigator.clipboard.writeText(value);
            }

            return new Promise(function(resolve, reject) {
                var textarea = document.createElement('textarea');
                textarea.value = value;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.focus();
                textarea.select();

                try {
                    document.execCommand('copy') ? resolve() : reject();
                } catch (error) {
                    reject(error);
                } finally {
                    textarea.remove();
                }
            });
        }
    </script>
@endsection
