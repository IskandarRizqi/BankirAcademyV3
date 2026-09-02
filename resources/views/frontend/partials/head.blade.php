<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="#6757D9" name="theme-color" />
    <meta content="@yield('page-description', 'Bankir Academy menyediakan solusi pembelajaran, pengembangan talenta, riset, inovasi, dan program pemberdayaan untuk ekosistem perbankan Indonesia.')" name="description" />
    <meta
        content="Bankir Academy, pelatihan perbankan, LMS perbankan, talent solution, headhunting perbankan, capacity building, bakti pendidikan, bakti UMKM"
        name="keywords" />
    <meta content="Bankir Academy" name="author" />
    <meta content="@yield('page-title', 'Bankir Academy — Learning, Talent &amp; Banking Solutions')" property="og:title" />
    <meta content="@yield('page-description', 'Membangun kompetensi, menghubungkan talenta, dan menghadirkan solusi terapan bagi ekosistem perbankan.')" property="og:description" />
    <meta content="website" property="og:type" />
    <meta content="https://www.bankiracademy.co.id/" property="og:url" />
    <title>@yield('page-title', 'Bankir Academy — Learning, Talent &amp; Banking Solutions')</title>
    <!-- Favicon SVG: logo B Bankir Academy, tetap tajam di semua resolusi -->
    <link href='{{ asset('bankir-academy-icon.png') }}' rel="icon" type="image/svg+xml" />

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;family=Manrope:wght@600;700;800&amp;display=swap"
        rel="stylesheet" />
    @if ($includeMarketingStyles ?? false)
        <link rel="stylesheet" href="{{ asset('frontend/css/bankir-academy.css') }}">
    @endif

    @if ($includeAuthStyles ?? false)
        <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}">
    @endif
    <meta content="index.html" name="bankir-page" />
</head>
