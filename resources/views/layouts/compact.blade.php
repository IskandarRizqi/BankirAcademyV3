<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') - Bankir Academy</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="{{ asset('cbtemplate/assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cbtemplate/assets/css/layout.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cbtemplate/assets/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('cbtemplate/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cbtemplate/assets/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cbtemplate/assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="{{ asset('cbtemplate/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/plugins/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/plugins/select2/custom-select2.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.21/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

   
</head>

<body>

    @php
    $user = auth()->user();
    $role = $user ? $user->role : null;
    $email = $user ? $user->email : null;
    $isRoot = ($role == 4 && $email === 'cb@bankir.academy');

    $menus = [
    [
    'label' => 'Dashboard',
    'icon' => 'dashboard',
    'url' => '/home',
    'active' => request()->is('home'),
    'can_see' => true,
    'has_submenu' => false,
    ],
    [
    'label' => 'Pembelajaran',
    'icon' => 'teacher',
    'url' => '#dashboard',
    'active' => request()->is('kategori-materi*', 'materi*', 'sub-materi*', 'ppt*', 'certificate-templates*'),
    'can_see' => $isRoot,
    'has_submenu' => true,
    'submenu_id' => 'dashboard',
    ],
    [
    'label' => 'Pengguna',
    'icon' => 'cpu',
    'url' => route('users.index'),
    'active' => request()->routeIs('users.*'),
    'can_see' => in_array($role, [4, 5]),
    'has_submenu' => false,
    ],
    [
    'label' => 'Kompetensi',
    'icon' => 'graduate',
    'url' => '/pelatihan',
    'active' => request()->routeIs('siswa.materi.*') && !request()->is('*report*'),
    'can_see' => ($role == 6),
    'has_submenu' => false,
    ],
    [
    'label' => 'Pelatihan Umum',
    'icon' => 'teacher',
    'url' => '/materi-umum',
    'active' => request()->routeIs('siswa.umum.index*') && !request()->is('*report*'),
    'can_see' => ($role == 6),
    'has_submenu' => false,
    ],
    [
    'label' => 'History Pelatihan',
    'icon' => 'history',
    'url' => '/materi-umum/history',
    'active' => request()->routeIs('siswa.umum.history*'),
    'can_see' => ($role == 6),
    'has_submenu' => false,
    ],
    [
    'label' => 'Lowongan Kerja',
    'icon' => 'bar-chart-2',
    'url' => '/lowongan',
    'active' => request()->routeIs('lowongan*'),
    'can_see' => ($role == 6),
    'has_submenu' => false,
    ],
    [
    'label' => 'Buat CV ATS',
    'icon' => 'zap',
    'url' => '/cvats',
    'active' => request()->routeIs('cvats*'),
    'can_see' => ($role == 6),
    'has_submenu' => false,
    ],
    [
    'label' => 'Sertifikat',
    'icon' => 'sertificate',
    'url' => '/sertifikat',
    'active' => request()->routeIs('sertifikat*'),
    'can_see' => ($role == 6),
    'has_submenu' => false,
    ],
    [
    'label' => 'Rekap Modul',
    'icon' => 'bar-chart-2',
    'url' => '/manajemen/laporan-siswa',
    'active' => request()->is('*manajemen/report*') || request()->is('*laporan-siswa*'),
    'can_see' => in_array($role, [4, 5]),
    'has_submenu' => false,
    ],
    [
    'label' => 'Membership',
    'icon' => 'zap',
    'url' => route('memberships.index'),
    'active' => request()->routeIs('memberships.*'),
    'can_see' => $isRoot,
    'has_submenu' => false,
    ],
    [
    'label' => 'Log Activity',
    'icon' => 'history',
    'url' => route('activity.index'),
    'active' => request()->routeIs('activity.*'),
    'can_see' => $isRoot,
    'has_submenu' => false,
    ],
    [
    'label' => 'Approval',
    'icon' => 'zap',
    'url' => route('beasiswa.approval.list'),
    'active' => request()->routeIs('beasiswa.approval.list'),
    'can_see' => in_array($role, [4, 5]),
    'has_submenu' => false,
    ],
    ];

    $icons = [
    'home' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
    </svg>',
    'zap' => '<i class="fas fa-id-card"></i>',
    'cpu' => '<i class="fas fa-user-friends"></i>',
    'bar-chart-2' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="20" x2="18" y2="10"></line>
        <line x1="12" y1="20" x2="12" y2="4"></line>
        <line x1="6" y1="20" x2="6" y2="14"></line>
    </svg>',
    'graduate'=>'<i class="fas fa-user-graduate"></i> <i class="fas fa-fire text-warning mr-1"></i>',
    'teacher'=> '<i class="fas fa-book-open"></i>',
    'history'=> '<i class="fas fa-history"></i>',
    'dashboard' => '<i class="fas fa-chart-line"></i>',
    'sertificate'=>'<i class="fas fa-award"></i>'

    ];
    @endphp

    <div class="main-container" id="container">

        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- SIDEBAR -->
        <div class="sidebar-wrapper">
            <div class="sidebar-brand">
                <img src="{{ asset('cbtemplate/assets/img/90x90.jpg') }}" alt="logo">
                <span>Bankir Academy</span>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Menu Utama</div>

                @foreach($menus as $menu)
                @if($menu['can_see'])
                @if($menu['has_submenu'])
                <div class="menu {{ $menu['active'] ? 'submenu-open' : '' }}">
                    <a href="javascript:void(0);" class="nav-item-link {{ $menu['active'] ? 'active' : '' }}"
                        onclick="this.closest('.menu').classList.toggle('submenu-open')">
                        <span class="nav-icon">{!! $icons[$menu['icon']] !!}</span>
                        <span>{{ $menu['label'] }}</span>
                        <svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </a>
                    <div class="submenu-panel" id="{{ $menu['submenu_id'] }}">
                        <a class="sub-link {{ request()->is('kategori-materi*') ? 'active' : '' }}"
                            href="/kategori-materi">Bidang</a>
                        <a class="sub-link {{ request()->is('materi*') ? 'active' : '' }}" href="/materi">Kompetensi</a>
                        <a class="sub-link {{ request()->is('sub-materi*') ? 'active' : '' }}"
                            href="/sub-materi">Materi</a>
                        <a class="sub-link {{ request()->is('ppt*') ? 'active' : '' }}" href="/ppt">PPT</a>
                        <a class="sub-link {{ request()->is('certificate-templates*') ? 'active' : '' }}"
                            href="/certificate-templates">Sertifikat</a>
                    </div>
                </div>
                @else
                <a href="{{ $menu['url'] }}" class="nav-item-link {{ $menu['active'] ? 'active' : '' }}">
                    <span class="nav-icon">{!! $icons[$menu['icon']] !!}</span>
                    <span>{{ $menu['label'] }}</span>
                </a>
                @endif
                @endif
                @endforeach
            </nav>

            <div class="sidebar-footer">
                <div class="help-card">
                    <strong style="font-size:13px;">Butuh bantuan?</strong>
                    <p>Tim support kami siap membantu pertanyaan seputar platform.</p>
                    <a href="javascript:void(0);">Hubungi Support</a>
                </div>
            </div>
        </div>
        <!-- END SIDEBAR -->

        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <a href="javascript:void(0);" class="sidebar-toggle" id="sidebarToggle"
                    aria-label="Buka atau tutup menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>
                <div class="topbar-welcome">
                    <p class="eyebrow">Selamat datang kembali</p>
                    <h4>{{ auth()->user()->name }}</h4>
                </div>
            </div>

            <div class="topbar-right">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="user-trigger" id="userProfileDropdown" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('cbtemplate/assets/img/90x90.jpg') }}" alt="Foto profil {{ auth()->user()->name }}">
                        <span class="user-meta">
                            <div class="name">{{ auth()->user()->name }}</div>
                            <div class="role">{{ auth()->user()->role_name }}</div>
                        </span>
                        <svg class="chevron" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userProfileDropdown">
                        <div class="dropdown-header-block">
                            <img src="{{ asset('assets/img/90x90.jpg') }}" alt="avatar">
                            <div>
                                <h6>{{ auth()->user()->name }}</h6>
                                <span>{{ auth()->user()->role_name }}</span>
                            </div>
                        </div>

                        <a href="{{ url('userprofile') }}" class="menu-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Profil Saya</span>
                        </a>

                        <a href="{{ route('logout') }}" class="menu-item logout-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Keluar</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END TOPBAR -->

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="content-body">
                @yield('content')
            </div>

            <div class="page-footer">

                <span>Bankir Academy Admin</span>
            </div>
        </div>
        <!-- END MAIN CONTENT -->

    </div>
    <div id="wa-join-popup" class="wa-popup-container">
    <div class="wa-popup-card">
        <button type="button" class="wa-popup-close" onclick="closeWaPopup()">&times;</button>
        <div class="wa-popup-avatar">
            <img id="wa-user-avatar" src="" alt="User Avatar">
            <span class="wa-status-online"></span>
        </div>
        <div class="wa-popup-content">
            <div class="wa-popup-header">
                <strong id="wa-user-name">Nama User</strong>
                <span class="wa-badge"><i class="fab fa-whatsapp"></i> Baru Bergabung</span>
            </div>
            <p class="wa-popup-message" id="wa-user-msg">Baru saja mendaftar di Bankir Academy!</p>
            <span class="wa-popup-time" id="wa-user-time">Baru saja</span>
        </div>
    </div>
