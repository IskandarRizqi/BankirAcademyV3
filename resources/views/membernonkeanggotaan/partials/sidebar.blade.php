 @php
     $user = auth()->user();
     $role = $user ? $user->role : null;
     $email = $user ? $user->email : null;
     $isRoot = $role == 4 && $email === 'cb@bankir.academy';
     $profile = optional($user)->profile;
     $membershipType = (int) data_get($profile, 'tipe_membership');

	$defaultMenus = [
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
	'label' => 'Ebook',
	'icon' => 'ebook',
	'url' => '/ebook',
	'active' => request()->is('ebook'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Video',
	'icon' => 'video',
	'url' => '/video',
	'active' => request()->is('video'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Pembelian',
	'icon' => 'billing',
	'url' => '/pembayaran',
	'active' => request()->is('pembayaran'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Pembelajaran anda',
	'icon' => 'kelas',
	'url' => '/kelas-event',
	'active' => request()->is('kelas-event'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Sertifikat',
	'icon' => 'sertifikat',
	'url' => '/sertifikat-kelas',
	'active' => request()->is('sertifikat-kelas*'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Loker',
	'icon' => 'loker',
	'url' => route('membernonanggota.loker.index'),
	'active' => request()->routeIs('membernonanggota.loker.index', 'membernonanggota.loker.show'),
	'can_see' => (int) $role === 2,
	'has_submenu' => false,
	],
	];

	$membershipMenus = match ($membershipType) {
	\App\Models\DataPayment::MEMBERSHIP_TYPE_COMPANY => [
	[
	'label' => 'SOP',
	'icon' => 'sop',
	'url' => route('membernonanggota.sop.index'),
	'active' => request()->routeIs('membernonanggota.sop.*'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Bonus Aplikasi',
	'icon' => 'aplikasi',
	'url' => route('membernonanggota.bonus-aplikasi.index'),
	'active' => request()->routeIs('membernonanggota.bonus-aplikasi.*'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Pasang loker',
	'icon' => 'loker',
	'url' => route('membernonanggota.loker.manage.index'),
	'active' => request()->routeIs('membernonanggota.loker.manage.*'),
	'can_see' => true,
	'has_submenu' => true,
	'submenu_id' => 'member-company-loker-submenu',
	'submenu_items' => [
	[
	'label' => 'Profil',
	'url' => route('membernonanggota.loker.manage.company.edit'),
	'active' => request()->routeIs('membernonanggota.loker.manage.company.*'),
	'can_see' => true,
	],
	[
	'label' => 'Posting',
	'url' => route('membernonanggota.loker.manage.index'),
	'active' => request()->routeIs(
	'membernonanggota.loker.manage.index',
	'membernonanggota.loker.manage.create',
	'membernonanggota.loker.manage.edit',
	'membernonanggota.loker.manage.store',
	'membernonanggota.loker.manage.update',
	'membernonanggota.loker.manage.destroy'
	),
	'can_see' => true,
	],
	],
	],
	[
	'label' => 'Program Inkubasi UMKM',
	'icon' => 'inkubasi',
	'url' => '#',
	'active' => false,
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Konsultasi',
	'icon' => 'konsultasi',
	'url' => '#',
	'active' => false,
	'can_see' => true,
	'has_submenu' => false,
	],

	[
	'label' => 'Komunitas & Program Afiliasi',
	'icon' => 'komunitas',
	'url' => '#',
	'active' => false,
	'can_see' => true,
	'has_submenu' => false,
	],
	],
	\App\Models\DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL => [
	[
	'label' => 'Buat CV ATS',
	'icon' => 'cv',
	'url' => route('membernonanggota.cv-ats.index'),
	'active' => request()->routeIs('membernonanggota.cv-ats.*'),
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Konsultasi',
	'icon' => 'konsultasi',
	'url' => '#',
	'active' => false,
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Komunitas',
	'icon' => 'komunitas',
	'url' => '#',
	'active' => false,
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Program afiliasi',
	'icon' => 'afiliasi',
	'url' => '#',
	'active' => false,
	'can_see' => true,
	'has_submenu' => false,
	],
	[
	'label' => 'Member point',
	'icon' => 'point',
	'url' => '#',
	'active' => false,
	'can_see' => true,
	'has_submenu' => false,
	],
	],
	default => [],
	};

     $menus = array_merge($defaultMenus, $membershipMenus);

     $icons = [
         'dashboard' => '<i class="fas fa-chart-line"></i>',
         'event' => '<i class="fas fa-chalkboard"></i>',
         'ebook' => '<i class="fas fa-book-reader"></i>',
         'video' => '<i class="fas fa-video"></i>',
         'billing' => '<i class="fas fa-credit-card"></i>',
         'kelas' => '<i class="fas fa-address-book"></i>',
         'sertifikat' => '<i class="fas fa-medal"></i>',
         'sop' => '<i class="fas fa-file-alt"></i>',
         'loker' => '<i class="fas fa-briefcase"></i>',
         'inkubasi' => '<i class="fas fa-seedling"></i>',
         'konsultasi' => '<i class="fas fa-comments"></i>',
         'aplikasi' => '<i class="fas fa-tools"></i>',
         'komunitas' => '<i class="fas fa-users"></i>',
         'lowongan' => '<i class="fas fa-bullhorn"></i>',
         'cv' => '<i class="fas fa-file-signature"></i>',
         'riwayat' => '<i class="fas fa-history"></i>',
         'afiliasi' => '<i class="fas fa-handshake"></i>',
         'point' => '<i class="fas fa-star"></i>',
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

         @foreach ($menus as $menu)
             @if ($menu['can_see'])
                 @if ($menu['has_submenu'])
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
                             <a class="sub-link {{ request()->is('materi*') ? 'active' : '' }}"
                                 href="/materi">Kompetensi</a>
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
             <a href="https://wa.me/6289682019523?text=Halo%20Tim%20Bankir%20Academy,%20saya%20butuh%20bantuan"
                 target="_blank">Hubungi Support</a>
         </div>
     </div>
 </div>
 <!-- END SIDEBAR -->
