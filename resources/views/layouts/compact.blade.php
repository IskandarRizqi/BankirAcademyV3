<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CORK Admin Template - Analytics Dashboard</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/loader.js') }}"></script>

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css"
        class="dashboard-analytics" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">

    <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/custom-select2.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.21/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        #invoice-list th,
        #invoice-list td {
            white-space: nowrap;
        }
    </style>

    <!-- @stack('styles') -->
</head>

<body class="dashboard-analytics">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm d-flex align-items-center">
        <!-- Hamburger Menu -->
        <a href="javascript:void(0);" class="sidebarCollapse mr-3" data-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </a>

        <!-- Kalimat Selamat Datang (Menempel & Center) -->
        <div class="d-flex align-items-center m-0">
            <h4 class="m-0 text-dark">Selamat Datang {{auth()->user()->name}}</h4>
        </div>

        <!-- Dropdown Profile Didorong ke Kanan -->
        <ul class="navbar-item align-items-center flex-row navbar-dropdown ml-auto">
            <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="assets/img/90x90.jpg" alt="admin-profile" class="img-fluid">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <img src="assets/img/90x90.jpg" class="img-fluid mr-2" alt="avatar">
                            <div class="media-body">
                                @if(Auth::check())
                                <h5>{{auth()->user()->name}}</h5>
                                <p>{{auth()->user()->role_name}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <a href="user_profile.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg> <span> Profile</span>
                        </a>
                    </div>
                    <div class="dropdown-item" hidden>
                        <a href="apps_mailbox.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-inbox">
                                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                <path
                                    d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                </path>
                            </svg> <span> Inbox</span>
                        </a>
                    </div>
                    <div class="dropdown-item" hidden>
                        <a href="auth_lockscreen.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-lock">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg> <span>Lock Screen</span>
                        </a>
                    </div>
                    <div class="dropdown-item">
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
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
     @php
    // 1. Ambil data user saat ini
    $user = auth()->user();
    $role = $user ? $user->role : null;
    $email = $user ? $user->email : null;
    $isRoot = ($role == 4 && $email === 'cb@bankir.academy');

    // 2. Definisikan semua menu dan aturan aksesnya
    $menus = [
        [
            'label' => 'Dashboard',
            'icon' => 'home',
            'url' => '/home',
            'active' => request()->is('home'),
            'can_see' => true, 
            'has_submenu' => false
        ],
        [
            'label' => 'Pre Post Test',
            'icon' => 'zap',
            'url' => '#dashboard',
            'active' => request()->is('kategori-materi*', 'materi*', 'sub-materi*', 'ppt*'),
            'can_see' => $isRoot,
            'has_submenu' => true
        ],
        [
            'label' => 'Pengguna',
            'icon' => 'cpu',
            'url' => route('users.index'),
            'active' => request()->routeIs('users.*'),
            'can_see' => in_array($role, [4, 5]),
            'has_submenu' => false
        ],
        [
            'label' => 'Pelatihan',
            'icon' => 'cpu',
            'url' => '/pelatihan',
            'active' => request()->routeIs('siswa.materi.*') && !request()->is('*report*'),
            'can_see' => ($role == 6),
            'has_submenu' => false
        ],
        // BARU: Menu Report untuk Bank (5), Sekolah (4 non-root), dan Root (4 dengan email khusus)
        [
            'label' => 'Rekap Modul',
            'icon' => 'bar-chart-2',
            'url' => '/manajemen/laporan-siswa', // Sesuaikan dengan halaman rekap tabel siswa_modul_aktif Anda
            'active' => request()->is('*manajemen/report*') || request()->is('*laporan-siswa*'),
            'can_see' => in_array($role, [4, 5]), // Root (4), Sekolah (4), Bank (5) bisa melihat
            'has_submenu' => false
        ],
        [
            'label' => 'Membership',
            'icon' => 'zap',
            'url' => route('memberships.index'),
            'active' => request()->routeIs('memberships.*'),
            'can_see' => $isRoot,
            'has_submenu' => false
        ],
    ];
@endphp

<div class="sidebar-wrapper sidebar-theme">

    <nav id="compactSidebar">
        <ul class="navbar-nav theme-brand flex-row">
            <li class="nav-item theme-logo">
                <a href="index.html">
                    <img src="assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                </a>
            </li>
        </ul>
        <ul class="menu-categories">
            
            {{-- Loop Menu Utama --}}
            @foreach($menus as $menu)
                @if($menu['can_see'])
                    <li class="menu {{ $menu['active'] ? 'active' : '' }}">
                        <a href="{{ $menu['url'] }}" 
                           data-active="{{ $menu['active'] ? 'true' : 'false' }}" 
                           class="menu-toggle"
                           @if(!$menu['has_submenu']) onclick="window.location.href='{{ $menu['url'] }}';" @endif>
                            <div class="base-menu">
                                <div class="base-icons">
                                    {{-- Menggunakan Icon Dinamis --}}
                                    @if($menu['icon'] === 'home')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    @elseif($menu['icon'] === 'zap')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                    @endif
                                </div>
                                <span>{{ $menu['label'] }}</span>
                            </div>
                        </a>
                        @if($menu['has_submenu'])
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        @endif
                    </li>
                @endif
            @endforeach

        </ul>
    </nav>

    <div id="compact_submenuSidebar" class="submenu-sidebar">
        
        {{-- Submenu Pre Post Test (Hanya muncul jika user adalah Root) --}}
        @if($isRoot)
        <div class="submenu" id="dashboard">
            <ul class="submenu-list" data-parent-element="#dashboard">
                <li class="{{ request()->is('kategori-materi*') ? 'active' : '' }}"><a href="/kategori-materi"> Bidang </a></li>
                <li class="{{ request()->is('materi*') ? 'active' : '' }}"><a href="/materi"> Kompetensi </a></li>
                <li class="{{ request()->is('sub-materi*') ? 'active' : '' }}"><a href="/sub-materi"> Materi </a></li>
                <li class="{{ request()->is('ppt*') ? 'active' : '' }}"><a href="/ppt"> PPT </a></li>
            </ul>
        </div>
        @endif

    </div>

</div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    {{-- <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="javascript:void(0);">Analytics</a></li>
                        </ol>
                    </nav> --}}
                </div>

                @yield('content')
            </div>

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2021 <a target="_blank" href="https://designreset.com">DesignReset</a>, All
                        rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg></p>
                </div>
            </div>
        </div>
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="plugins/apex/apexcharts.min.js"></script>
    <script src="assets/js/dashboard/dash_1.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <script>
        function createtable(id) {
            $('#'+id).DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Pencarian",
                "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [10, 20, 50],
                "pageLength": 10,
            });
        }

        function numberformat(id,target) {
            new Cleave('#'+id, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                // prefix: 'Rp ',
                noImmediatePrefix: true,
                numeralDecimalMark: ',',
                delimiter: '.',
                onValueChanged: function(e) {
                    // Setiap kali nilai berubah, update hidden input
                    $('#'+target) = e.target.rawValue;
                }
            });
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>