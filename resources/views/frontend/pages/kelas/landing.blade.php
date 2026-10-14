@php
    $title = data_get($class, 'title', 'Kelas Bankir Academy');
    $category = data_get($class, 'category') ?: 'Kelas pilihan';
    $levelLabels = [1 => 'Pemula', 2 => 'Menengah', 3 => 'Lanjutan'];
    $level = $levelLabels[(int) data_get($class, 'level')] ?? 'Semua level';
    $mode = (int) data_get($class, 'kategori') === 1 ? 'Offline' : 'Online';
    $isIht = (int) data_get($class, 'iht') === 1;
    $startDate = data_get($class, 'date_start');
    $endDate = data_get($class, 'date_end');
    $classDate = data_get($class, 'class_date');
    $isUpcoming = $startDate && now()->startOfDay()->lt(\Carbon\Carbon::parse($startDate)->startOfDay());
    $isClosed = $endDate && now()->startOfDay()->gt(\Carbon\Carbon::parse($endDate)->endOfDay());
    $pricing = data_get($class, 'pricing');
    $resolvedPricing = data_get($pricing, 'resolved', []);
    $regularPrice = (int) data_get($pricing, 'price', 0);
    $promoPrice = (int) data_get($pricing, 'promo_price', 0);
    $finalPrice = (int) data_get($resolvedPricing, 'final_price', max(0, $regularPrice - $promoPrice));
    $isFree = !$isIht && (int) data_get($pricing, 'gratis', 0) === 1;
    $priceComingSoon = !$isIht && !$pricing;
    $canCheckout = !$isIht && !$isUpcoming && !$isClosed && !$priceComingSoon;
    $priceLabel = $isIht
        ? 'Konsultasikan'
        : ($priceComingSoon ? 'Segera hadir' : ($isFree || $finalPrice === 0 ? 'Gratis' : 'Rp ' . number_format($finalPrice, 0, ',', '.')));
    $description = trim(strip_tags((string) data_get($class, 'content', '')));
    $description = $description ?: 'Program praktis untuk membantu Anda membangun kompetensi yang relevan dan siap diterapkan.';
    $tags = collect(json_decode((string) data_get($class, 'tags'), true) ?: [])
        ->map(fn($tag) => ucwords(strtolower(str_replace(['_', '-'], ' ', (string) $tag))))
        ->filter()
        ->take(4);
    $events = collect(data_get($class, 'event_list', []));
    $instructors = collect(data_get($class, 'instructor_list', []));
    $shortDate = $classDate ? \Carbon\Carbon::parse($classDate)->translatedFormat('d M Y') : 'Tanggal diumumkan segera';
    $registrationDate = $startDate ? \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') : 'Terbuka';
    $location = $mode === 'Online' ? 'Online via live class' : (data_get($class, 'lokasi') ?: 'Lokasi diumumkan segera');
    $assetUrl = function ($path, $fallback = 'bankir-academy-icon.png') {
        if (!$path) {
            return asset($fallback);
        }

        return filter_var($path, FILTER_VALIDATE_URL) ? $path : asset(ltrim($path, '/'));
    };
    $cover = $assetUrl(data_get($class, 'image_mobile') ?: data_get($class, 'image'));
    $wideCover = $assetUrl(data_get($class, 'image') ?: data_get($class, 'image_mobile'));
    $gallery = collect([$cover, $wideCover]);
    foreach ($instructors as $instructor) {
        $picture = data_get($instructor, 'picture_src.url') ?: data_get($instructor, 'picture');
        if ($picture) {
            $gallery->push($assetUrl($picture));
        }
    }
    foreach ($relatedClasses as $related) {
        $gallery->push($assetUrl(data_get($related, 'image_mobile') ?: data_get($related, 'image')));
    }
    $gallery = $gallery->unique()->values();
    $profile = auth()->check() ? auth()->user()->userProfile : null;
    $availableThemes = ['market-orange', 'mint-cobalt', 'violet-lime', 'midnight-sky'];
    $theme = in_array(data_get($class, 'landing_page_theme'), $availableThemes, true)
        ? data_get($class, 'landing_page_theme')
        : $availableThemes[0];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($description, 150) }}">
    <title>{{ $title }} | Bankir Academy</title>
    <link rel="icon" href="{{ asset('bankir-academy-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #172033;
            --muted: #6d7485;
            --paper: #fffaf2;
            --orange: #ff654f;
            --orange-dark: #e84d3e;
            --purple: #6556df;
            --yellow: #ffd85a;
            --mint: #c9f1df;
            --line: #eee5da;
        }

        .landing-page.theme-mint-cobalt {
            --ink: #12324a;
            --muted: #607689;
            --paper: #f5fff9;
            --orange: #1fa47d;
            --orange-dark: #13775d;
            --purple: #1d5683;
            --yellow: #e8f36c;
            --mint: #d7f4e9;
            --line: #dcece5;
        }

        .landing-page.theme-violet-lime {
            --ink: #241b4b;
            --muted: #77708f;
            --paper: #fcfaff;
            --orange: #8a5be8;
            --orange-dark: #6741be;
            --purple: #3d236f;
            --yellow: #d9f45c;
            --mint: #ece5ff;
            --line: #e9e1f7;
        }

        .landing-page.theme-midnight-sky {
            --ink: #10283f;
            --muted: #65778b;
            --paper: #f6fbff;
            --orange: #2e86df;
            --orange-dark: #1c64b0;
            --purple: #183b68;
            --yellow: #ffc85b;
            --mint: #dff4ff;
            --line: #dce9f4;
        }

        .landing-page.theme-mint-cobalt .hero-media-main {
            right: auto;
            left: 8%;
            width: 76%;
            border-radius: 8px 26px 8px 26px;
            transform: rotate(-2.5deg);
        }

        .landing-page.theme-mint-cobalt .hero-media-small {
            right: 0;
            left: auto;
            transform: rotate(7deg);
        }

        .landing-page.theme-violet-lime .benefit-grid {
            grid-template-columns: 1fr;
        }

        .landing-page.theme-violet-lime .benefit-card {
            min-height: auto;
            display: grid;
            grid-template-columns: 31px 1fr;
            column-gap: 11px;
            align-items: center;
        }

        .landing-page.theme-violet-lime .benefit-icon {
            grid-row: 1 / 3;
            margin-bottom: 0;
        }

        .landing-page.theme-midnight-sky .hero-media-main {
            width: 88%;
            height: 205px;
            border-radius: 12px;
            transform: rotate(0);
        }

        .landing-page.theme-midnight-sky .hero-media-small {
            bottom: 5px;
            width: 96px;
            height: 100px;
            border-radius: 50%;
            transform: rotate(-4deg);
        }

        .landing-page.theme-midnight-sky .hero-sticker {
            top: 1px;
            right: 16px;
            border-radius: 12px;
            transform: rotate(-5deg);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: #e9e4ee;
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
        }

        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .landing-page {
            width: 390px;
            min-height: 100vh;
            margin: 0 auto;
            overflow: hidden;
            background: var(--paper);
            box-shadow: 0 0 70px rgba(48, 38, 69, .16);
        }

        .landing-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px 12px;
            background: var(--paper);
        }

        .brand { display: inline-flex; align-items: center; gap: 9px; font-family: 'Space Grotesk', sans-serif; font-size: 14px; font-weight: 700; }
        .brand img { width: 27px; height: 27px; object-fit: contain; }
        .topbar-link { color: var(--muted); font-size: 12px; font-weight: 700; }
        .hero { position: relative; padding: 12px 18px 30px; background: var(--orange); }
        .hero::before { position: absolute; inset: 0; content: ''; background: radial-gradient(circle at 84% 10%, rgba(255, 255, 255, .25), transparent 25%), radial-gradient(circle at 0 85%, rgba(235, 58, 64, .36), transparent 28%); pointer-events: none; }
        .hero-inner { position: relative; }
        .promo-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 17px; }
        .promo-badge { padding: 7px 11px; border-radius: 8px 8px 8px 2px; background: var(--yellow); color: #5c3e00; font-size: 10px; font-weight: 800; letter-spacing: .05em; text-transform: uppercase; transform: rotate(-2deg); }
        .share-chip { display: inline-flex; align-items: center; gap: 5px; color: rgba(255,255,255,.86); font-size: 11px; font-weight: 700; }
        .hero h1 { max-width: 310px; margin: 0; color: #fff; font-family: 'Space Grotesk', sans-serif; font-size: 31px; font-weight: 700; letter-spacing: -.06em; line-height: 1.02; }
        .hero-copy { margin: 13px 0 20px; color: rgba(255,255,255,.87); font-size: 13px; line-height: 1.6; }
        .hero-media { position: relative; height: 240px; margin: 0 -2px; }
        .hero-media-main { position: absolute; right: 0; bottom: 0; width: 79%; height: 214px; overflow: hidden; border: 6px solid #fff; border-radius: 24px 8px 24px 8px; background: #f2d6c1; transform: rotate(2.5deg); box-shadow: 0 16px 28px rgba(161, 47, 50, .2); }
        .hero-media-main img { width: 100%; height: 100%; display: block; object-fit: cover; }
        .hero-media-small { position: absolute; z-index: 1; left: 0; bottom: 18px; width: 111px; height: 122px; overflow: hidden; border: 5px solid #fff; border-radius: 15px; background: var(--purple); transform: rotate(-7deg); box-shadow: 0 12px 22px rgba(84, 44, 74, .2); }
        .hero-media-small img { width: 100%; height: 100%; display: block; object-fit: cover; }
        .hero-sticker { position: absolute; z-index: 2; top: 8px; right: 4px; display: grid; place-items: center; width: 65px; height: 65px; border-radius: 50%; background: var(--yellow); color: #563a05; font-family: 'Space Grotesk', sans-serif; font-size: 12px; font-weight: 700; line-height: 1.05; text-align: center; transform: rotate(10deg); box-shadow: 0 5px 0 rgba(104, 66, 0, .16); }
        .hero-ribbon { position: absolute; z-index: 2; bottom: 7px; right: 12px; padding: 7px 12px; border-radius: 8px; background: var(--ink); color: #fff; font-size: 11px; font-weight: 700; transform: rotate(-4deg); }

        .section { padding: 27px 18px; }
        .section-kicker { display: block; margin-bottom: 8px; color: var(--orange-dark); font-size: 10px; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
        .section h2 { margin: 0; font-family: 'Space Grotesk', sans-serif; font-size: 25px; letter-spacing: -.045em; line-height: 1.05; }
        .section-lead { margin: 10px 0 0; color: var(--muted); font-size: 13px; line-height: 1.65; }
        .trust-strip { display: flex; align-items: center; gap: 10px; padding: 13px 18px; background: var(--ink); color: #fff; }
        .trust-avatars { display: flex; padding-left: 4px; }
        .trust-avatar { width: 26px; height: 26px; margin-left: -4px; border: 2px solid var(--ink); border-radius: 50%; object-fit: cover; background: #fff; }
        .trust-copy { color: rgba(255,255,255,.8); font-size: 10px; line-height: 1.4; }
        .trust-copy strong { display: block; color: #fff; font-size: 11px; }

        .benefit-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 17px; }
        .benefit-card { min-height: 128px; padding: 14px; border-radius: 17px; background: #fff; border: 1px solid var(--line); }
        .benefit-card:nth-child(2) { background: #fff0d1; border-color: #ffe1a2; }
        .benefit-card:nth-child(3) { background: var(--mint); border-color: #b6e9d1; }
        .benefit-card:nth-child(4) { background: #e8e5ff; border-color: #d5d0ff; }
        .benefit-icon { display: grid; place-items: center; width: 31px; height: 31px; margin-bottom: 12px; border-radius: 10px; background: var(--ink); color: #fff; font-size: 14px; font-weight: 700; }
        .benefit-card h3 { margin: 0 0 5px; font-family: 'Space Grotesk', sans-serif; font-size: 14px; letter-spacing: -.02em; }
        .benefit-card p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.45; }

        .schedule-card { margin-top: 17px; padding: 16px; border-radius: 19px; background: var(--ink); color: #fff; }
        .schedule-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 15px; }
        .schedule-head strong { font-family: 'Space Grotesk', sans-serif; font-size: 16px; }
        .schedule-tag { padding: 6px 8px; border-radius: 8px; background: var(--yellow); color: #5c3e00; font-size: 9px; font-weight: 800; }
        .schedule-row { display: grid; grid-template-columns: 35px 1fr; gap: 11px; padding: 11px 0; border-top: 1px solid rgba(255,255,255,.12); }
        .schedule-number { display: grid; place-items: center; width: 30px; height: 30px; border-radius: 10px; background: var(--orange); font-size: 11px; font-weight: 800; }
        .schedule-row strong { display: block; margin-bottom: 2px; font-size: 12px; }
        .schedule-row span { color: rgba(255,255,255,.6); font-size: 11px; line-height: 1.45; }

        .story-card { position: relative; overflow: hidden; margin: 0 18px; padding: 21px 18px 20px; border-radius: 22px; background: var(--purple); color: #fff; }
        .story-card::after { position: absolute; right: -38px; bottom: -56px; width: 150px; height: 150px; border: 20px solid rgba(255,255,255,.12); border-radius: 50%; content: ''; }
        .story-card h2 { max-width: 260px; }
        .story-card p { position: relative; z-index: 1; margin: 11px 0 0; color: rgba(255,255,255,.8); font-size: 12px; line-height: 1.65; }
        .tag-row { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 15px; }
        .tag { padding: 6px 9px; border: 1px solid rgba(255,255,255,.22); border-radius: 999px; color: #fff; font-size: 10px; font-weight: 700; }

        .gallery { display: grid; grid-template-columns: 1.25fr .75fr; grid-template-rows: 95px 95px; gap: 8px; margin-top: 16px; }
        .gallery-item { overflow: hidden; border-radius: 14px; background: #e7dfd7; }
        .gallery-item:first-child { grid-row: 1 / 3; }
        .gallery-item img { width: 100%; height: 100%; display: block; object-fit: cover; }

        .checkout-section { padding: 28px 18px 35px; background: #fff; }
        .checkout-section h2 { margin-bottom: 7px; }
        .form-note { margin: 0 0 18px; color: var(--muted); font-size: 12px; line-height: 1.55; }
        .alert { margin-bottom: 14px; padding: 11px 12px; border-radius: 12px; background: #fff0ed; color: #9f2f27; font-size: 11px; line-height: 1.5; }
        .field { margin-top: 12px; }
        .field label { display: block; margin-bottom: 6px; color: var(--ink); font-size: 11px; font-weight: 800; }
        .field input { width: 100%; min-height: 45px; padding: 10px 12px; border: 1px solid #e5e0d9; border-radius: 12px; outline: none; background: #fffaf7; color: var(--ink); font-size: 13px; }
        .field input:focus { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(255,101,79,.14); }
        .field input[readonly] { color: var(--muted); background: #f6f3ef; }
        .field small { display: block; margin-top: 5px; color: var(--muted); font-size: 10px; }
        .account-box { margin-top: 17px; padding: 13px; border: 1px dashed #f0bbac; border-radius: 14px; background: #fff8f3; }
        .account-box strong { display: block; font-size: 12px; }
        .account-box p { margin: 4px 0 0; color: var(--muted); font-size: 10px; line-height: 1.5; }
        .gateway-card { display: flex; align-items: flex-start; gap: 10px; margin-top: 18px; padding: 14px; border: 2px solid var(--orange); border-radius: 15px; background: #fff8f3; }
        .gateway-card input { margin-top: 3px; accent-color: var(--orange); }
        .gateway-card strong { display: block; font-size: 12px; }
        .gateway-card > span { display: block; margin-top: 4px; color: var(--muted); font-size: 10px; line-height: 1.45; }
        .gateway-logos { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .gateway-logos img { width: auto; height: 17px; max-width: 42px; object-fit: contain; }
        .terms { display: flex; gap: 8px; align-items: flex-start; margin-top: 17px; color: var(--muted); font-size: 10px; line-height: 1.45; }
        .terms input { margin-top: 2px; accent-color: var(--orange); }
        .submit-button { width: 100%; min-height: 51px; margin-top: 17px; border: 0; border-radius: 14px; background: var(--orange); color: #fff; font-family: 'Space Grotesk', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 10px 20px rgba(232,77,62,.2); }
        .submit-button:hover { background: var(--orange-dark); }
        .submit-button:disabled { cursor: not-allowed; background: #bcb7b0; box-shadow: none; }
        .security-note { display: flex; align-items: center; justify-content: center; gap: 5px; margin: 12px 0 0; color: #8a8b8b; font-size: 10px; }

        .faq-list { display: grid; gap: 8px; margin-top: 16px; }
        .faq-item { overflow: hidden; border: 1px solid var(--line); border-radius: 13px; background: #fff; }
        .faq-question { display: flex; width: 100%; align-items: center; justify-content: space-between; gap: 10px; padding: 14px; border: 0; background: transparent; color: var(--ink); font-size: 12px; font-weight: 700; text-align: left; cursor: pointer; }
        .faq-answer { display: none; padding: 0 14px 14px; color: var(--muted); font-size: 11px; line-height: 1.55; }
        .faq-item.is-open .faq-answer { display: block; }
        .faq-item.is-open .faq-question span { transform: rotate(45deg); }
        .faq-question span { color: var(--orange); font-size: 19px; font-weight: 400; transition: transform .2s; }

        .related-list { display: flex; gap: 10px; overflow-x: auto; margin: 16px -18px 0; padding: 0 18px 5px; scrollbar-width: none; }
        .related-list::-webkit-scrollbar { display: none; }
        .related-card { flex: 0 0 160px; overflow: hidden; border: 1px solid var(--line); border-radius: 15px; background: #fff; }
        .related-card img { width: 100%; height: 85px; display: block; object-fit: cover; }
        .related-card span { display: block; padding: 10px; font-size: 11px; font-weight: 700; line-height: 1.35; }
        .footer { padding: 23px 18px 92px; background: var(--ink); color: rgba(255,255,255,.6); font-size: 10px; line-height: 1.6; }
        .footer strong { color: #fff; font-family: 'Space Grotesk', sans-serif; font-size: 14px; }
        .sticky-cta { position: fixed; z-index: 10; bottom: 0; left: 50%; display: flex; width: 390px; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 18px calc(12px + env(safe-area-inset-bottom)); transform: translateX(-50%); background: rgba(255,250,242,.94); border-top: 1px solid var(--line); backdrop-filter: blur(14px); }
        .sticky-cta small { display: block; color: var(--muted); font-size: 9px; }
        .sticky-cta strong { display: block; color: var(--ink); font-family: 'Space Grotesk', sans-serif; font-size: 15px; }
        .sticky-cta a { display: inline-flex; min-height: 40px; align-items: center; justify-content: center; padding: 0 16px; border-radius: 11px; background: var(--orange); color: #fff; font-size: 11px; font-weight: 800; }

        @media (max-width: 430px) {
            .landing-page { width: 100%; box-shadow: none; }
            .sticky-cta { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } *, *::before, *::after { transition: none !important; } }
    </style>
</head>
<body>
<div class="landing-page theme-{{ $theme }}">
    <header class="landing-topbar">
        <a class="brand" href="{{ route('frontend.home') }}"><img src="{{ asset('bankir-academy-icon.png') }}" alt=""> Bankir Academy</a>
        <a class="topbar-link" href="#faq">Bantuan</a>
    </header>

    <main>
        <section class="hero">
            <div class="hero-inner">
                <div class="promo-row">
                    <span class="promo-badge">Limited class · 2026</span>
                    <a class="share-chip" href="#daftar">Amankan kursi →</a>
                </div>
                <h1>{{ $title }}</h1>
                <p class="hero-copy">{{ \Illuminate\Support\Str::limit($description, 140) }}</p>
                <div class="hero-media" aria-label="Preview kelas">
                    <div class="hero-media-small"><img src="{{ $wideCover }}" alt="Visual {{ $title }}" onerror="this.src='{{ asset('bankir-academy-icon.png') }}'"></div>
                    <div class="hero-media-main"><img src="{{ $cover }}" alt="Banner {{ $title }}" onerror="this.src='{{ asset('bankir-academy-icon.png') }}'"></div>
                    <span class="hero-sticker">LEVEL<br>{{ strtoupper($level) }}</span>
                    <span class="hero-ribbon">{{ $category }}</span>
                </div>
            </div>
        </section>

        <div class="trust-strip">
            <div class="trust-avatars">
                @forelse($instructors->take(3) as $instructor)
                    @php $instructorPicture = data_get($instructor, 'picture_src.url') ?: data_get($instructor, 'picture'); @endphp
                    <img class="trust-avatar" src="{{ $assetUrl($instructorPicture) }}" alt="" onerror="this.src='{{ asset('bankir-academy-icon.png') }}'">
                @empty
                    <img class="trust-avatar" src="{{ asset('bankir-academy-icon.png') }}" alt="">
                    <img class="trust-avatar" src="{{ asset('bankir-academy-icon.png') }}" alt="">
                @endforelse
            </div>
            <div class="trust-copy"><strong>Belajar dari praktisi</strong>Materi dikemas ringkas, aplikatif, dan terarah.</div>
        </div>

        <section class="section">
            <span class="section-kicker">Kenapa kelas ini?</span>
            <h2>Satu langkah kecil, skill yang terasa besar.</h2>
            <p class="section-lead">Bukan sekadar menonton. Anda pulang membawa pemahaman, contoh, dan bahan yang bisa dipakai.</p>
            <div class="benefit-grid">
                <article class="benefit-card"><span class="benefit-icon">01</span><h3>Materi terarah</h3><p>Alur belajar disusun dari konsep penting sampai penerapan.</p></article>
                <article class="benefit-card"><span class="benefit-icon">02</span><h3>Praktis & relevan</h3><p>Contoh dekat dengan kebutuhan dunia kerja perbankan.</p></article>
                <article class="benefit-card"><span class="benefit-icon">03</span><h3>Mentor berpengalaman</h3><p>Dapatkan perspektif dari orang yang pernah menjalankannya.</p></article>
                <article class="benefit-card"><span class="benefit-icon">04</span><h3>Sertifikat</h3><p>Bukti belajar sesuai ketentuan dan kelulusan kelas.</p></article>
            </div>
        </section>

        <section class="section" style="padding-top: 0">
            <span class="section-kicker">Siapkan kalender</span>
            <h2>Detail yang perlu Anda tahu.</h2>
            <div class="schedule-card">
                <div class="schedule-head"><strong>Class snapshot</strong><span class="schedule-tag">{{ $isIht ? 'IHT' : $mode }}</span></div>
                <div class="schedule-row"><span class="schedule-number">01</span><div><strong>Pelaksanaan</strong><span>{{ $shortDate }} · {{ data_get($class, 'jam_acara') ? \Carbon\Carbon::parse(data_get($class, 'jam_acara'))->format('H:i') . ' WIB' : 'Waktu diumumkan segera' }}</span></div></div>
                <div class="schedule-row"><span class="schedule-number">02</span><div><strong>Lokasi / media</strong><span>{{ $location }}</span></div></div>
                <div class="schedule-row"><span class="schedule-number">03</span><div><strong>Pendaftaran</strong><span>{{ $isIht ? 'Hubungi tim Bankir Academy' : ($isClosed ? 'Pendaftaran telah ditutup' : 'Mulai ' . $registrationDate) }}</span></div></div>
            </div>
        </section>

        <section class="story-card">
            <span class="section-kicker" style="color: var(--yellow)">Tentang program</span>
            <h2>Belajar dengan konteks, bukan hafalan.</h2>
            <p>{{ \Illuminate\Support\Str::limit($description, 280) }}</p>
            @if($tags->isNotEmpty())
                <div class="tag-row">@foreach($tags as $tag)<span class="tag">{{ $tag }}</span>@endforeach</div>
            @endif
        </section>

        <section class="section">
            <span class="section-kicker">Suasana belajar</span>
            <h2>Rasanya seperti campaign yang ingin Anda ikuti.</h2>
            <div class="gallery">
                @foreach($gallery->take(4) as $image)
                    <div class="gallery-item"><img src="{{ $image }}" alt="Materi visual {{ $title }}" loading="lazy" onerror="this.src='{{ asset('bankir-academy-icon.png') }}'"></div>
                @endforeach
            </div>
        </section>

        <section class="checkout-section" id="daftar">
            <span class="section-kicker">Amankan akses</span>
            <h2>Siap naik level?</h2>
            <p class="form-note">Isi data Anda. Setelah dikirim, Anda akan diarahkan ke halaman payment gateway untuk memilih metode pembayaran.</p>

            @if(session('error')) <div class="alert">{{ session('error') }} @if(str_contains(session('error'), 'terdaftar')) <a href="{{ route('login.new', ['redirect' => url()->current() . '#daftar']) }}" style="font-weight: 800; text-decoration: underline">Masuk di sini</a>@endif</div> @endif
            @if($errors->any()) <div class="alert">{{ $errors->first() }}</div> @endif

            @if($isIht)
                <div class="alert">Kelas IHT diproses melalui konsultasi khusus. Silakan hubungi tim Bankir Academy untuk mendapatkan penawaran.</div>
                <a class="submit-button" style="display:flex;align-items:center;justify-content:center" href="https://wa.me/6289682019523?text={{ rawurlencode('Halo Tim Bankir Academy, saya ingin mendaftar kelas ' . $title) }}">Chat Tim Bankir Academy</a>
            @else
                <form action="{{ route('frontend.class.checkout', $class->slug) }}" method="POST" id="landingCheckoutForm">
                    @csrf
                    <div class="field"><label for="landingName">Nama lengkap</label><input id="landingName" name="nama_pendaftar" type="text" value="{{ old('nama_pendaftar', auth()->check() ? auth()->user()->name : '') }}" placeholder="Contoh: Budi Santoso" required {{ auth()->check() ? 'readonly' : '' }}></div>
                    <div class="field"><label for="landingEmail">Email aktif</label><input id="landingEmail" name="email_pendaftar" type="email" value="{{ old('email_pendaftar', auth()->check() ? auth()->user()->email : '') }}" placeholder="nama@email.com" required {{ auth()->check() ? 'readonly' : '' }}><small>Invoice dan link pembayaran dikirim ke email ini.</small></div>
                    <div class="field"><label for="landingPhone">Nomor WhatsApp</label><input id="landingPhone" name="nomor_handphone" type="tel" value="{{ old('nomor_handphone', data_get($profile, 'phone')) }}" placeholder="08xxxxxxxxxx" required></div>

                    @guest
                        <div class="account-box"><strong>Buat akun belajar</strong><p>Akun ini dipakai untuk mengakses kelas setelah pembayaran berhasil.</p><div class="field"><label for="landingPassword">Password akun</label><input id="landingPassword" name="password" type="password" minlength="8" placeholder="Minimal 8 karakter" required></div></div>
                    @endguest

                    <label class="gateway-card"><input type="radio" name="payment_gateway" value="doku" checked><span><strong>Payment gateway · DOKU</strong><span>Bayar aman melalui VA bank, QRIS, dan pilihan channel yang tersedia.</span><span class="gateway-logos"><img src="{{ asset('frontend/demo/gateway/bri.png') }}" alt="BRI"><img src="{{ asset('frontend/demo/gateway/bni.png') }}" alt="BNI"><img src="{{ asset('frontend/demo/gateway/mandiri.png') }}" alt="Mandiri"><img src="{{ asset('frontend/demo/gateway/permata.png') }}" alt="Permata"><img src="{{ asset('frontend/demo/gateway/indomaret.png') }}" alt="Indomaret"></span></span></label>
                    <input type="hidden" name="sertifikat_invoice" value="1">
                    <label class="terms"><input type="checkbox" required><span>Saya memastikan data sudah benar dan menyetujui syarat pendaftaran kelas.</span></label>
                    <button class="submit-button" type="submit" {{ $canCheckout ? '' : 'disabled' }}>{{ $canCheckout ? 'Lanjut ke Pembayaran · ' . $priceLabel : ($isUpcoming ? 'Pendaftaran segera dibuka' : ($isClosed ? 'Pendaftaran ditutup' : 'Belum tersedia')) }}</button>
                    <p class="security-note">▣ Data terlindungi · Proses pembayaran terenkripsi</p>
                </form>
            @endif
        </section>

        <section class="section" id="faq">
            <span class="section-kicker">Pertanyaan umum</span>
            <h2>Sebelum Anda mulai.</h2>
            <div class="faq-list">
                <div class="faq-item"><button class="faq-question" type="button">Bagaimana cara bayarnya?<span>+</span></button><div class="faq-answer">Isi data, klik lanjut ke pembayaran, lalu ikuti instruksi DOKU. Status pembayaran akan diproses otomatis.</div></div>
                <div class="faq-item"><button class="faq-question" type="button">Apakah saya mendapat sertifikat?<span>+</span></button><div class="faq-answer">Sertifikat mengikuti ketentuan program, kehadiran, penyelesaian materi, dan persyaratan kelas.</div></div>
                <div class="faq-item"><button class="faq-question" type="button">Bagaimana jika sudah punya akun?<span>+</span></button><div class="faq-answer">Masuk terlebih dahulu menggunakan akun Bankir Academy, lalu kembali ke halaman ini untuk melanjutkan pendaftaran.</div></div>
            </div>
        </section>

        @if($relatedClasses->isNotEmpty())
            <section class="section" style="padding-top: 0">
                <span class="section-kicker">Pilihan lain</span><h2>Mungkin Anda juga suka.</h2>
                <div class="related-list">
                    @foreach($relatedClasses as $related)
                        <a class="related-card" href="{{ route('frontend.class.detail', $related->slug) }}"><img src="{{ $assetUrl(data_get($related, 'image_mobile') ?: data_get($related, 'image')) }}" alt="{{ $related->title }}" loading="lazy"><span>{{ $related->title }}</span></a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    <footer class="footer"><strong>Bankir Academy</strong><br>Belajar hari ini, lebih siap menghadapi dunia perbankan.</footer>
    @if(!$isIht)<div class="sticky-cta"><div><small>Investasi kelas</small><strong>{{ $priceLabel }}</strong></div><a href="#daftar">Daftar sekarang</a></div>@endif
</div>
<script>
    document.querySelectorAll('.faq-question').forEach(function (button) {
        button.addEventListener('click', function () { button.closest('.faq-item').classList.toggle('is-open'); });
    });
    var checkoutForm = document.getElementById('landingCheckoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function () {
            var submit = checkoutForm.querySelector('.submit-button');
            if (submit && !submit.disabled) { submit.disabled = true; submit.textContent = 'Menyiapkan pembayaran...'; }
        });
    }
</script>
</body>
</html>
