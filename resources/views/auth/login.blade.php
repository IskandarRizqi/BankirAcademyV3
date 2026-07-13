@extends('layouts.app')

@section('content')
<style>
    #loginForm .custom_group_field {
        position: relative;
        align-items: center;
    }

    #loginForm .custom_group_field .input-group-prepend {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        z-index: 5;
        display: flex;
        align-items: center;
        pointer-events: none;
    }

    #loginForm .custom_group_field .input-group-text {
        width: 24px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0;
    }

    #loginForm .custom_group_field .input-group-text svg {
        display: block;
        flex-shrink: 0;
    }

    #loginForm .custom_group_field .form-control {
        position: relative;
        z-index: 1;
        background: transparent;
        height: 44px;
        padding: 0 0 0 34px;
        line-height: 44px;
    }

    #loginForm .custom_group_field .form-control:focus {
        background: transparent;
    }

    #loginForm .password-field .form-control {
        padding-right: 44px;
    }

    #loginForm .password-toggle {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 4;
        width: 44px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        border: 0;
        background: transparent;
        color: #687083;
        padding: 0;
        cursor: pointer;
    }

    #loginForm .password-toggle svg {
        display: block;
    }

    #loginForm .password-toggle .icon-eye-off {
        display: none;
    }

    #loginForm .password-toggle.is-visible .icon-eye {
        display: none;
    }

    #loginForm .password-toggle.is-visible .icon-eye-off {
        display: block;
    }

    #loginForm .login-error-summary {
        border-radius: 8px;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 20px;
        padding: 12px 14px;
    }

    #loginForm .field-error {
        color: #dc3545;
        display: block;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.4;
        margin-top: 8px;
    }
</style>
<div class="login_wrapper">
    <div class="login_wrapper_left">
        <div class="logo">
            <a href="index.html">
                <img style="width: 190px" src="{{ asset('Bank-academy-logo-03.png')}}" alt="">
            </a>
        </div>
        <div class="login_wrapper_content">
            <h4>Welcome back. Please login <br>to your account </h4>

            <div class="socail_links">



            </div>

            <form action="{{route('login')}}" method="POST" id="loginForm">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger login-error-summary" role="alert">
                    {{ $errors->first() }}
                </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="input-group custom_group_field">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13.328" height="10.662"
                                        viewBox="0 0 13.328 10.662">
                                        <path id="Path_44" data-name="Path 44"
                                            d="M13.995,4H3.333A1.331,1.331,0,0,0,2.007,5.333l-.007,8a1.337,1.337,0,0,0,1.333,1.333H13.995a1.337,1.337,0,0,0,1.333-1.333v-8A1.337,1.337,0,0,0,13.995,4Zm0,9.329H3.333V6.666L8.664,10l5.331-3.332ZM8.664,8.665,3.333,5.333H13.995Z"
                                            transform="translate(-2 -4)" fill="#687083" />
                                    </svg>
                                </span>
                            </div>
                            <input type="email" value="{{ old('email') }}" class="form-control  @error('email') is-invalid @enderror" placeholder="Enter Email"
                                name="email" aria-label="Username" aria-describedby="basic-addon3" required autocomplete="email" autofocus>

                        </div>
                    </div>

                    <div class="col-12 mt_20">
                        <div class="input-group custom_group_field password-field">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10.697" height="14.039"
                                        viewBox="0 0 10.697 14.039">
                                        <path id="Path_46" data-name="Path 46"
                                            d="M9.348,11.7A1.337,1.337,0,1,0,8.011,10.36,1.341,1.341,0,0,0,9.348,11.7ZM13.36,5.68h-.669V4.343a3.343,3.343,0,0,0-6.685,0h1.27a2.072,2.072,0,0,1,4.145,0V5.68H5.337A1.341,1.341,0,0,0,4,7.017V13.7a1.341,1.341,0,0,0,1.337,1.337H13.36A1.341,1.341,0,0,0,14.7,13.7V7.017A1.341,1.341,0,0,0,13.36,5.68Zm0,8.022H5.337V7.017H13.36Z"
                                            transform="translate(-4 -1)" fill="#687083" />
                                    </svg>
                                </span>
                            </div>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" placeholder="Enter Password" aria-label="password" aria-describedby="basic-addon4" required autocomplete="current-password">
                            <button type="button" class="password-toggle" aria-label="Tampilkan password" aria-controls="password" aria-pressed="false">
                                <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m3 3 18 18" />
                                    <path d="M10.6 10.6A2 2 0 0 0 13.4 13.4" />
                                    <path d="M9.9 4.2A10.4 10.4 0 0 1 12 4c6.5 0 10 8 10 8a17.8 17.8 0 0 1-3.1 4.3" />
                                    <path d="M6.6 6.6C3.6 8.6 2 12 2 12s3.5 8 10 8a10.7 10.7 0 0 0 4.1-.8" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 mt_20">
                    </div>
                    <!-- <div class="col-12 mt_20">
                            <div class="remember_forgot_pass d-flex justify-content-between flex-wrap row-gap-4">
                                <label class="primary_checkbox d-flex mb-0">
                                    <input type="checkbox" name="remember" value="1">
                                    <span class="checkmark me-2"></span>
                                    <span class="label_name">Remember Me</span>
                                </label>
                                <a href="send-password-reset-link.html" class="forgot_pass">Forgot Password ?</a>
                            </div>
                        </div> -->
                    <div class="col-12">

                        <button type="submit" class="theme_btn text-center w-100"> Login</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row g-2 mt-1">
            <div class="col-sm-12 mb_10">
                <a class="theme_btn small_btn2 text-center w-100" href="{{ url('/auth/google') }}">Login/Register with Google</a>
            </div>

        </div>
    </div>
    <div class="login_wrapper_right">
        <div class="login_main_info">
            <h4>

                Selamat Datang Di BankirAcademy
            </h4>
            <div class="thumb">
                <img src="" alt="">
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var passwordInput = document.getElementById('password');
        var toggleButton = document.querySelector('#loginForm .password-toggle');

        if (!passwordInput || !toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function() {
            var shouldShowPassword = passwordInput.type === 'password';

            passwordInput.type = shouldShowPassword ? 'text' : 'password';
            toggleButton.classList.toggle('is-visible', shouldShowPassword);
            toggleButton.setAttribute('aria-pressed', shouldShowPassword ? 'true' : 'false');
            toggleButton.setAttribute('aria-label', shouldShowPassword ? 'Sembunyikan password' : 'Tampilkan password');
        });
    });
</script>
@endsection