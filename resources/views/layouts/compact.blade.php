<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') - Bankir Academy</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />

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

        * { box-sizing: border-box; }

        html, body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14.5px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; }
        a:hover { text-decoration: none; }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #D7DAE3; border-radius: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }

        /* Keyboard focus visibility */
        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            * { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }

        /* ============================================================
           TOPBAR
           ============================================================ */
        .topbar {
            position: fixed;
            top: 0; left: var(--sidebar-w); right: 0;
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

        .main-container.sidebar-closed .topbar { left: 0; }

        .topbar-left { display: flex; align-items: center; gap: 16px; }

        .sidebar-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px; height: 38px;
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }
        .sidebar-toggle:hover { background: var(--primary-soft); color: var(--primary); }

        .topbar-welcome { display: flex; flex-direction: column; }
        .topbar-welcome .eyebrow {
            font-size: 11px; font-weight: 600; letter-spacing: .06em;
            text-transform: uppercase; color: var(--text-muted); margin: 0;
        }
        .topbar-welcome h4 {
            margin: 0; font-size: 17px; font-weight: 700; color: var(--text);
        }

        .topbar-right { display: flex; align-items: center; gap: 18px; }

        .user-trigger {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 10px 6px 6px;
            border-radius: 999px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: border-color .15s ease, background .15s ease;
        }
        .user-trigger:hover { background: var(--bg); border-color: var(--border); }

        .user-trigger img {
            width: 36px; height: 36px; border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-soft);
        }

        .user-trigger .user-meta { text-align: left; line-height: 1.2; }
        .user-trigger .user-meta .name { font-size: 13.5px; font-weight: 600; color: var(--text); }
        .user-trigger .user-meta .role { font-size: 11.5px; color: var(--text-muted); }

        .user-trigger .chevron { color: var(--text-muted); font-size: 11px; margin-left: 2px; }

        .dropdown-menu.user-dropdown {
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            padding: 8px;
            min-width: 240px;
        }

        .user-dropdown .dropdown-header-block {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 10px 14px 10px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 6px;
        }
        .user-dropdown .dropdown-header-block img {
            width: 44px; height: 44px; border-radius: 50%; object-fit: cover;
        }
        .user-dropdown .dropdown-header-block h6 { margin: 0; font-size: 14px; font-weight: 700; }
        .user-dropdown .dropdown-header-block span { font-size: 12px; color: var(--text-muted); }

        .user-dropdown .menu-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            color: var(--text);
            font-size: 13.5px;
            font-weight: 500;
            transition: background .15s ease;
        }
        .user-dropdown .menu-item:hover { background: var(--primary-soft); color: var(--primary); }
        .user-dropdown .menu-item svg, .user-dropdown .menu-item i { width: 18px; color: inherit; }

        .user-dropdown .menu-item.logout-item {
            color: var(--danger);
            margin-top: 4px;
            border-top: 1px solid var(--border);
            padding-top: 12px;
            border-radius: 0;
        }
        .user-dropdown .menu-item.logout-item:hover { background: #FDECEC; color: var(--danger); }

        /* ============================================================
           SIDEBAR
           ============================================================ */
        .sidebar-wrapper {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
        }
        .main-container.sidebar-closed .sidebar-wrapper { transform: translateX(calc(-1 * var(--sidebar-w))); }

        .sidebar-brand {
            height: var(--topbar-h);
            display: flex; align-items: center; gap: 12px;
            padding: 0 22px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }
        .sidebar-brand img { width: 36px; height: 36px; border-radius: 10px; object-fit: cover; }
        .sidebar-brand span { font-size: 16px; font-weight: 800; color: var(--text); letter-spacing: -.01em; }

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
        .nav-section-label:first-child { margin-top: 0; }

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
            display: flex; align-items: center; justify-content: center;
            width: 20px; height: 20px;
            flex-shrink: 0;
        }

        .nav-item-link:hover { background: var(--bg); color: var(--text); }

        .nav-item-link.active {
            background: var(--primary-soft);
            color: var(--primary);
            font-weight: 600;
        }
        .nav-item-link.active::before {
            content: "";
            position: absolute;
            left: -14px; top: 8px; bottom: 8px;
            width: 4px;
            border-radius: 0 4px 4px 0;
            background: var(--primary);
        }

        .nav-item-link .chevron-icon {
            margin-left: auto;
            transition: transform .2s ease;
            color: #A3A8B8;
        }
        .menu.submenu-open > .nav-item-link .chevron-icon { transform: rotate(-90deg); color: var(--primary); }

        .submenu-panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height .25s ease;
            padding-left: 18px;
        }
        .menu.submenu-open .submenu-panel { max-height: 400px; }

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
        .sidebar-footer .help-card p { font-size: 12.5px; opacity: .9; margin: 4px 0 10px; }
        .sidebar-footer .help-card a {
            display: inline-block;
            background: rgba(255,255,255,.18);
            color: #fff;
            font-size: 12.5px;
            font-weight: 600;
            padding: 7px 12px;
            border-radius: 8px;
            transition: background .15s ease;
        }
        .sidebar-footer .help-card a:hover { background: rgba(255,255,255,.3); }

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
        .main-container.sidebar-closed .main-content { margin-left: 0; }

        .content-body { padding: 28px; flex: 1; }

        .page-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 28px;
            border-top: 1px solid var(--border);
            font-size: 12.5px;
            color: var(--text-muted);
        }
        .page-footer a { color: var(--primary); font-weight: 600; }

        /* ============================================================
           SHARED CONTENT PRIMITIVES (available to @yield('content'))
           ============================================================ */
        .card-surface {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        table.dataTable thead th { color: var(--text-muted); font-weight: 600; font-size: 12.5px; text-transform: uppercase; letter-spacing: .03em; }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 991px) {
            .sidebar-wrapper { transform: translateX(calc(-1 * var(--sidebar-w))); box-shadow: var(--shadow-md); }
            .main-container.sidebar-open .sidebar-wrapper { transform: translateX(0); }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .topbar-welcome h4 { font-size: 15px; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .user-trigger .user-meta { display: none; }
        }

        .mobile-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(15, 17, 26, .45);
            z-index: 1035;
        }
        .main-container.sidebar-open .mobile-overlay { display: block; }
        @media (min-width: 992px) { .mobile-overlay { display: none !important; } }

        /* @stack('styles') */
    </style>
    <style>
    /* Mengikuti design token layout admin: --primary #4F46E5, --primary-soft #EEF0FE,
       --border #E7E9F0, --radius-lg 16px, --radius-md 12px, --shadow-sm/--shadow-md */

    .lms-banner {
        background: linear-gradient(135deg, #4F46E5 0%, #6C63FF 100%);
        border-radius: 16px;
        color: white;
        padding: 50px 30px;
        box-shadow: 0 4px 16px rgba(79, 70, 229, 0.18);
    }

    .category-badge {
        background: #EEF0FE;
        color: #4F46E5;
        font-weight: 700;
        font-size: 13px;
        padding: 6px 16px;
        border-radius: 20px;
        display: inline-block;
    }

    .course-card {
        border: 1px solid #E7E9F0;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
    }

    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px -6px rgba(16, 24, 40, 0.12);
        border-color: #C7C2FB;
    }

    .course-card .card-title {
        color: #1B1F2A;
    }

    .course-card .text-muted {
        color: #6B7280 !important;
    }

    .btn-primary {
        background-color: #4F46E5;
        border-color: #4F46E5;
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: #3D33D8;
        border-color: #3D33D8;
    }

    .btn-info {
        background-color: #06B6D4;
        border-color: #06B6D4;
    }
    .btn-info:hover, .btn-info:focus {
        background-color: #0891A8;
        border-color: #0891A8;
    }

    .empty-state-card {
        border: 1px solid #E7E9F0 !important;
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05) !important;
    }

    /* Mengantisipasi jarak tombol jika menggunakan Bootstrap 4 yang belum ada fitur gap */
    .button-group-responsive > a, .button-group-responsive > button {
        margin-left: 4px;
    }
    @media (max-width: 575.98px) {
        .button-group-responsive {
            flex-direction: column;
            width: 100%;
            margin-top: 8px;
        }
        .button-group-responsive > a, .button-group-responsive > button {
            margin-left: 0;
            margin-top: 4px;
            width: 100%;
            text-align: center;
        }
    }
