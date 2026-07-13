		<!-- TOPBAR -->
		<div class="topbar">
			<div class="topbar-left">
				<a href="javascript:void(0);" class="sidebar-toggle" id="sidebarToggle" aria-label="Buka atau tutup menu">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
					<a href="javascript:void(0);" class="user-trigger" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{ asset('assets/img/90x90.jpg') }}" alt="Foto profil {{ auth()->user()->name }}">
						<span class="user-meta">
							<div class="name">{{ auth()->user()->name }}</div>
							<div class="role">{{ auth()->user()->role_name }}</div>
						</span>
						<svg class="chevron" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
								<circle cx="12" cy="7" r="4"></circle>
							</svg>
							<span>Profil Saya</span>
						</a>

						<a href="{{ route('logout') }}" class="menu-item logout-item"
							onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
