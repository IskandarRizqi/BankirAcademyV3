@extends('layouts.applogin')

@section('page-title', 'Login — Bankir Academy')
@section('page-description', 'Masuk ke akun Bankir Academy untuk melanjutkan pembelajaran dan mengakses layanan.')

@section('content')
    <main class="auth-page">
        <div class="auth-orb auth-orb-primary" aria-hidden="true"></div>
        <div class="auth-orb auth-orb-secondary" aria-hidden="true"></div>

        <div class="auth-layout">
            <section class="auth-intro" aria-label="Tentang Bankir Academy">
                <a class="auth-brand" href="{{ route('frontend.home') }}" aria-label="Bankir Academy">
                    <img src="{{ asset('bankir-academy-icon.png') }}" alt="logo">
                    <span>
                        <strong>Bankir Academy</strong>
                        <small>Learning · Talent · Banking Solutions</small>
                    </span>
                </a>

                {{-- <span class="auth-eyebrow">Learning ecosystem</span> --}}
                <h2>Bangun kompetensi untuk langkah yang lebih berarti.</h1>
                    <p>
                        Akses pembelajaran, program pengembangan, dan layanan yang dirancang
                        untuk ekosistem perbankan yang terus bertumbuh.
                    </p>

                    <ul class="auth-benefits">
                        <li><span>✓</span> Materi dan program yang relevan</li>
                        <li><span>✓</span> Belajar secara mandiri atau terarah</li>
                        <li><span>✓</span> Terhubung dengan peluang pengembangan</li>
                    </ul>
            </section>

            <section class="login-card" aria-labelledby="login-title">
                <div class="login-heading">
                    <span class="auth-eyebrow">Member area</span>
                    <h2 id="login-title">Selamat datang kembali</h2>
                    <p>Masuk untuk melanjutkan perjalanan belajar Anda.</p>
                </div>

                @if (session('error'))
                    <div class="login-alert" role="alert">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="login-alert" role="alert">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                            placeholder="nama@email.com" required autofocus autocomplete="email">
                    </div>

                    <div class="form-field">
                        <label for="password">Kata sandi</label>
                        <div class="password-input-wrap">
                            <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" required
                                autocomplete="current-password">
                            <button class="password-toggle" type="button" aria-label="Tampilkan kata sandi"
                                aria-controls="password" aria-pressed="false">Lihat</button>
                        </div>
                    </div>

                    <div class="login-actions">
                        <button class="auth-button auth-button-primary" type="submit">Masuk</button>
                        <div class="auth-divider"><span>atau</span></div>
                        <a class="auth-button auth-button-google" href="{{ url('/auth/google') }}">
                            <span class="google-mark" aria-hidden="true">G</span>
                            Login dengan Google
                        </a>
                    </div>
                </form>

                <a class="back-link" href="{{ route('frontend.home') }}">← Kembali ke beranda</a>
            </section>
        </div>
    </main>
@endsection

@push('frontend-scripts')
    <script src="{{ asset('frontend/js/auth-login.js') }}" defer></script>
@endpush
