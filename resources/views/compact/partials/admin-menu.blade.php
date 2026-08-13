@if ($isRoot)
    <div class="nav-section-label">Calon Bankir</div>

    <a href="{{ route('users.index') }}" class="nav-item-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['cpu'] !!}</span>
        <span>Bank, Sekolah & Peserta</span>
    </a>

    <div
        class="menu {{ request()->is('kategori-materi*', 'materi*', 'sub-materi*', 'ppt*', 'certificate-templates*') ? 'submenu-open' : '' }}">
        <a href="javascript:void(0);"
            class="nav-item-link {{ request()->is('kategori-materi*', 'materi*', 'sub-materi*', 'ppt*', 'certificate-templates*') ? 'active' : '' }}"
            onclick="this.closest('.menu').classList.toggle('submenu-open')">
            <span class="nav-icon">{!! $icons['teacher'] !!}</span>
            <span>Pembelajaran</span>
            <svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </a>
        <div class="submenu-panel" id="root-learning">
            <a class="sub-link {{ request()->is('kategori-materi*') ? 'active' : '' }}"
                href="{{ route('kategori-materi.index') }}">Bidang</a>
            <a class="sub-link {{ request()->is('materi*') ? 'active' : '' }}"
                href="{{ route('materi.index') }}">Kompetensi</a>
            <a class="sub-link {{ request()->is('sub-materi*') ? 'active' : '' }}"
                href="{{ route('sub-materi.index') }}">Materi</a>
            <a class="sub-link {{ request()->is('ppt*') ? 'active' : '' }}" href="{{ route('ppt.index') }}">PPT /
                Pre-post test</a>
            <a class="sub-link {{ request()->is('certificate-templates*') ? 'active' : '' }}"
                href="{{ route('certificate-templates.index') }}">Template sertifikat</a>
        </div>
    </div>

    <a href="{{ route('album.index') }}" class="nav-item-link {{ request()->is('album*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['list'] !!}</span>
        <span>Album Pembelajaran</span>
    </a>

    <a href="{{ route('beasiswa.approval.list') }}"
        class="nav-item-link {{ request()->routeIs('beasiswa.approval.list') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['approval'] !!}</span>
        <span>Approval Beasiswa</span>
    </a>

    <a href="{{ route('manajemen.laporan.index') }}"
        class="nav-item-link {{ request()->routeIs('manajemen.laporan.index', 'manajemen.siswa.report') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['bar-chart-2'] !!}</span>
        <span>Monitoring Peserta</span>
    </a>

    <div class="nav-section-label">Bankir</div>

    <a href="{{ route('instructor.index') }}"
        class="nav-item-link {{ request()->routeIs('instructor.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['instructor'] !!}</span>
        <span>Instruktur</span>
    </a>

    <a href="{{ route('classes.index') }}"
        class="nav-item-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['classes'] !!}</span>
        <span>Daftar Kelas</span>
    </a>

    <a href="{{ route('admin.manual-class-orders.index') }}"
        class="nav-item-link {{ request()->routeIs('admin.manual-class-orders.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['list'] !!}</span>
        <span>Order Kelas Manual</span>
    </a>

    <div
        class="menu {{ request()->is('admin/loker*', 'admin/perusahaan*', 'admin/apply*', 'admin/getdatacvpelamar') ? 'submenu-open' : '' }}">
        <a href="javascript:void(0);"
            class="nav-item-link {{ request()->is('admin/loker*', 'admin/perusahaan*', 'admin/apply*', 'admin/getdatacvpelamar') ? 'active' : '' }}"
            onclick="this.closest('.menu').classList.toggle('submenu-open')">
            <span class="nav-icon">{!! $icons['briefcase'] !!}</span>
            <span>Loker</span>
            <svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </a>
        <div class="submenu-panel" id="loker">
            <a class="sub-link {{ request()->routeIs('perusahaan.*') ? 'active' : '' }}"
                href="{{ route('perusahaan.index') }}">Master Perusahaan</a>
            <a class="sub-link {{ request()->routeIs('admin.loker.*') ? 'active' : '' }}"
                href="{{ route('admin.loker.index') }}">Form Loker</a>
            <a class="sub-link {{ request()->routeIs('apply.*') ? 'active' : '' }}"
                href="{{ route('apply.index') }}">List Pelamar</a>
            {{-- <a class="sub-link {{ request()->routeIs('admin.applications.cv') ? 'active' : '' }}"
                href="{{ route('admin.applications.cv') }}">CV Apply</a> --}}
        </div>
    </div>

    <a href="{{ route('admin.sop.index') }}"
        class="nav-item-link {{ request()->routeIs('admin.sop.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['file'] !!}</span>
        <span>SOP</span>
    </a>

    <div class="nav-section-label">Lintas Sistem</div>

    <a href="{{ route('admin.payments.index') }}"
        class="nav-item-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['billing'] !!}</span>
        <span>Pembayaran & Billing</span>
    </a>

    <a href="{{ route('memberships.index') }}"
        class="nav-item-link {{ request()->routeIs('memberships.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['zap'] !!}</span>
        <span>Paket Membership</span>
    </a>

    <a href="{{ route('recent-registrations.index') }}"
        class="nav-item-link {{ request()->routeIs('recent-registrations.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['users'] !!}</span>
        <span>Registrasi Promosi</span>
    </a>

    <a href="{{ route('activity.index') }}"
        class="nav-item-link {{ request()->routeIs('activity.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['history'] !!}</span>
        <span>Log Aktivitas Sistem</span>
    </a>
@endif
