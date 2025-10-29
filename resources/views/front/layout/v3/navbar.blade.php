<style>
/* === HEADER UTAMA === */
header.header-with-topbar,
.header-with-topbar .navbar {
    background-color: #ffffff !important;  
    border-bottom: 1px solid #e0e0e0;      
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05); 
    height: 80px !important;              
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed !important;           
    z-index: 9999;
}

/* === LOGO SELALU TAMPIL === */
header.header-with-topbar .navbar-brand img {
    max-height: 70px !important;
    height: auto;
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
}
header .navbar-brand .default-logo {
    max-height: 35px !important;
    display: inline-block !important;
    opacity: 1 !important;
    visibility: visible !important;
}




/* === WARNA ICON DAN TEKS === */
.header-with-topbar .header-icon i {
    color: #000 !important;
}

/* === SPASI KONTEN DI BAWAH HEADER === */
body {
    padding-top: 100px !important; 
}

/* === LINK MENU NAVBAR === */
header.header-with-topbar .navbar-nav .nav-link {
    color: #000 !important;    
    font-weight: 500;
    transition: color 0.3s;
}
header.header-with-topbar .navbar-nav .nav-link:hover {
    color: #007bff !important;
}

/* === ICON SEARCH === */
header.header-with-topbar .search-icon {
    color: #000 !important;  
}

/* === SECTION / BANNER DI BAWAH HEADER === */
.main-banner,
.hero-section,
section:first-of-type,
#home {
    margin-top: 0 !important;
}

/* === RESPONSIVE (HP / TABLET) === */
@media (max-width: 768px) {
    header.header-with-topbar,
    .header-with-topbar .navbar {
        height: 80px !important;
        min-height: 80px !important;
    }
    body {
        padding-top: 80px !important;
    }
    header.header-with-topbar .navbar-brand img {
        max-height: 50px !important;
    }
}

/* === MODAL Z-INDEX FIX === */
.modal {
    z-index: 10000 !important;
}
.modal-backdrop {
    z-index: 9999 !important;
}
.modal-header .close {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  opacity: 1;
}
.modal-header .close:hover {
  color: red;
  opacity: 1;
}
.btn.btn-primary.br-20 {
    background-color: #007bff !important; /* warna biru tetap */
    color: #fff !important;               /* teks putih */
    border-color: #007bff !important;
}

.btn.btn-primary.br-20:hover,
.btn.btn-primary.br-20:focus,
.btn.btn-primary.br-20:active {
    background-color: #007bff !important; /* biar hover tidak berubah */
    color: #fff !important;               /* biar teks tetap putih */
    border-color: #007bff !important;
}


</style>

