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
    <meta content="@yield('page-url', url()->current())" property="og:url" />
    <meta content="@yield('page-image', asset('bankir-academy-icon.png'))" property="og:image" />
    <meta content="@yield('page-image-alt', 'Bankir Academy')" property="og:image:alt" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="@yield('page-title', 'Bankir Academy — Learning, Talent &amp; Banking Solutions')" name="twitter:title" />
    <meta content="@yield('page-description', 'Membangun kompetensi, menghubungkan talenta, dan menghadirkan solusi terapan bagi ekosistem perbankan.')" name="twitter:description" />
    <meta content="@yield('page-image', asset('bankir-academy-icon.png'))" name="twitter:image" />
    <link rel="canonical" href="@yield('page-url', url()->current())" />
    <title>@yield('page-title', 'Bankir Academy — Learning, Talent &amp; Banking Solutions')</title>
    <!-- Favicon SVG: logo B Bankir Academy, tetap tajam di semua resolusi -->
    <link href='{{ asset('bankir-academy-icon.png') }}' rel="icon" type="image/svg+xml" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J98K6NX0S7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-J98K6NX0S7');
    </script>
    @yield('head')

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;family=Manrope:wght@600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @if ($includeMarketingStyles ?? false)
        <link rel="stylesheet" href="{{ asset('frontend/css/bankir-academy.css') }}">
    @endif

    @if ($includeAuthStyles ?? false)
        <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}">
    @endif
    <meta content="index.html" name="bankir-page" />
</head>
