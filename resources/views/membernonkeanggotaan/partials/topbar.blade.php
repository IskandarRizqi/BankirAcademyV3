@php
    $user = Auth::user();
    $profile = $user ? $user->profile : null;
    $profilePictureUrl = \App\Helper\GlobalHelper::userProfilePictureUrl($profile);
    $profileFallbackUrl = asset('cbtemplate/assets/img/90x90.jpg');

    // Mengambil nilai status pembayaran dari shared variable billingSummary
    $summary = $billingSummary ?? [];
    $paidCount = data_get($summary, 'paid_count', 0);
    $pendingCount = data_get($summary, 'pending_count', 0);
    $failedCount = data_get($summary, 'failed_count', 0);
@endphp

@once
    <style>
        .topbar-badges {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: 12px;
        }

        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            text-decoration: none;
            transition: transform 0.15s ease, opacity 0.15s ease;
        }

        .topbar-badge:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        .topbar-badge--success {
            background-color: #d1fae5;
            color: #047857;
        }

        .topbar-badge--warning {
            background-color: #fef3c7;
            color: #b45309;
        }

        .topbar-badge--danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .topbar-billing-btn {
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            padding: 5px 12px;
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
        }

        .billing-dropdown-menu {
            min-width: 220px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .billing-dropdown-menu .dropdown-item {
            padding: 8px 16px;
            font-size: 13px;
        }

        @media (max-width: 640px) {
            .topbar-badge span.badge-label {
                display: none;
                /* Sembunyikan teks label di HP, tampilkan angka & ikon saja */
            }
        }
    </style>
@endonce

<!-- TOPBAR -->
<div class="topbar">
    <div class="topbar-left">
        <a href="javascript:void(0);" class="sidebar-toggle" id="sidebarToggle" aria-label="Buka atau tutup menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </a>
        <div class="topbar-welcome">
            <p class="eyebrow">Selamat datang kembali</p>
            <h4>{{ $user->name }}</h4>
        </div>
    </div>

    <div class="topbar-right">
        <!-- BADGE STATUS PEMBELIAN -->
        <div class="dropdown topbar-billing-dropdown mr-2">
            <button class="btn btn-light dropdown-toggle topbar-billing-btn" type="button" id="billingSummaryDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-receipt mr-1"></i>
                <span>Status Transaksi</span>
                <!-- Badge indicator total transaksi pending/aktif -->
                <span class="badge badge-warning ml-1" id="topbar-total-pending">0</span>
            </button>

            <div class="dropdown-menu dropdown-menu-right billing-dropdown-menu"
                aria-labelledby="billingSummaryDropdown">
                <div class="dropdown-header font-weight-bold">Ringkasan Pembayaran</div>
                <div class="dropdown-divider"></div>

                <a class="dropdown-item d-flex justify-content-between align-items-center"
                    href="{{ route('databilling', ['status' => 'berhasil']) }}">
                    <span><i class="fas fa-check-circle text-success mr-2"></i> Lunas</span>
                    <span class="badge badge-success badge-pill" id="topbar-paid-count">0</span>
                </a>

                <a class="dropdown-item d-flex justify-content-between align-items-center"
                    href="{{ route('databilling', ['status' => 'menunggu']) }}">
                    <span><i class="fas fa-clock text-warning mr-2"></i> Menunggu</span>
                    <span class="badge badge-warning badge-pill" id="topbar-pending-count">0</span>
                </a>

                <a class="dropdown-item d-flex justify-content-between align-items-center"
                    href="{{ route('databilling', ['status' => 'dibatalkan']) }}">
                    <span><i class="fas fa-times-circle text-danger mr-2"></i> Gagal</span>
                    <span class="badge badge-danger badge-pill" id="topbar-failed-count">0</span>
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center text-primary font-weight-bold small"
                    href="{{ route('databilling') }}">
                    Lihat Semua Riwayat
                </a>
            </div>
        </div>
        <!-- PROFILE DROPDOWN -->
        <div class="dropdown">
            <a href="javascript:void(0);" class="user-trigger" id="userProfileDropdown" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ $profilePictureUrl }}" alt="Foto profil {{ $user->name }}" referrerpolicy="no-referrer"
                    onerror="this.onerror=null;this.src='{{ $profileFallbackUrl }}'">
                <span class="user-meta">
                    <div class="name">{{ $user->name }}</div>
                </span>
                <svg class="chevron" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </a>

            <div class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userProfileDropdown">
                <div class="dropdown-header-block">
                    <img src="{{ $profilePictureUrl }}" alt="avatar" referrerpolicy="no-referrer"
                        onerror="this.onerror=null;this.src='{{ $profileFallbackUrl }}'">
                    <div>
                        <h6>{{ $user->name }}</h6>
                    </div>
                </div>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadBillingSummary() {
            $.ajax({
                url: "{{ route('databilling.summary') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('#topbar-paid-count').text(response.paid_count);
                    $('#topbar-pending-count').text(response.pending_count);
                    $('#topbar-failed-count').text(response.failed_count);

                    // Menampilkan indikator angka transaksi pending di tombol dropdown
                    $('#topbar-total-pending').text(response.pending_count);
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data billing summary:", error);
                }
            });
        }

        // Panggil langsung saat pertama kali halaman dimuat
        loadBillingSummary();

        // Jalankan otomatis setiap 10 detik (10000 ms)
        setInterval(loadBillingSummary, 10000);
    });
</script>

<!-- END TOPBAR -->