</div>

    <!-- GLOBAL SCRIPTS -->
    <script src="{{ asset('cbtemplate/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/js/app.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/js/custom.js') }}"></script>
    <script src="{{ asset('cbtemplate/assets/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Sidebar toggle (desktop collapses content, mobile slides drawer)
        const container = document.getElementById('container');
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('mobileOverlay');

        function isMobile() { return window.innerWidth < 992; }

        toggleBtn.addEventListener('click', function () {
            if (isMobile()) {
                container.classList.toggle('sidebar-open');
            } else {
                container.classList.toggle('sidebar-closed');
            }
        });

        overlay.addEventListener('click', function () {
            container.classList.remove('sidebar-open');
        });

        $(document).ready(function () {
            if (typeof App !== 'undefined') { App.init(); }
        });
        
        function openloading() {
            let timerInterval;
            Swal.fire({
            title: "Loading!",
            html: "Tunggu hingga proses selesai",
            timer: false,
            timerProgressBar: true,
            allowOutsideClick: false, // Prevents clicking outside to close
            allowEscapeKey: false,     // Prevents Esc key from closing
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                // timerInterval = setInterval(() => {
                // timer.textContent = `${Swal.getTimerLeft()}`;
                // }, 100);
            },
            // willClose: () => {
            //     clearInterval(timerInterval);
            // }
            }).then((result) => {
            /* Read more about handling dismissals below */
            });
        }

        function createtable(id) {
            $('#' + id).DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Pencarian",
                    "sLengthMenu": "Tampilkan: _MENU_",
                },
                "stripeClasses": [],
                "columnDefs": [
                    { "targets": [0], "orderable": false } // Disables sorting on the 1st and 5th columns (0-indexed)
                ],
                "lengthMenu": [10, 20, 50],
                "pageLength": 10,
            });
        }

        function numberformat(id, target) {
            new Cleave('#' + id, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                noImmediatePrefix: true,
                numeralDecimalMark: ',',
                delimiter: '.',
                onValueChanged: function (e) {
                    document.getElementById(target).value = e.target.rawValue;
                }
            });
        }
    </script>
    <script>
    // Data Dummy Customer
    const fakeCustomers = [
        { name: "Budi Santoso", city: "Jakarta", program: "Program Klasifikasi Bankir", avatar: "https://i.pravatar.cc/100?img=12" },
        { name: "Siti Rahmawati", city: "Surabaya", program: "Sertifikasi Manajemen Risiko", avatar: "https://i.pravatar.cc/100?img=47" },
        { name: "Andi Wijaya", city: "Bandung", program: "Pelatihan Credit Officer", avatar: "https://i.pravatar.cc/100?img=33" },
        { name: "Dewi Lestari", city: "Semarang", program: "Analis Kredit Banking", avatar: "https://i.pravatar.cc/100?img=5" },
        { name: "Rian Hidayat", city: "Medan", program: "Program Klasifikasi Bankir", avatar: "https://i.pravatar.cc/100?img=60" },
        { name: "Nabila Putri", city: "Yogyakarta", program: "Sertifikasi General Banking", avatar: "https://i.pravatar.cc/100?img=9" },
        { name: "Fajar Pratama", city: "Makassar", program: "Pelatihan Wealth Management", avatar: "https://i.pravatar.cc/100?img=15" }
    ];

    const timeList = ["Baru saja", "1 menit yang lalu", "2 menit yang lalu", "3 menit yang lalu"];

    let popupTimeout;

    function showRandomCustomerPopup() {
        const popup = document.getElementById('wa-join-popup');
        
        // Pilih random customer & waktu
        const randomCustomer = fakeCustomers[Math.floor(Math.random() * fakeCustomers.length)];
        const randomTime = timeList[Math.floor(Math.random() * timeList.length)];

        // Update UI
        document.getElementById('wa-user-avatar').src = randomCustomer.avatar;
        document.getElementById('wa-user-name').innerText = randomCustomer.name;
        document.getElementById('wa-user-msg').innerText = `Bergabung dari ${randomCustomer.city} (${randomCustomer.program})`;
        document.getElementById('wa-user-time').innerText = randomTime;

        // Tampilkan Popup
        popup.classList.add('show');

        // Sembunyikan otomatis setelah 6 detik
        setTimeout(() => {
            closeWaPopup();
        }, 6000);

        // Jadwalkan kemunculan berikutnya secara acak (antara 12 s/d 25 detik)
        const nextInterval = Math.floor(Math.random() * (25000 - 12000 + 1)) + 12000;
        popupTimeout = setTimeout(showRandomCustomerPopup, nextInterval);
    }

    function closeWaPopup() {
        const popup = document.getElementById('wa-join-popup');
        popup.classList.remove('show');
    }

    // Jalankan popup pertama kali setelah 3 detik halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(showRandomCustomerPopup, 3000);
    });
</script>

    @stack('scripts')
</body>

</html>