<!-- Header
		============================================= -->
<header id="header">
    <div id="header-wrap">
        <div class="container">
            <div class="header-row">
                <!-- Logo
						============================================= -->
                <div id="logo">
                    <a href="{{url('/')}}" class="standard-logo" data-dark-logo="{{asset('Backend/logo_12.png')}}"><img src="{{asset('Backend/logo_12.png')}}" alt="E-class"></a>
                </div><!-- #logo end -->
                @if(Auth::check() && Auth::user()->role == 2)
                <div class="header-misc">
                    <div class="dropdown mx-3 mr-lg-0">
                        <a href="#" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-user"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                            <a class="dropdown-item text-left" href="{{url('/profile')}}">Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-left" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout <i class="icon-signout"></i>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </ul>
                    </div>
                </div>
                @endif
                <div id="primary-menu-trigger">
                    <svg class="svg-trigger" viewBox="0 0 100 100">
                        <path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20">
                        </path>
                        <path d="m 30,50 h 40"></path>
                        <path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20">
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
                        <li class="menu-item"><a class="menu-link" href="{{url('/')}}">
                                <div>Beranda</div>
                            </a>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="#">
                                <div>Program</div>
                            </a>
                            <ul class="sub-menu-container">
                                <li class="menu-item">
                                    <a class="menu-link" href="#">
                                        <div>Kelas Bankir</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="#">
                                        <div>Kelas Nasabah</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="#" onclick="popc()">
                                        <div title="UP COMING">Kelas Umum</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="#hrefpromo" onclick="popc()">
                                <div>Promo</div>
                            </a>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="#">
                                <div>Event</div>
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
                        <li class="menu-item"><a class="menu-link" onclick="popc()" href="#">
                                <div>Loker Bankir</div>
                            </a>
                        </li>
                        <li class="menu-item"><a class="menu-link" href="#">
                                <div>Bantuan</div>
                            </a>
                        </li>
                        <!-- <li class="menu-item"><a class="menu-link" href="#">
                                <div>Contact</div><span>Get In Touch</span>
                            </a>
                        </li> -->
                        @if(!Auth::check())
                        <li class="menu-item"><a class="menu-link" data-toggle="modal" data-target="#modelId" data-backdrop="static" data-keyboard="false">
                                <div>Login</div>
                            </a>
                        </li>
                        <!-- <li class="menu-item"><a class="menu-link" href="{{url('/registerc')}}">
                                <div>Register</div>
                            </a>
                        </li> -->
                        @endif
                        @if(Auth::check() && (Auth::user()->role == 0 || Auth::user()->role == 1))
                        <li class="menu-item"><a class="menu-link" href="{{url('/home')}}">
                                <div>Go to admin</div>
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
                        <button class="button button-rounded m-0" id="login" type="submit" onclick="funclogin()">Login</button>
                        <a href="#" class="float-right">Forgot Password?</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        Don't have an account? &nbsp;
                        <a href="{{url('/registerc')}}"> Register Now</a>
                    </div>
                    <div class="line line-sm"></div>
                    <a href="{{url('/auth/google')}}" class="button button-rounded btn-block font-weight-normal center text-capitalize si-gplus si-colored m-0">Login
                        with Google</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end modal login -->