<!-- start header -->
<header class="header-with-topbar">
    <!-- start header top bar -->
    <div class="header-top-bar bg-primary text-center py-2">
        <div class="fs-16 text-white">
            Upgrade Skill Tanpa Batas, Lampaui Batas! <a style="color: yellow; font-weight: bold;">#Bankir Hebat</a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-white border-bottom border-color-transparent-white-light disable-fixed"
        style="padding:0; height:80px;">
        <div class="container-fluid">
            <div class="row w-100 align-items-center" style="margin:0; width:100%;">
            
            <!-- Logo col-2 -->
            <div class="col-2 d-flex align-items-center">
                <a class="navbar-brand m-0" href="/">
                <img src="{{asset('FE/images/logo.png')}}" alt="Logo" 
                    style="height:40px;">
                </a>
            </div>

            <!-- Menu col-8 -->
            <div class="col-8">
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav alt-font" 
                    style="display:flex; gap:0px; align-items:center; margin:0; font-size:15px;">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Beranda</a></li>
                    <li class="nav-item dropdown simple-dropdown">
                    <a href="#" class="nav-link">Layanan</a>
                    <i class="fa-solid fa-angle-down dropdown-toggle" 
                        role="button" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu">
                        <li><a href="/pages/Banking-Solution">Banking Solution</a></li>
                        <li><a href="/pages/Capacity-Building">Capacity Building</a></li>
                        <li><a href="/pages/Talent-Solution">Banking Talent Solution</a></li>
                        <li><a href="/list-class?jenis=bankir">Event</a></li>
                    </ul>
                    </li>
                    <li class="nav-item"><a href="/promo" class="nav-link">Promo</a></li>
                    <li class="nav-item"><a href="/pages/blog" class="nav-link">Literasi</a></li>
                    <li class="nav-item"><a href="https://bankiracademy.com/u-laman/kurikulum" class="nav-link">Kurikulum</a></li>
                    <li class="nav-item"><a href="/loker-front" class="nav-link">Loker Bankir</a></li>
                </ul>
                </div>
            </div>

            <!-- Login/Signup col-2 -->
            <div class="col-2 d-flex justify-content-end align-items-center" style="gap:5px;">
            
                @if(Auth::check())
                    <!-- Sudah login -->
                    {{-- <div class="dropdown">
                        <a class="btn btn-outline-primary dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                            <a class="dropdown-item" href="/profile">Profil</a>
                            <a class="dropdown-item" href="/dashboard">Dashboard</a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </div> --}}
                @else
                    <!-- Belum login -->
                    <button type="button" 
                        data-toggle="modal" data-target="#modelId"
                        style="font-size:14px;font-weight:500;border:1.5px solid #007bff;color:#007bff;
                            background-color:transparent;border-radius:6px;padding:6px 16px;cursor:pointer;"
                        onmouseover="this.style.backgroundColor='#007bff';this.style.color='white';"
                        onmouseout="this.style.backgroundColor='transparent';this.style.color='#007bff';">
                        Login
                    </button>
                    <button type="button" 
                        data-toggle="modal" data-target="#modelId"
                        style="font-size:14px;font-weight:500;background-color:#007bff;color:white;
                            border:none;border-radius:6px;padding:6px 16px;cursor:pointer;"
                        onmouseover="this.style.backgroundColor='#0056b3';"
                        onmouseout="this.style.backgroundColor='#007bff';">
                        Sign Up
                    </button>
                @endif
                 @if (Auth::check() && Auth::user()->role == 2)
                    <li class="menu-item d-flex">
                        <a class="menu-link" href="{{ url('/profile') }}"
                            style="padding-left: 5px; padding-right: 5px">
                            <button type="button"
                                style="display:inline-flex;align-items:center;gap:6px;
                                    font-size:14px;font-weight:500;border:1.5px solid #007bff;color:#007bff;
                                    background-color:transparent;border-radius:6px;padding:6px 16px;cursor:pointer;
                                    transition:all 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#007bff';this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent';this.style.color='#007bff';">
                                Profile
                            </button>
                        </a>
                        <a class="menu-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            style="padding-left: 5px; padding-right: 5px">
                           <button type="button"
                                style="display:inline-flex;align-items:center;gap:6px;
                                    font-size:14px;font-weight:500;background-color:#ffa200;color:white;
                                    border:none;border-radius:6px;padding:6px 16px;cursor:pointer;
                                    transition:all 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#0056b3';"
                                onmouseout="this.style.backgroundColor='#007bff';">
                              
                                Logout
                            </button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>
                    @endif
                    @if (Auth::check() && Auth::user()->role !== 2)
                    <li class="menu-item"><a class="menu-link" href="{{ url('/profile') }}"
                            style="padding-right: 0px;">
                            <button class="btn btn-primary br-20" style="border-radius: 20px; font-size: 15px;;">Admin Area</button>
                        </a>
                    </li>
                    @endif
            </div>
        </div>
    </nav>

    <!-- start push popup -->
    <div class="push-menu push-menu-style-3 p-50px bg-dark-gray">
        <span class="close-menu text-dark-gray bg-white"><i class="fa-solid fa-xmark"></i></span>
        <div class="push-menu-wrapper text-dark-gray" data-scroll-options='{ "theme": "light" }'>
            <div class="w-100">
                <h4 class="alt-font text-white fw-400 mb-30px d-block w-90 lh-40">Scalable business for <span class="d-inline-block fw-600 border-3 border-bottom border-color-base-color">startups</span></h4>
            </div>
            <div class="col-12">
                <ul class="fs-20 ps-0 alt-font">
                    <li class="pt-10px pb-10px w-100"><a class="facebook" href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f w-30px text-start text-white"></i>Facebook</a></li>
                    <li class="pt-10px pb-10px w-100"><a class="instagram" href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram w-30px text-start text-white"></i>Instagram</a></li>
                    <li class="pt-10px pb-10px w-100"><a class="twitter" href="https://twitter.com/" target="_blank"><i class="fa-brands fa-twitter w-30px text-start text-white"></i>Twitter</a></li>
                    <li class="pt-10px pb-10px w-100"><a class="dribbble" href="https://www.dribbble.com/" target="_blank"><i class="fa-brands fa-dribbble w-30px text-start text-white"></i>Dribbble</a></li>
                </ul>
            </div>
            <div class="border-top border-color-transparent-white-light pt-30px w-100">
                <span class="fs-24 fw-500 text-white"><a href="tel:12345678910">+1 234 567 8910</a></span>
                <a href="/cdn-cgi/l/email-protection#721b1c141d32161d1f131b1c5c111d1f"><span class="__cf_email__" data-cfemail="d9b0b7bfb699bdb6b4b8b0b7f7bab6b4">[email&nbsp;protected]</span></a>
            </div>
        </div>
    </div>
    <!-- end push popup -->
