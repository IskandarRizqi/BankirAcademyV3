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

    <a href="{{ route('admin.loker.index') }}"
        class="nav-item-link {{ request()->is('admin/loker*', 'admin/perusahaan*', 'admin/apply*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['briefcase'] !!}</span>
        <span>Loker</span>
    </a>

    <a href="{{ route('admin.sop.index') }}"
        class="nav-item-link {{ request()->routeIs('admin.sop.*') ? 'active' : '' }}">
        <span class="nav-icon">{!! $icons['file'] !!}</span>
        <span>SOP</span>
    </a>
@endif
