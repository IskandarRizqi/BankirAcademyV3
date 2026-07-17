	@php
	$user = auth()->user();
	$role = $user ? $user->role : null;
	$email = $user ? $user->email : null;
	$isRoot = ($role == 4 && $email === 'cb@bankir.academy');

	$menus = [
	[
	'label' => 'Dashboard',
	'icon' => 'dashboard',
	'url' => '/dash-beranda',
	'active' => request()->is('dash-beranda'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Event',
	'icon' => 'event',
	'url' => '/event-kelas',
	'active' => request()->is('event-kelas'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Pembelian kelas',
	'icon' => 'billing',
	'url' => '/pembayaran',
	'active' => request()->is('pembayaran'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Kelas anda',
	'icon' => 'kelas',
	'url' => '#',
	'active' => request()->is('kelas-event'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Sertifikat',
	'icon' => 'sertifikat',
	'url' => '#',
	'active' => request()->is('sertifikat'),
	'can_see' => true,
	'has_submenu' => false,
	],
	];

	$icons = [
	'dashboard' => '<i class="fas fa-chart-line"></i>',
	'event'=>'<i class="fas fa-chalkboard"></i>',
	'billing'=>'<i class="fas fa-credit-card"></i>',
	'kelas'=>'<i class="fas fa-address-book"></i>',
	'sertifikat'=>'<i class="fas fa-medal"></i>',

	];
	@endphp

	<!-- SIDEBAR -->
	<div class="sidebar-wrapper">
		<div class="sidebar-brand">
			<img src="{{ asset('bankir-academy-icon.png') }}" alt="logo">
			<span>Bankir Academy</span>
		</div>

		<nav class="sidebar-nav">
			<div class="nav-section-label">Menu Utama</div>

			@foreach($menus as $menu)
			@if($menu['can_see'])
			@if($menu['has_submenu'])
			<div class="menu {{ $menu['active'] ? 'submenu-open' : '' }}">
				<a href="javascript:void(0);"
					class="nav-item-link {{ $menu['active'] ? 'active' : '' }}"
					onclick="this.closest('.menu').classList.toggle('submenu-open')">
					<span class="nav-icon">{!! $icons[$menu['icon']] !!}</span>
					<span>{{ $menu['label'] }}</span>
					<svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="15 18 9 12 15 6"></polyline>
					</svg>
				</a>
				<div class="submenu-panel" id="{{ $menu['submenu_id'] }}">
					<a class="sub-link {{ request()->is('kategori-materi*') ? 'active' : '' }}" href="/kategori-materi">Bidang</a>
					<a class="sub-link {{ request()->is('materi*') ? 'active' : '' }}" href="/materi">Kompetensi</a>
					<a class="sub-link {{ request()->is('sub-materi*') ? 'active' : '' }}" href="/sub-materi">Materi</a>
					<a class="sub-link {{ request()->is('ppt*') ? 'active' : '' }}" href="/ppt">PPT</a>
					<a class="sub-link {{ request()->is('certificate-templates*') ? 'active' : '' }}" href="/certificate-templates">Sertifikat</a>
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