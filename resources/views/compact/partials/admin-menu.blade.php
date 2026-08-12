@if ($isRoot)
    <a href="{{ route('instructor.index') }}"
        class="nav-item-link {{ request()->routeIs('instructor.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['instructor'] !!}</span>
        <span>Instruktor</span>
    </a>

    <a href="{{ route('classes.index') }}"
        class="nav-item-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['classes'] !!}</span>
        <span>Daftar Kelas</span>
    </a>

    <a href="{{ route('admin.payments.index') }}"
        class="nav-item-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['billing'] !!}</span>
        <span>Pembayaran</span>
    </a>

    <a href="{{ route('admin.manual-class-orders.index') }}"
        class="nav-item-link {{ request()->routeIs('admin.manual-class-orders.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['list'] !!}</span>
        <span>Order Kelas Manual</span>
    </a>

    <div class="menu {{ request()->is('admin/loker*', 'admin/perusahaan*', 'admin/apply*', 'admin/getdatacvpelamar') ? 'submenu-open' : '' }}">
        <a href="javascript:void(0);"
            class="nav-item-link {{ request()->is('admin/loker*', 'admin/perusahaan*', 'admin/apply*', 'admin/getdatacvpelamar') ? 'active' : '' }}"
            onclick="this.closest('.menu').classList.toggle('submenu-open')">
            <span class="nav-icon">{!! $icons['briefcase'] !!}</span>
            <span>Loker</span>
            <svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="16"
                height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </a>
        <div class="submenu-panel" id="loker">
            <a class="sub-link {{ request()->routeIs('perusahaan.*') ? 'active' : '' }}"
                href="{{ route('perusahaan.index') }}">Master Perusahaan</a>
            <a class="sub-link {{ request()->routeIs('admin.loker.*') ? 'active' : '' }}"
                href="{{ route('admin.loker.index') }}">Form Loker</a>
            <a class="sub-link {{ request()->routeIs('apply.*') ? 'active' : '' }}"
                href="{{ route('apply.index') }}">List Apply</a>
            <a class="sub-link {{ request()->routeIs('admin.applications.cv') ? 'active' : '' }}"
                href="{{ route('admin.applications.cv') }}">CV Apply</a>
        </div>
    </div>

    <a href="{{ route('admin.sop.index') }}"
        class="nav-item-link {{ request()->routeIs('admin.sop.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['file'] !!}</span>
        <span>SOP</span>
    </a>
@endif
