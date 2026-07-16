<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title>@yield('title', 'Dashboard') - Bankir Academy</title>

	<link rel="icon" type="image/x-icon" href="{{env('CUSTOM_FAVICON','/359x404.png')}}" />

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

	<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

	<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
	<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
	<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
	<script src="{{ asset('plugins/select2/custom-select2.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.21/dayjs.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

	<style>
		/* ============================================================
           DESIGN TOKENS
           ============================================================ */
		:root {
			--bg: #F6F7FB;
			--surface: #FFFFFF;
			--border: #E7E9F0;
			--text: #1B1F2A;
			--text-muted: #6B7280;
			--primary: #4F46E5;
			--primary-soft: #EEF0FE;
			--primary-dark: #3D33D8;
			--accent: #06B6D4;
			--danger: #E5484D;
			--radius-sm: 8px;
			--radius-md: 12px;
			--radius-lg: 16px;
			--shadow-sm: 0 1px 2px rgba(16, 24, 40, 0.05);
			--shadow-md: 0 4px 16px rgba(16, 24, 40, 0.08);
			--sidebar-w: 264px;
			--topbar-h: 68px;
		}

		* {
			box-sizing: border-box;
		}

		html,
		body {
			background: var(--bg);
			color: var(--text);
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			font-size: 14.5px;
			line-height: 1.5;
			-webkit-font-smoothing: antialiased;
		}

		a {
			text-decoration: none;
		}

		a:hover {
			text-decoration: none;
		}

		::-webkit-scrollbar {
			width: 8px;
			height: 8px;
		}

		::-webkit-scrollbar-thumb {
			background: #D7DAE3;
			border-radius: 8px;
		}

		::-webkit-scrollbar-track {
			background: transparent;
		}

		/* Keyboard focus visibility */
		a:focus-visible,
		button:focus-visible,
		input:focus-visible {
			outline: 2px solid var(--primary);
			outline-offset: 2px;
		}

		@media (prefers-reduced-motion: reduce) {
			* {
				animation-duration: 0.01ms !important;
				transition-duration: 0.01ms !important;
			}
		}

		/* ============================================================
           TOPBAR
           ============================================================ */
		.topbar {
			position: fixed;
			top: 0;
			left: var(--sidebar-w);
			right: 0;
			height: var(--topbar-h);
			background: var(--surface);
			border-bottom: 1px solid var(--border);
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 0 28px;
			z-index: 1030;
			transition: left .25s ease;
		}

		.main-container.sidebar-closed .topbar {
			left: 0;
		}

		.topbar-left {
			display: flex;
			align-items: center;
			gap: 16px;
		}

		.sidebar-toggle {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 38px;
			height: 38px;
			border-radius: var(--radius-sm);
			color: var(--text-muted);
			cursor: pointer;
			transition: background .15s ease, color .15s ease;
		}

		.sidebar-toggle:hover {
			background: var(--primary-soft);
			color: var(--primary);
		}

		.topbar-welcome {
			display: flex;
			flex-direction: column;
		}

		.topbar-welcome .eyebrow {
			font-size: 11px;
			font-weight: 600;
			letter-spacing: .06em;
			text-transform: uppercase;
			color: var(--text-muted);
			margin: 0;
		}

		.topbar-welcome h4 {
			margin: 0;
			font-size: 17px;
			font-weight: 700;
			color: var(--text);
		}

		.topbar-right {
			display: flex;
			align-items: center;
			gap: 18px;
		}

		.user-trigger {
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 6px 10px 6px 6px;
			border-radius: 999px;
			cursor: pointer;
			border: 1px solid transparent;
			transition: border-color .15s ease, background .15s ease;
		}

		.user-trigger:hover {
			background: var(--bg);
			border-color: var(--border);
		}

		.user-trigger img {
			width: 36px;
			height: 36px;
			border-radius: 50%;
			object-fit: cover;
			border: 2px solid var(--primary-soft);
		}

		.user-trigger .user-meta {
			text-align: left;
			line-height: 1.2;
		}

		.user-trigger .user-meta .name {
			font-size: 13.5px;
			font-weight: 600;
			color: var(--text);
		}

		.user-trigger .user-meta .role {
			font-size: 11.5px;
			color: var(--text-muted);
		}

		.user-trigger .chevron {
			color: var(--text-muted);
			font-size: 11px;
			margin-left: 2px;
		}

		.dropdown-menu.user-dropdown {
			border: 1px solid var(--border);
			border-radius: var(--radius-md);
			box-shadow: var(--shadow-md);
			padding: 8px;
			min-width: 240px;
		}

		.user-dropdown .dropdown-header-block {
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 10px 10px 14px 10px;
			border-bottom: 1px solid var(--border);
			margin-bottom: 6px;
		}

		.user-dropdown .dropdown-header-block img {
			width: 44px;
			height: 44px;
			border-radius: 50%;
			object-fit: cover;
		}

		.user-dropdown .dropdown-header-block h6 {
			margin: 0;
			font-size: 14px;
			font-weight: 700;
		}

		.user-dropdown .dropdown-header-block span {
			font-size: 12px;
			color: var(--text-muted);
		}

		.user-dropdown .menu-item {
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 9px 10px;
			border-radius: var(--radius-sm);
			color: var(--text);
			font-size: 13.5px;
			font-weight: 500;
			transition: background .15s ease;
		}

		.user-dropdown .menu-item:hover {
			background: var(--primary-soft);
			color: var(--primary);
		}

		.user-dropdown .menu-item svg,
		.user-dropdown .menu-item i {
			width: 18px;
			color: inherit;
		}

		.user-dropdown .menu-item.logout-item {
			color: var(--danger);
			margin-top: 4px;
			border-top: 1px solid var(--border);
			padding-top: 12px;
			border-radius: 0;
		}

		.user-dropdown .menu-item.logout-item:hover {
			background: #FDECEC;
			color: var(--danger);
		}

		/* ============================================================
           SIDEBAR
           ============================================================ */
		.sidebar-wrapper {
			position: fixed;
			top: 0;
			left: 0;
			bottom: 0;
			width: var(--sidebar-w);
			background: var(--surface);
			border-right: 1px solid var(--border);
			z-index: 1040;
			display: flex;
			flex-direction: column;
			transition: transform .25s ease;
		}

		.main-container.sidebar-closed .sidebar-wrapper {
			transform: translateX(calc(-1 * var(--sidebar-w)));
		}

		.sidebar-brand {
			height: var(--topbar-h);
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 0 22px;
			border-bottom: 1px solid var(--border);
			flex-shrink: 0;
		}

		.sidebar-brand img {
			width: 36px;
			height: 36px;
			border-radius: 10px;
			object-fit: cover;
		}

		.sidebar-brand span {
			font-size: 16px;
			font-weight: 800;
			color: var(--text);
			letter-spacing: -.01em;
		}

		.sidebar-nav {
			flex: 1;
			overflow-y: auto;
			padding: 18px 14px;
		}

		.nav-section-label {
			font-size: 11px;
			font-weight: 700;
			letter-spacing: .07em;
			text-transform: uppercase;
			color: #A3A8B8;
			padding: 0 12px;
			margin: 14px 0 8px;
		}

		.nav-section-label:first-child {
			margin-top: 0;
		}

		.nav-item-link {
			position: relative;
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 11px 14px;
			margin-bottom: 4px;
			border-radius: var(--radius-sm);
			color: #4B5160;
			font-size: 14px;
			font-weight: 500;
			transition: background .15s ease, color .15s ease;
		}

		.nav-item-link .nav-icon {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 20px;
			height: 20px;
			flex-shrink: 0;
		}

		.nav-item-link:hover {
			background: var(--bg);
			color: var(--text);
		}

		.nav-item-link.active {
			background: var(--primary-soft);
			color: var(--primary);
			font-weight: 600;
		}

		.nav-item-link.active::before {
			content: "";
			position: absolute;
			left: -14px;
			top: 8px;
			bottom: 8px;
			width: 4px;
			border-radius: 0 4px 4px 0;
			background: var(--primary);
		}

		.nav-item-link .chevron-icon {
			margin-left: auto;
			transition: transform .2s ease;
			color: #A3A8B8;
		}

		.menu.submenu-open>.nav-item-link .chevron-icon {
			transform: rotate(-90deg);
			color: var(--primary);
		}

		.submenu-panel {
			max-height: 0;
			overflow: hidden;
			transition: max-height .25s ease;
			padding-left: 18px;
		}

		.menu.submenu-open .submenu-panel {
			max-height: 400px;
		}

		.submenu-panel .sub-link {
			display: block;
			padding: 9px 14px 9px 24px;
			font-size: 13.5px;
			color: var(--text-muted);
			border-left: 2px solid var(--border);
			font-weight: 500;
			transition: color .15s ease, border-color .15s ease;
		}

		.submenu-panel .sub-link:hover,
		.submenu-panel .sub-link.active {
			color: var(--primary);
			border-left-color: var(--primary);
		}

		.sidebar-footer {
			padding: 16px;
			border-top: 1px solid var(--border);
			flex-shrink: 0;
		}

		.sidebar-footer .help-card {
			background: linear-gradient(135deg, var(--primary), #6C63FF);
			border-radius: var(--radius-md);
			padding: 16px;
			color: #fff;
		}

		.sidebar-footer .help-card p {
			font-size: 12.5px;
			opacity: .9;
			margin: 4px 0 10px;
		}

		.sidebar-footer .help-card a {
			display: inline-block;
			background: rgba(255, 255, 255, .18);
			color: #fff;
			font-size: 12.5px;
			font-weight: 600;
			padding: 7px 12px;
			border-radius: 8px;
			transition: background .15s ease;
		}

		.sidebar-footer .help-card a:hover {
			background: rgba(255, 255, 255, .3);
		}

		/* ============================================================
           MAIN CONTENT
           ============================================================ */
		.main-content {
			margin-left: var(--sidebar-w);
			padding-top: var(--topbar-h);
			min-height: 100vh;
			display: flex;
			flex-direction: column;
			transition: margin-left .25s ease;
		}

		.main-container.sidebar-closed .main-content {
			margin-left: 0;
		}

		.content-body {
			padding: 28px;
			flex: 1;
		}

		.page-footer {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 16px 28px;
			border-top: 1px solid var(--border);
			font-size: 12.5px;
			color: var(--text-muted);
		}

		.page-footer a {
			color: var(--primary);
			font-weight: 600;
		}

		.mobile-overlay {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(15, 17, 26, .45);
			z-index: 1035;
		}

		@media (max-width: 991px) {
			.sidebar-wrapper {
				transform: translateX(calc(-1 * var(--sidebar-w)));
				box-shadow: var(--shadow-md);
			}

			.main-container.sidebar-open .sidebar-wrapper {
				transform: translateX(0);
			}

			.main-container.sidebar-open .mobile-overlay {
				display: block;
			}

			.topbar {
				left: 0;
				padding: 0 16px;
			}

			.main-content {
				margin-left: 0;
			}

			.topbar-welcome h4 {
				font-size: 15px;
				max-width: 140px;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}

			.user-trigger .user-meta {
				display: none;
			}
		}

		@media (min-width: 992px) {
			.mobile-overlay {
				display: none !important;
			}
		}

		/* @stack('styles') */
	</style>
	<style>
		.lms-banner {
			background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
			border-radius: 20px;
			padding: 2.5rem 2rem;
			box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.3);
		}

		.custom-filter-card {
			border-radius: 16px;
			border: none;
			box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
			background: #ffffff;
		}

		.form-control-custom {
			border: 1px solid #E2E8F0;
			border-radius: 10px;
			padding: 0.6rem 1rem;
			transition: all 0.3s ease;
		}

		.form-control-custom:focus {
			border-color: #4F46E5;
			box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
		}

		.btn-custom {
			border-radius: 10px;
			font-weight: 600;
			padding: 0.6rem 1.2rem;
			transition: all 0.2s;
		}

		.btn-custom:hover {
			transform: translateY(-1px);
		}

		.category-title {
			font-size: 1.25rem;
			font-weight: 700;
			color: #1E293B;
			background: #F1F5F9;
			padding: 6px 16px;
			border-radius: 30px;
		}

		/* ðŸ“± RESPONSIVE HORIZONTAL SCROLL UNTUK MOBILE (SMARTPHONE) */
		@media (max-width: 767.98px) {
			.horizontal-scroll-mobile {
				display: flex;
				flex-wrap: nowrap;
				overflow-x: auto;
				scroll-snap-type: x mandatory;
				padding-bottom: 15px;
				padding-left: 4px;
				margin-right: -15px;
				/* Trik agar scroll bisa mentok ke kanan layar */
				-webkit-overflow-scrolling: touch;
			}

			.horizontal-scroll-mobile::-webkit-scrollbar {
				height: 5px;
			}

			.horizontal-scroll-mobile::-webkit-scrollbar-thumb {
				background: #CBD5E1;
				border-radius: 10px;
			}

			.card-item-responsive {
				flex: 0 0 82%;
				/* Menampilkan 1 card penuh dan potongan card berikutnya sebagai petunjuk visual */
				scroll-snap-align: start;
				margin-right: 7px;
			}
		}

		/* ðŸ’» GRID UNTUK LAPTOP & DESKTOP */
		@media (min-width: 768px) {
			.card-item-responsive {
				margin-bottom: 30px;
			}
		}

		.course-card-upgrade {
			border: 1px solid #F1F5F9;
			border-radius: 16px;
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			overflow: hidden;
		}

		.course-card-upgrade:hover {
			transform: translateY(-6px);
			box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
			border-color: #E2E8F0;
		}

		.badge-premium {
			background: rgba(15, 23, 42, 0.75);
			backdrop-filter: blur(4px);
			color: #fff;
			padding: 5px 10px;
			border-radius: 8px;
			font-size: 11px;
			font-weight: 600;
		}

		/* Custom style tambahan untuk aura Gen Z & Clean look */
		.profile-banner {
			background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
			border-radius: 20px;
			position: relative;
			overflow: hidden;
		}

		.profile-avatar-wrapper {
			position: relative;
			margin-top: -60px;
		}

		.profile-avatar {
			width: 120px;
			height: 120px;
			border-radius: 30px;
			border: 5px solid #ffffff;
			object-fit: cover;
			box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
		}

		.glass-card:hover {
			transform: translateY(-2px);
		}

		.info-badge {
			background: #F1F5F9;
			color: #334155;
			font-weight: 600;
			font-size: 13px;
			padding: 6px 14px;
			border-radius: 12px;
			display: inline-block;
		}

		.wallet-card {
			background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%);
			color: #fff;
			border-radius: 20px;
		}

		.job-banner {
			background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
			border-radius: 20px;
			position: relative;
			overflow: hidden;
		}

		.glass-card {
			background: rgba(255, 255, 255, 0.85);
			backdrop-filter: blur(10px);
			border: 1px solid rgba(241, 245, 249, 1);
			border-radius: 20px;
			transition: all 0.3s ease;
		}

		.glass-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 30px -5px rgba(124, 58, 237, 0.1) !important;
		}

		.info-badge {
			background: #F1F5F9;
			color: #334155;
			font-weight: 600;
			font-size: 12px;
			padding: 6px 14px;
			border-radius: 12px;
			display: inline-block;
		}

		.coming-soon-overlay {
			position: relative;
		}

		.coming-soon-overlay::after {
			content: "COMING SOON ðŸš€";
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(255, 255, 255, 0.65);
			backdrop-filter: blur(4px);
			border-radius: 20px;
			display: flex;
			justify-content: center;
			align-items: center;
			font-size: 1.5rem;
			font-weight: 800;
			color: #4F46E5;
			letter-spacing: 2px;
			z-index: 2;
			text-shadow: 0 2px 10px rgba(255, 255, 255, 0.8);
			border: 2px dashed #7C3AED;
		}
	</style>
	<style>
		body {
			background-color: #f1f5f9 !important;
		}

		/* Media Player Responsiveness */
		.video-wrapper {
			position: relative;
			padding-bottom: 56.25%;
			height: 0;
			overflow: hidden;
			background: #000;
		}

		.video-wrapper iframe {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			border: 0;
		}

		.pdf-wrapper {
			width: 100%;
			height: 550px;
			max-height: 75vh;
			overflow: hidden;
		}

		/* Custom Utilities for Fluid Typography and Elements */
		.small-mobile-text {
			font-size: 0.95rem;
		}

		.dynamic-h5 {
			font-size: 1.15rem;
		}

		.btn-block-mobile {
			width: auto;
		}

		/* Playlist active class override */
		.playlist-active {
			background-color: #eff6ff !important;
			border-left: 4px solid #2563eb !important;
			font-weight: bold;
		}

		.playlist-item {
			border-left: 4px solid transparent;
			transition: all 0.2s ease;
		}

		.playlist-item:hover {
			background: #f1f5f9;
			text-decoration: none;
		}

		.style-media-link:hover {
			background-color: #f1f5f9;
			text-decoration: none;
		}

		/* Sticky Sidebar configuration for large screens */
		@media (min-width: 992px) {
			.sticky-sidebar {
				position: -webkit-sticky;
				position: sticky;
				top: 24px;
				z-index: 10;
			}

			.sidebar-content {
				max-height: 68vh;
				overflow-y: auto;
			}
		}

		/* Target Device Mobile & Small Screen (< 768px) */
		@media (max-width: 767.98px) {
			.small-mobile-text {
				font-size: 0.85rem !important;
			}

			.dynamic-h5 {
				font-size: 1rem !important;
			}

			.btn-block-mobile {
				width: 100% !important;
				margin-bottom: 0.5rem;
			}

			.pdf-wrapper {
				height: 380px !important;
			}

			.opsi-label {
				padding: 10px 12px !important;
			}
		}
	</style>
	<style>
		body {
			background-color: #f1f5f9 !important;
		}

		.report-container {
			max-width: 1000px;
			margin: 2rem auto;
			padding: 0 1rem;
		}

		/* Utility Gap Helper (Dukungan Bootstrap lama jika belum ada .gap-*) */
		.gap-2 {
			gap: 0.5rem;
		}

		/* Card Header Styling */
		.success-card {
			background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
			color: white;
			border-radius: 16px;
			padding: 2.5rem 1.5rem;
			text-align: center;
			box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
		}

		.failed-card {
			background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 100%);
			color: white;
			border-radius: 16px;
			padding: 2.5rem 1.5rem;
			text-align: center;
			box-shadow: 0 10px 25px -5px rgba(220, 38, 220, 0.3);
		}

		.pretest-card {
			background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
			color: white;
			border-radius: 16px;
			padding: 2.5rem 1.5rem;
			text-align: center;
			box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.3);
		}

		.score-badge {
			font-size: 3.5rem;
			font-weight: 800;
			background: rgba(255, 255, 255, 0.2);
			display: inline-block;
			padding: 0.5rem 2rem;
			border-radius: 12px;
			margin: 1rem 0;
		}

		/* Comparison Score Dashboard */
		.summary-box {
			background: #ffffff;
			border-radius: 12px;
			padding: 1.5rem;
			margin-top: 1.5rem;
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
		}

		.score-card-mini {
			background: #f8fafc;
			border: 1px solid #e2e8f0;
			border-radius: 10px;
			padding: 1.25rem;
			text-align: center;
		}

		/* Review Questions Styling */
		.review-card {
			background: #ffffff;
			border-radius: 12px;
			padding: 1.5rem;
			margin-top: 1.5rem;
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
		}

		.soal-box {
			border: 1px solid #e2e8f0;
			border-radius: 10px;
			padding: 20px;
			margin-bottom: 15px;
			background: #f8fafc;
		}

		.status-badge {
			display: inline-block;
			padding: 6px 14px;
			border-radius: 20px;
			font-size: 0.8rem;
			font-weight: bold;
			white-space: nowrap;
		}

		/* Preview Sertifikat Standard Base */
		.sertifikat-frame-preview {
			min-width: 650px;
			border-width: 2px !important;
		}

		.cert-title {
			font-size: 1.8rem;
		}

		.cert-desc {
			font-size: 0.85rem;
		}

		.cert-text-body {
			font-size: 0.9rem;
		}

		.cert-materi {
			font-size: 1.3rem;
		}

		.cert-meta {
			font-size: 0.85rem;
		}

		/* Media Query khusus untuk Perangkat Mobile */
		@media (max-width: 576px) {
			.report-container {
				margin: 0;
				padding: 0;
			}

			.title-responsive {
				font-size: 1.4rem !important;
			}

			.desc-responsive {
				font-size: 0.95rem !important;
			}

			.score-badge {
				font-size: 2.5rem;
				padding: 0.3rem 1.5rem;
			}

			.icon-header {
				font-size: 3rem !important;
			}

			.w-sm-100 {
				width: 100% !important;
				margin-left: 0 !important;
				margin-right: 0 !important;
			}

			.h5-sm {
				font-size: 1.15rem !important;
			}

			.soal-box {
				padding: 15px;
			}

			/* Mengamankan Sertifikat agar tidak merusak layout screen utama */
			.sertifikat-scroll-wrapper {
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
				justify-content: flex-start !important;
			}

			.sertifikat-frame-preview {
				min-width: 600px;
			}

			.cert-title {
				font-size: 1.5rem;
			}

			.cert-name {
				font-size: 1.3rem !important;
				min-width: 200px !important;
			}
		}
	</style>
	<!-- Tambahan Style khusus untuk mempercantik UI Kuis & Playlist di Mobile -->
	<style>
		.gap-2 {
			gap: 0.5rem;
		}

		.border-left-primary {
			border-left: 4px solid #4361ee !important;
		}

		.opsi-label:hover {
			background-color: #f1f5f9 !important;
			border-color: #cbd5e1 !important;
		}

		.opsi-label input[type="radio"]:checked+.opsi-text {
			font-weight: bold;
			color: #4361ee !important;
		}

		@media (max-width: 575.98px) {
			.btn-md-inline {
				width: 100% !important;
			}

			.pdf-wrapper {
				height: 350px !important;
			}
		}
	</style>

	<style>
		.border-left-primary {
			border-left: 4px solid #4e73df !important;
		}

		.hover-bg-light:hover {
			background-color: #f1f5f9;
			color: #1e293b !important;
		}

		.transition-all {
			transition: all 0.2s ease-in-out;
		}

		.item-link-media {
			border: 1px solid transparent;
		}

		.item-link-media:not(.bg-primary):hover {
			border-color: #e2e8f0;
		}
	</style>
	<style>
		.hover-bg-light:hover {
			background-color: #f1f5f9;
			color: #1e293b !important;
		}

		.transition-all {
			transition: all 0.2s ease-in-out;
		}

		@keyframes bounce {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-8px);
			}
		}

		.animate-bounce {
			animation: bounce 2s infinite;
		}
	</style>
	<!-- Custom Styles Khusus untuk Halaman Ini -->
	<style>
		.lms-banner-gradient {
			background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
			border-radius: 16px;
			box-shadow: 0 4px 20px rgba(79, 70, 229, 0.15);
		}

		.course-card {
			border: 1px solid #E5E7EB;
			border-radius: 16px;
			overflow: hidden;
			transition: all 0.3s ease;
			background: #ffffff;
		}

		.course-card:hover {
			transform: translateY(-6px);
			box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
			border-color: #D1D5DB;
		}

		.thumbnail-placeholder {
			height: 160px;
			background: linear-gradient(135deg, #EEF2F6 0%, #E3E8EF 100%);
			position: relative;
			overflow: hidden;
		}

		/* Custom Styling untuk membuat tampilan Card Premium */
		.course-card {
			border: none;
			border-radius: 16px;
			overflow: hidden;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
		}

		.course-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
		}

		.thumbnail-container {
			position: relative;
			height: 180px;
			background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
			overflow: hidden;
		}

		/* Pola abstrak untuk background thumbnail default agar terlihat keren */
		.thumbnail-pattern {
			position: absolute;
			width: 100%;
			height: 100%;
			opacity: 0.15;
			background-image: radial-gradient(circle at 100% 150%, #fff 24%, white 25%, white 28%, #fff 29%, #fff 36%, white 36%, white 40%, transparent 40%),
				radial-gradient(circle at 0 150%, #fff 24%, white 25%, white 28%, #fff 29%, #fff 36%, white 36%, white 40%, transparent 40%),
				radial-gradient(circle at 50% 100%, #fff 10%, white 11%, white 14%, #fff 14%, #fff 20%, white 20%, white 24%, transparent 24%);
			background-size: 40px 40px;
		}

		.sertifikat-frame-preview {
			width: 100%;
			max-width: 750px;
			border: 8px double #1e3a8a !important;
			background-color: #fff;
		}

		.sertifikat-border {
			border: 2px solid #b45309;
			padding: 15px;
		}

		.sertifikat-content {
			background-image: radial-gradient(circle, #fefefb 0%, #fbf9f1 100%);
		}

		.thumbnail-icon {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			color: rgba(255, 255, 255, 0.9);
			font-size: 3.5rem;
			filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
		}

		.price-badge {
			position: absolute;
			bottom: 12px;
			right: 12px;
			background-color: rgba(15, 23, 42, 0.85);
			backdrop-filter: blur(4px);
			color: #fff;
			padding: 4px 12px;
			border-radius: 20px;
			font-weight: 700;
			font-size: 0.85rem;
		}

		.category-badge {
			background-color: #EEF2FF;
			color: #4F46E5;
			padding: 6px 16px;
			border-radius: 30px;
			font-weight: 600;
			font-size: 0.9rem;
		}

		/* Membuat variasi warna random abstrak untuk icon thumbnail agar kreatif */
		.course-card:nth-child(3n+1) .thumbnail-icon {
			color: #4F46E5;
			background: rgba(79, 70, 229, 0.1);
		}

		.course-card:nth-child(3n+2) .thumbnail-icon {
			color: #0EA5E9;
			background: rgba(14, 165, 233, 0.1);
		}

		.course-card:nth-child(3n+3) .thumbnail-icon {
			color: #10B981;
			background: rgba(16, 185, 129, 0.1);
		}

		.thumbnail-icon {
			width: 60px;
			height: 60px;
			border-radius: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 24px;
		}

		.category-badge {
			background-color: #F3F4F6;
			color: #374151;
			padding: 6px 16px;
			border-radius: 30px;
			font-weight: 600;
			font-size: 14px;
		}
	</style>
	<style>
		/* Tambahan style mikro agar UI terlihat jauh lebih elegan */
		.spec-table th {
			background-color: #f8f9fa;
			color: #515365;
			font-weight: 700;
			border-top: none !important;
		}

		.spec-table td {
			vertical-align: middle !important;
		}

		.text-hover-underline:hover {
			text-decoration: underline !important;
		}

		.custom-control-input:checked~.custom-control-label::before {
			background-color: #4361ee;
			border-color: #4361ee;
		}
	</style>
</head>