</header>

@if(Session::has('info'))
<div class="alert alert-warning alert-dismissible fade show text-center m-0" role="alert">
    {{Session::get('info')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Modal Login -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg border-0 rounded-lg">
      <br>
      <br>
      <!-- Header -->
      <div class="modal-header border-0">
        <h5 class="modal-title font-weight-bold">Login to Your Account</h5>
        <!-- Close button pojok kanan -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; right:15px; top:15px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 pb-4">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <label for="emaillogin">Email</label>
            <input type="email" class="form-control" id="emaillogin" name="email" placeholder="Enter your email" required>
          </div>

          <div class="form-group">
            <label for="passwordlogin">Password</label>
            <input type="password" class="form-control" id="passwordlogin" name="password" placeholder="Enter your password" required>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="#" class="small">Forgot Password?</a>
          </div>

          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <div class="text-center my-3">
          <span class="text-muted">or</span>
        </div>

       <div class="text-center mt-3">
            <!-- Google Login -->
            <a href="{{ route('social.redirect', 'google') }}" class="btn btn-outline-primary w-100">
                <i class="fab fa-google"></i> Login dengan Google
            </a>


            <!-- Register -->
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-block mt-2" style="max-width: 300px; margin: auto;" hidden>
                Create Account
            </a>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- End Modal Login -->



<!-- end modal login -->

<!-- Modal Member -->
<div class="modal fade" id="modelmember" tabindex="-1" data-backdrop="modal" data-keyboard="false" role="dialog"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <img src="/front/images/A_BLM_MEMBER.jpg" alt="" width="100%">
            </div>
        </div>
    </div>
</div>
<!-- end modal member -->

<!-- Script untuk memperbaiki modal (tambahkan di akhir <body>) -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}

<script>
$(document).ready(function() {
    // Buka modal saat tombol login/sign up diklik
    $('button[data-target="#modelId"]').on('click', function() {
        $('#modelId').modal('show');
    });

    // Set backdrop agar tidak bisa klik luar modal
    $('#modelId').modal({
        backdrop: 'static',
        keyboard: false
    });
});

function closemodallogin() {
    $('#modelId').modal('hide');
}
</script>
