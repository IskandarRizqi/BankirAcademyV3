<!-- Header
  ============================================= -->
{{-- <div class="container">
</div> --}}
<div class="alert alert-info alert-dismissible fade show text-center" role="alert">
    Upgrade Skill Tanpa Batas, Lampaui Batas <strong>#bankirhebat</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<header id="header">
    <div id="header-wrap">
        <div class="container">
            <div class="header-row">
                <!-- Logo
      ============================================= -->
                <div id="logo">
                    <a href="{{ url('/') }}" class="standard-logo" style="height:40px !important;"
                        data-dark-logo="{{ asset('Backend/logo_12.png') }}">
                        <img src="{{ env('CUSTOM_LOGO', '/Bank-academy-logo-03.png') }}" alt="E-class"
                            style="max-width: 340px; "></a>
                    <a href="{{ url('/') }}" class="retina-logo" style="height: 35px !important"
                        data-dark-logo="{{ asset('/Bank-academy-logo-04.png') }}"><img
                            src="{{ asset('/Bank-academy-logo-04.png') }}" alt="Canvas Logo"></a>
                </div><!-- #logo end -->
                {{-- @if (Auth::check() && Auth::user()->role == 2)
                <div class="header-misc">
                    <a href="{{ url('/profile') }}">
                        <button class="btn btn-info btn-sm" title="Profile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                <path
                                    d="M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1h2zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5 4.5 6.505 4.5 8.5 6.005 12 8 12z">
                                </path>
                            </svg>
                            Profile</button>
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <button class="btn btn-warning text-white btn-sm" title="Logout">
                            <svg xmlns=" http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                                <path
                                    d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                                </path>
                            </svg>
                            Logout</button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                    <div class="dropdown mx-3 mr-lg-0">
                        <a href="#" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true"><i class="icon-user"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                            <a class="dropdown-item text-left" href="{{url('/profile')}}">Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-left" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout <i
                                    class="icon-signout"></i>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </ul>
                    </div>
                </div>
                @endif --}}
                <div id="primary-menu-trigger">
                    <svg class="svg-trigger" viewBox="0 0 100 100">
                        <path
                            d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20">
                        </path>
                        <path d="m 30,50 h 40"></path>
                        <path
                            d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20">
                        </path>
                    </svg>
                </div>
                <!-- Primary Navigation
      ============================================= -->
                <nav class="primary-menu">
                    <ul class="menu-container">
                        <!-- <li class="menu-item current"><a class="menu-link" href="#">
                                <div>Home</div>
                            </a>
                        </li> -->
                        <li class="menu-item"><a class="menu-link" href="{{ url('/') }}">
                                <div>Beranda</div>
                            </a>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="/list-class">
                                <div>Kelas</div>
                            </a>
                            <ul class="sub-menu-container">
                                <li class="menu-item">
                                    <a class="menu-link" href="/list-class?jenis=calon_bankir">
                                        <div>Calon Bankir</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="/list-class?jenis=bankir">
                                        <div>Bankir</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="/list-class?jenis=bootcamp_bankir">
                                        <div>Bootcamp Bankir</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="/list-class?jenis=management_trainer">
                                        <div>Management Trainee</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="/promo">
                                <div>Promo</div>
                            </a>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="/pages/blog">
                                <div>Literasi</div>
                            </a>
                        </li>
                        <!-- <li class="menu-item">
                            <a class="menu-link" href="#">
                                <div>Layanan</div>
                            </a>
                            <ul class="sub-menu-container">
                                <li class="menu-item">
                                    <a class="menu-link" href="#">
                                        <div>FAQ</div>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="menu-item"><a class="menu-link" href="https://bankiracademy.com/u-laman/kurikulum">
                                <div>Kurikulum</div>
                            </a>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="/loker">
                                <div>Loker Bankir</div>
                            </a>
                        </li>
                        <!-- <li class="menu-item"><a class="menu-link" href="#">
                                <div>Contact</div><span>Get In Touch</span>
                            </a>
                        </li> -->
                        @if (!Auth::check())
                        <li class="menu-item d-flex ml-0">
                            <a class="menu-link" data-toggle="modal" data-target="#modelId" data-backdrop="static"
                                data-keyboard="false" style="padding-right: 0px">
                                <button class="btn btn-sm" style="background-color: #FFA600; border-radius: 9px"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                        <path
                                            d="M10.385 21.788a.997.997 0 0 0 .857.182l8-2A.999.999 0 0 0 20 19V5a1 1 0 0 0-.758-.97l-8-2A1.003 1.003 0 0 0 10 3v1H6a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h4v1c0 .308.142.599.385.788zM12 4.281l6 1.5v12.438l-6 1.5V4.281zM7 18V6h3v12H7z">
                                        </path>
                                        <path
                                            d="M14.242 13.159c.446-.112.758-.512.758-.971v-.377a1 1 0 1 0-2 .001v.377a1 1 0 0 0 1.242.97z">
                                        </path>
                                    </svg>Masuk</button>
                            </a>
                            <a class="menu-link" style="padding-left: 5px"
                                href="https://api.whatsapp.com/send/?phone=62895333017060&text&type=phone_number&app_absent=0">
                                <button class="btn btn-primary btn-sm" style="border-radius: 9px"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                        <path
                                            d="M16.57 22a2 2 0 0 0 1.43-.59l2.71-2.71a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0l-1.6 1.59a7.55 7.55 0 0 1-3-1.59 7.62 7.62 0 0 1-1.59-3l1.59-1.6a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0L2.59 6A2 2 0 0 0 2 7.43 15.28 15.28 0 0 0 6.3 17.7 15.28 15.28 0 0 0 16.57 22zM6 5.41 8.59 8 7.3 9.29a1 1 0 0 0-.3.91 10.12 10.12 0 0 0 2.3 4.5 10.08 10.08 0 0 0 4.5 2.3 1 1 0 0 0 .91-.27L16 15.41 18.59 18l-2 2a13.28 13.28 0 0 1-8.87-3.71A13.28 13.28 0 0 1 4 7.41zM20 11h2a8.81 8.81 0 0 0-9-9v2a6.77 6.77 0 0 1 7 7z">
                                        </path>
                                        <path d="M13 8c2.1 0 3 .9 3 3h2c0-3.22-1.78-5-5-5z"></path>
                                    </svg>Kontak Kami</button>
                            </a>
                        </li>
                        @endif
                        @if (Auth::check() && Auth::user()->role == 2)
                        <li class="menu-item d-flex">
                            <a class="menu-link" href="{{ url('/profile') }}"
                                style="padding-left: 5px; padding-right: 5px">
                                <button class="btn btn-info btn-sm" title="Profile">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                        <path
                                            d="M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1h2zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5 4.5 6.505 4.5 8.5 6.005 12 8 12z">
                                        </path>
                                    </svg>
                                    Profile</button>
                            </a>
                            <a class="menu-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                                style="padding-left: 5px; padding-right: 5px">
                                <button class="btn btn-warning text-white btn-sm" title="Logout">
                                    <svg xmlns=" http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                        <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                                        <path
                                            d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                                        </path>
                                    </svg>
                                    Logout</button>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>
                        @endif
                        @if (Auth::check() && Auth::user()->role !== 2)
                        <li class="menu-item"><a class="menu-link" href="{{ url('/home') }}">
                                <button class="btn btn-primary">Admin Area</button>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav><!-- #primary-menu end -->
            </div>
        </div>
    </div>
    <div class="header-wrap-clone"></div>
</header>
<!-- #header end -->

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closemodallogin()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="padding: 10px;">
                    <h3 class="font-body">Login to your Account</h3>
                    <div class="col-12 form-group">
                        <label class="font-body text-capitalize" for="login-form-modal-username">Email:</label>
                        <input type="email" id="emaillogin" name="email" value="" class="form-control" />
                    </div>
                    <div class="col-12 form-group">
                        <label class="font-body text-capitalize" for="login-form-modal-password">Password:</label>
                        <input type="password" id="passwordlogin" name="password" value="" class="form-control" />
                    </div>
                    <div class="col-12 form-group">
                        <button class="button button-rounded m-0" id="login" type="submit"
                            onclick="funclogin()">Login</button>
                        <a href="#" class="float-right">Forgot Password?</a>
                    </div>
                    <div class="line line-sm"></div>
                    <a href="{{ url('/auth/google') }}"
                        class="button button-rounded btn-block font-weight-normal center text-capitalize si-gplus si-colored m-0">Login/Register
                        with Google</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end modal login -->