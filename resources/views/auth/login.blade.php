@extends('layouts.app')

@section('content')
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
                <div class="row">
                    <div class="col-12">
                        <div class="input-group custom_group_field">
                            <!-- <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13.328" height="10.662"
                                        viewBox="0 0 13.328 10.662">
                                        <path id="Path_44" data-name="Path 44"
                                            d="M13.995,4H3.333A1.331,1.331,0,0,0,2.007,5.333l-.007,8a1.337,1.337,0,0,0,1.333,1.333H13.995a1.337,1.337,0,0,0,1.333-1.333v-8A1.337,1.337,0,0,0,13.995,4Zm0,9.329H3.333V6.666L8.664,10l5.331-3.332ZM8.664,8.665,3.333,5.333H13.995Z"
                                            transform="translate(-2 -4)" fill="#687083" />
                                    </svg>
                                </span>
                            </div> -->
                            <input type="email" value="{{ old('email') }}" class="form-control  @error('email') is-invalid @enderror" placeholder="Enter Email"
                                name="email" aria-label="Username" aria-describedby="basic-addon3" required autocomplete="email" autofocus>

                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-12 mt_20">
                        <div class="input-group custom_group_field">
                            <div class="input-group-prepend">
                                <!-- <span class="input-group-text" id="basic-addon4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10.697" height="14.039"
                                        viewBox="0 0 10.697 14.039">
                                        <path id="Path_46" data-name="Path 46"
                                            d="M9.348,11.7A1.337,1.337,0,1,0,8.011,10.36,1.341,1.341,0,0,0,9.348,11.7ZM13.36,5.68h-.669V4.343a3.343,3.343,0,0,0-6.685,0h1.27a2.072,2.072,0,0,1,4.145,0V5.68H5.337A1.341,1.341,0,0,0,4,7.017V13.7a1.341,1.341,0,0,0,1.337,1.337H13.36A1.341,1.341,0,0,0,14.7,13.7V7.017A1.341,1.341,0,0,0,13.36,5.68Zm0,8.022H5.337V7.017H13.36Z"
                                            transform="translate(-4 -1)" fill="#687083" />
                                    </svg>
                                </span> -->
                            </div>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter Password" aria-label="password" aria-describedby="basic-addon4" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
@endsection