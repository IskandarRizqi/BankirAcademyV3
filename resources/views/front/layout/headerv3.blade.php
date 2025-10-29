<!-- Header -->
<style>
    /* Tambahan styling agar header sticky dan mirip dengan gambar */
    .top-banner {
        background-color: #007bff;
        color: white;
        text-align: center;
        padding: 10px 0;
        font-size: 14px;
    }

    #main-header {
        position: sticky;
        top: 0;
        z-index: 9999;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .navbar-nav .nav-link {
        color: #000 !important;
        font-weight: 500;
        margin: 0 10px;
        transition: color 0.2s ease-in-out;
    }

    .navbar-nav .nav-link:hover {
        color: #007bff !important;
    }

    .navbar-brand img {
        max-height: 40px;
    }

    .btn-outline-primary {
        border-radius: 20px;
    }

    .btn-warning {
        border-radius: 20px;
    }

    /* ==========================
       Dropdown muncul saat hover
    =========================== */
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0; /* Hilangkan jarak antara tombol dan menu */
    }

    /* Efek animasi halus saat muncul */
    .dropdown-menu {
        transition: all 0.2s ease-in-out;
        opacity: 0;
        visibility: hidden;
    }

    .nav-item.dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
    }

    /* Supaya dropdown tidak hilang saat pindah mouse ke bawah */
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

.modal {
    z-index: 20000 !important;
}

.modal-backdrop {
    z-index: 19999 !important;
}

body.modal-open {
    overflow: hidden !important;
    padding-right: 0 !important;
}
    .swal2-container {
        z-index: 30000 !important;
    }

    /* Tambahan padding untuk konten di bawah header */
    /* body {
        padding-top: 70px;
    } */
</style>

<!-- Banner biru atas -->
<div class="top-banner">
    Upgrade Skill Tanpa Batas, Lampaui Batas! <a style="color: yellow; font-weight: bold;">#Bankir Hebat</a>
</div>

<!-- Navbar utama -->
<nav class="navbar navbar-expand-lg navbar-light" id="main-header">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ env('CUSTOM_LOGO', '/Bank-academy-logo-03.png') }}" alt="Bankir Academy">
        </a>

        <!-- Toggle menu mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu utama -->
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>

                <!-- Dropdown Layanan -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="layananDropdown" role="button"
                        aria-haspopup="true" aria-expanded="false">Layanan</a>
                    <div class="dropdown-menu" aria-labelledby="layananDropdown">
                        <a class="dropdown-item" href="/pages/Banking-Solution">Banking Solution</a>
                        <a class="dropdown-item" href="/pages/Capacity-Building">Capacity Building</a>
                        <a class="dropdown-item" href="/pages/Talent-Solution">Banking Talent Solution</a>
                        <a class="dropdown-item" href="/list-class?jenis=bankir">Event</a>
                    </div>
                </li>

                <li class="nav-item"><a class="nav-link" href="/promo">Promo</a></li>
                <li class="nav-item"><a class="nav-link" href="/pages/blog">Literasi</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Kurikulum</a></li>
                <li class="nav-item"><a class="nav-link" href="/loker">Loker Bankir</a></li>
            </ul>

            <!-- Tombol kanan -->
            <div class="d-flex">
                @if (!Auth::check())
                    <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modelId">Login</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modelId">Sign Up</button>
                @endif

                @if (Auth::check() && Auth::user()->role == 2)
                    <a href="{{ url('/profile') }}" 
                    class="btn mr-2" 
                    style="background-color:#17a2b8 !important; color:#fff !important; border:none !important; padding:8px 18px !important; border-radius:6px !important; text-decoration:none !important; font-weight:500 !important;">
                    Profile
                    </a>

                    <a href="{{ route('logout') }}" 
                    class="btn" 
                    style="background-color:#ffc107 !important; color:#fff !important; border:none !important; padding:8px 18px !important; border-radius:6px !important; text-decoration:none !important; font-weight:500 !important;"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endif


                @if (Auth::check() && Auth::user()->role !== 2)
                    <a href="{{ url('/home') }}" class="btn btn-primary">Admin Area</a>
                @endif
            </div>

        </div>
    </div>
</nav>

<!-- Modal Login -->
<div class="modal fade" id="modelId" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="hidemodallogin" class="close" onclick="closemodallogin()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <h3 class="font-body">Login to your Account</h3>
                <div class="form-group">
                    <label for="emaillogin">Email:</label>
                    <input type="email" id="emaillogin" name="email" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="passwordlogin">Password:</label>
                    <input type="password" id="passwordlogin" name="password" class="form-control" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" id="login" onclick="funclogin()">Login</button>
                    <a href="#" class="float-right small mt-2">Forgot Password?</a>
                </div>
                <hr>
                <a href="{{ url('/auth/google') }}" class="btn btn-danger btn-block">Login/Register with Google</a>
            </div>
        </div>
    </div>
</div>



{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function funclogin() {
    // Ambil input email dan password
    let email = document.getElementById("emaillogin").value;
    let password = document.getElementById("passwordlogin").value;

    if (email === "" || password === "") {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Email dan Password tidak boleh kosong!",
        });
        return;
    }

    $('#modelId').modal('hide'); // Tutup modal dulu


    setTimeout(() => {
        Swal.fire({
            icon: "success",
            title: "Login Berhasil!",
            text: "Selamat datang kembali 👋",
            confirmButtonText: "OK"
        }).then(() => {

        
            window.location.href = "/profile";
        });
    }, 300);
}
</script> --}}