</style>
<style>
    body { background-color: #f1f5f9 !important; } 
    .classroom-container { display: flex; min-height: calc(100vh - 65px); color: #334155; }
    .player-area { flex: 3; padding: 2rem; background: #f1f5f9; overflow-y: auto; }
    .sidebar-area { flex: 1; min-width: 360px; max-width: 420px; background: #ffffff; border-left: 1px solid #e2e8f0; display: flex; flex-direction: column; box-shadow: -2px 0 10px rgba(0,0,0,0.02); }
    
    @media (max-width: 991px) {
        .classroom-container { flex-direction: column; }
        .sidebar-area { max-width: 100%; min-width: 100%; border-left: none; border-top: 1px solid #e2e8f0; max-height: 50vh; }
    }

    .media-holder { background: #ffffff; border-radius: 12px; padding: 10px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.08); margin-bottom: 1.5rem; }
    .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px; background: #000; }
    .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
    .pdf-wrapper { width: 100%; height: 650px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }

    .materi-info-card { background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .sidebar-header { padding: 1.5rem; border-bottom: 1px solid #e2e8f0; background: #ffffff; }
    .sidebar-content { overflow-y: auto; flex-grow: 1; }
    .kurikulum-title { background: #f8fafc; color: #64748b; padding: 12px 20px; font-size: 0.8rem; letter-spacing: 1px; font-weight: 700; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }

    .playlist-item { display: flex; align-items: center; padding: 18px 20px; color: #475569; border-bottom: 1px solid #f1f5f9; text-decoration: none; transition: all 0.2s ease; border-left: 4px solid transparent; }
    .playlist-item:hover { background: #f1f5f9; color: #1e3a8a; text-decoration: none; }
    .playlist-item.active { background: #eff6ff; color: #1e40af; font-weight: 600; border-left-color: #2563eb; }
    
    .soal-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 20px; background: #f8fafc; }
    .opsi-label { display: block; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px 16px; margin-bottom: 10px; cursor: pointer; transition: all 0.2s; }
    .opsi-label:hover { background: #f1f5f9; border-color: #94a3b8; }
    .opsi-radio:checked + .opsi-text { font-weight: bold; color: #2563eb; }
    .opsi-radio { margin-right: 10px; }
</style>
<style>
    body { background-color: #f1f5f9 !important; }
    .report-container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
    
    /* Card Header Styling */
    .success-card { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3); }
    .failed-card { background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 100%); color: white; border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(220, 38, 220, 0.3); }
    .pretest-card { background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%); color: white; border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.3); }
    
    .score-badge { font-size: 3.5rem; font-weight: 800; background: rgba(255,255,255,0.2); display: inline-block; padding: 0.5rem 2rem; border-radius: 12px; margin: 1rem 0; }
    
    /* Comparison Score Dashboard */
    .summary-box { background: #ffffff; border-radius: 12px; padding: 1.5rem; margin-top: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .score-card-mini { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.25rem; text-align: center; }
    
    /* Review Questions Styling */
    .review-card { background: #ffffff; border-radius: 12px; padding: 1.5rem; margin-top: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .soal-box { border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 15px; background: #f8fafc; position: relative; }
    .status-badge { float: right; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }
</style>
<!-- Tambahan Style khusus untuk mempercantik UI Kuis & Playlist di Mobile -->
<style>
    .gap-2 { gap: 0.5rem; }
    .border-left-primary { border-left: 4px solid #4361ee !important; }
    .opsi-label:hover {
        background-color: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
    }
    .opsi-label input[type="radio"]:checked + .opsi-text {
        font-weight: bold;
        color: #4361ee !important;
    }
    @media (max-width: 575.98px) {
        .btn-md-inline { width: 100% !important; }
        .pdf-wrapper { height: 350px !important; }
    }
</style>

<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .hover-bg-light:hover { background-color: #f1f5f9; color: #1e293b !important; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .item-link-media { border: 1px solid transparent; }
    .item-link-media:not(.bg-primary):hover { border-color: #e2e8f0; }
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
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
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
    /* Membuat variasi warna random abstrak untuk icon thumbnail agar kreatif */
    .course-card:nth-child(3n+1) .thumbnail-icon { color: #4F46E5; background: rgba(79, 70, 229, 0.1); }
    .course-card:nth-child(3n+2) .thumbnail-icon { color: #0EA5E9; background: rgba(14, 165, 233, 0.1); }
    .course-card:nth-child(3n+3) .thumbnail-icon { color: #10B981; background: rgba(16, 185, 129, 0.1); }

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
                'icon' => 'home',
                'url' => '/home',
                'active' => request()->is('home'),
                'can_see' => true,
                'has_submenu' => false,
            ],
            [
                'label' => 'Pre Post Test',
                'icon' => 'zap',
                'url' => '#dashboard',
                'active' => request()->is('kategori-materi*', 'materi*', 'sub-materi*', 'ppt*'),
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
                'icon' => 'cpu',
                'url' => '/pelatihan',
                'active' => request()->routeIs('siswa.materi.*') && !request()->is('*report*'),
                'can_see' => ($role == 6),
                'has_submenu' => false,
            ],
            [
                'label' => 'Pelatihan Umum',
                'icon' => 'cpu',
                'url' => '/materi-umum',
                'active' => request()->routeIs('siswa.umum.index*') && !request()->is('*report*'),
                'can_see' => ($role == 6),
                'has_submenu' => false,
            ],
            [
                'label' => 'History Pelatihan',
                'icon' => 'cpu',
                'url' => '/materi-umum/history',
                'active' => request()->routeIs('siswa.umum.history*'),
                'can_see' => ($role == 6),
                'has_submenu' => false,
            ],
            [
                'label' => 'Sertifikat',
                'icon' => 'cpu',
                'url' => '/materi-umum',
                'active' => request()->routeIs('siswa.umum.*') && !request()->is('*report*'),
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
                'icon' => 'zap',
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
            'home' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
            'zap' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
            'cpu' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>',
            'bar-chart-2' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>',
        ];
    @endphp

    <div class="main-container" id="container">

        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- SIDEBAR -->
        <div class="sidebar-wrapper">
            <div class="sidebar-brand">
                <img src="{{ asset('assets/img/90x90.jpg') }}" alt="logo">
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
                                    <svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                </a>
                                <div class="submenu-panel" id="{{ $menu['submenu_id'] }}">
                                    <a class="sub-link {{ request()->is('kategori-materi*') ? 'active' : '' }}" href="/kategori-materi">Bidang</a>
                                    <a class="sub-link {{ request()->is('materi*') ? 'active' : '' }}" href="/materi">Kompetensi</a>
                                    <a class="sub-link {{ request()->is('sub-materi*') ? 'active' : '' }}" href="/sub-materi">Materi</a>
                                    <a class="sub-link {{ request()->is('ppt*') ? 'active' : '' }}" href="/ppt">PPT</a>
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
                <a href="javascript:void(0);" class="sidebar-toggle" id="sidebarToggle" aria-label="Buka atau tutup menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
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
                        <svg class="chevron" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userProfileDropdown">
                        <div class="dropdown-header-block">
                            <img src="{{ asset('assets/img/90x90.jpg') }}" alt="avatar">
                            <div>
                                <h6>{{ auth()->user()->name }}</h6>
                                <span>{{ auth()->user()->role_name }}</span>
                            </div>
                        </div>

                        <a href="{{ url('user_profile') }}" class="menu-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>Profil Saya</span>
                        </a>

                        <a href="{{ route('logout') }}" class="menu-item logout-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
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

    <!-- GLOBAL SCRIPTS -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
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

    @stack('scripts')
</body>

</html>