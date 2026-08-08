@php
    $loginUrl = Auth::check() ? \App\Support\AuthRedirector::pathFor(Auth::user()) : url('/authentikasi/login');
@endphp
<!-- Logo SVG reusable -->
<svg class="logo-symbol" height="0" width="0">
    <symbol id="logo-ba" viewbox="0 0 64 64">
        <defs>
            <lineargradient id="logoGradient" x1="0" x2="1" y1="0" y2="1">
                <stop offset="0%" stop-color="#7668E5"></stop>
                <stop offset="100%" stop-color="#5142C1"></stop>
            </lineargradient>
        </defs>
        <rect fill="url(#logoGradient)" height="64" rx="17" width="64"></rect>
        <path
            d="M19 13h19c8 0 13 4 13 10 0 4-2 7-6 9 5 2 8 5 8 10 0 8-6 12-15 12H19V13zm10 8v8h8c3 0 5-1 5-4s-2-4-5-4h-8zm0 16v9h9c4 0 6-2 6-5s-2-4-6-4h-9z"
            fill="#fff"></path>
        <path d="M14 18h5v31h-5z" fill="#00B7A8"></path>
    </symbol>
</svg>

<header class="site-header" id="siteHeader">
    <div class="container header-inner">
        <a aria-label="Bankir Academy" class="brand" href="{{ route('frontend.home') }}">
            <img src="{{ asset('bankir-academy-icon.png') }}" alt="logo">
            <span class="brand-copy">
                <strong>Bankir Academy</strong>
                <small>Learning · Talent · Banking Solutions</small>
            </span>
        </a>
        <nav aria-label="Navigasi utama" class="desktop-nav">
            <a class="nav-link active" href="{{ route('frontend.home') }}">Beranda</a>
            <div class="nav-item">
                <a class="nav-link" href="{{ route('frontend.home') }}#layanan">Layanan <span
                        class="chevron">▼</span></a>
                <div class="dropdown wide">
                    <a class="drop-link" href="{{ route('frontend.service.banking-solution') }}">
                        <span class="drop-icon">▦</span>
                        <span><strong>Banking Solution</strong><span>Solusi terapan untuk kebutuhan operasional dan
                                pengembangan
                                bank.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.service.capacity-building') }}">
                        <span class="drop-icon">↗</span>
                        <span><strong>Capacity Building</strong><span>Program peningkatan kompetensi berbasis kebutuhan
                                organisasi.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.service.banking-talent') }}">
                        <span class="drop-icon">◇</span>
                        <span><strong>Banking Talent Solution</strong><span>Pengembangan dan pemetaan talenta sektor
                                perbankan.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.service.lms') }}">
                        <span class="drop-icon">▶</span>
                        <span><strong>Learning Management System</strong><span>Pembelajaran digital, asesmen, dan
                                pelaporan
                                terintegrasi.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.service.innovation') }}">
                        <span class="drop-icon">✦</span>
                        <span><strong>Inovasi Program</strong><span>Riset, analisis produk, automasi, dan pengembangan
                                AI
                                terapan.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.service.csr') }}">
                        <span class="drop-icon">♡</span>
                        <span><strong>Program CSR</strong><span>Edukasi industri perbankan bagi pelajar dan calon
                                bankir.</span></span>
                    </a>
                </div>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="{{ route('frontend.home') }}#talent-solutions">Talent Solutions <span
                        class="chevron">▼</span></a>
                <div class="dropdown">
                    <a class="drop-link" href="{{ route('frontend.talent.headhunting') }}">
                        <span class="drop-icon">⌕</span>
                        <span><strong>Headhunting</strong><span>Pencarian kandidat sesuai kriteria dan kebutuhan
                                organisasi.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.talent.outsourcing') }}">
                        <span class="drop-icon">◎</span>
                        <span><strong>Outsourcing</strong><span>Dukungan tenaga kerja berbasis ruang lingkup yang
                                disepakati.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.talent.job-connect') }}">
                        <span class="drop-icon">⇄</span>
                        <span><strong>Job Connect</strong><span>Menghubungkan kandidat dan peluang kerja yang
                                relevan.</span></span>
                    </a>
                </div>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="{{ route('frontend.home') }}#foundations">Foundations <span
                        class="chevron">▼</span></a>
                <div class="dropdown">
                    <a class="drop-link" href="{{ route('frontend.foundation.education') }}">
                        <span class="drop-icon">🎓</span>
                        <span><strong>Bakti Pendidikan</strong><span>Literasi, pengenalan karier, dan pembelajaran
                                industri.</span></span>
                    </a>
                    <a class="drop-link" href="{{ route('frontend.foundation.umkm') }}">
                        <span class="drop-icon">⌂</span>
                        <span><strong>Bakti UMKM</strong><span>Penguatan kapasitas usaha dan literasi pengelolaan
                                bisnis.</span></span>
                    </a>
                </div>
            </div>
        </nav>
        <div class="header-action">
            <a class="btn btn-outline btn-sm" href="{{ route('frontend.support.contact') }}">Konsultasi</a>
            <a href="{{ $loginUrl }}" class="btn btn-primary btn-sm">
                <span>Login</span>
            </a>

            <button aria-expanded="false" aria-label="Buka menu" class="menu-toggle" id="menuToggle" type="button">
                ☰
            </button>
        </div>
    </div>
</header>

<div class="mobile-panel" id="mobilePanel">
    <div class="mobile-group">
        <a class="mobile-main" href="{{ route('frontend.home') }}"><span>Beranda</span></a>
    </div>
    <div class="mobile-group">
        <button class="mobile-main" type="button">
            <span>Layanan</span><span>＋</span>
        </button>
        <div class="mobile-sub">
            <a href="{{ route('frontend.service.banking-solution') }}">Banking Solution</a>
            <a href="{{ route('frontend.service.capacity-building') }}">Capacity Building</a>
            <a href="{{ route('frontend.service.banking-talent') }}">Banking Talent Solution</a>
            <a href="{{ route('frontend.service.lms') }}">LMS</a>
            <a href="{{ route('frontend.service.innovation') }}">Inovasi Program</a>
            <a href="{{ route('frontend.service.csr') }}">Program CSR</a>
        </div>
    </div>
    <div class="mobile-group">
        <button class="mobile-main" type="button">
            <span>Talent Solutions</span><span>＋</span>
        </button>
        <div class="mobile-sub">
            <a href="{{ route('frontend.talent.headhunting') }}">Headhunting</a>
            <a href="{{ route('frontend.talent.outsourcing') }}">Outsourcing</a>
            <a href="{{ route('frontend.talent.job-connect') }}">Job Connect</a>
        </div>
    </div>
    <div class="mobile-group">
        <button class="mobile-main" type="button">
            <span>Foundations</span><span>＋</span>
        </button>
        <div class="mobile-sub">
            <a href="{{ route('frontend.foundation.education') }}">Bakti Pendidikan</a>
            <a href="{{ route('frontend.foundation.umkm') }}">Bakti UMKM</a>
        </div>
    </div>

    {{-- @auth
        <!-- Tampil di menu mobile jika pengguna SUDAH login -->
        <a class="btn btn-primary mobile-login" href="{{ url('/home') }}">Login</a>
    @endauth

    @guest
        <!-- Tampil di menu mobile jika pengguna BELUM login -->
        <a class="btn btn-primary mobile-login" href="{{ route('login.new') }}">Login</a>
    @endguest --}}
    <a href="{{ $loginUrl }}" class="btn btn-primary mobile-login">
        <span>Login</span>
    </a>
</div>
