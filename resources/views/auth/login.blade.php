@extends('layouts.applogin')

@section('content')
    <main class="login-page">
        <section class="login-card" aria-labelledby="login-title">
            <a class="brand" href="{{ route('frontend.home') }}" aria-label="Bankir Academy">
                <svg aria-hidden="true" class="brand-logo">
                    <use href="#logo-ba"></use>
                </svg>
                <span class="brand-copy">
                    <strong>Bankir Academy</strong>
                    <small>Learning · Talent · Banking Solutions</small>
                </span>
            </a>

            <div class="login-heading">
                <span class="eyebrow">Member Area</span>
                <h1 id="login-title">Selamat datang kembali</h1>
                <p>Masuk untuk melanjutkan pembelajaran dan mengakses layanan Bankir Academy.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger login-alert" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger login-alert" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="email">
                </div>
                <div class="form-field password-field">
                    <label for="password">Kata sandi</label>
                    <div class="password-input-wrap">
                        <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                        <button class="password-toggle" type="button" aria-label="Tampilkan kata sandi" aria-controls="password" aria-pressed="false">Lihat</button>
                    </div>
                </div>
                <div class="login-actions">
                    <button class="btn btn-primary" type="submit">Masuk</button>
                    <a class="btn btn-outline" href="{{ url('/auth/google') }}">Login dengan Google</a>
                </div>
            </form>

            <a class="back-link" href="{{ route('frontend.home') }}">← Kembali ke beranda</a>
        </section>
    </main>
@endsection

@push('frontend-scripts')
<style>
    .auth-login-body {
        min-height: 100vh;
    }

    .login-page {
        min-height: 100vh;
        padding: 40px 20px;
    }

    .login-card {
        width: min(480px, 100%);
        padding: clamp(26px, 5vw, 42px);
    }

    .login-card .brand {
        gap: 12px;
    }

    .login-card .brand-logo {
        flex: 0 0 auto;
    }

    .login-heading {
        margin-top: 30px;
    }

    .login-heading .eyebrow {
        font-size: 10px;
    }

    .login-heading h1 {
        margin: 16px 0 10px;
        font-size: clamp(28px, 6vw, 38px);
        line-height: 1.12;
    }

    .login-heading p {
        margin-bottom: 0;
        font-size: 14px;
    }

    .login-alert {
        margin: 22px 0 0;
        padding: 11px 13px;
        border-radius: 12px;
        font-size: 13px;
    }

    .password-input-wrap {
        position: relative;
    }

    .password-input-wrap input {
        width: 100%;
        padding-right: 62px;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        padding: 4px;
        border: 0;
        color: var(--primary);
        background: transparent;
        font-size: 11px;
        font-weight: 800;
    }

    .password-toggle:hover {
        color: var(--secondary-dark);
    }

    .login-actions .btn {
        width: 100%;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const password = document.getElementById('password');
        const toggle = document.querySelector('.password-toggle');

        if (!password || !toggle) return;

        toggle.addEventListener('click', function () {
            const visible = password.type === 'password';
            password.type = visible ? 'text' : 'password';
            toggle.textContent = visible ? 'Sembunyikan' : 'Lihat';
            toggle.setAttribute('aria-pressed', String(visible));
            toggle.setAttribute('aria-label', visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    });
</script>
@endpush
