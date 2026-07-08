<style>
    #sidebar {
        min-width: 260px;
        max-width: 260px;
        background: #0f172a; /* Dark Blue Slate */
        color: #fff;
        transition: all 0.3s;
    }
    #sidebar .sidebar-header {
        padding: 20px;
        background: #1e293b;
    }
    #sidebar ul.components {
        padding: 20px 0;
    }
    #sidebar ul li a {
        padding: 12px 20px;
        font-size: 1.1em;
        display: block;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s;
    }
    #sidebar ul li a:hover {
        color: #fff;
        background: #1e40af; /* Royal Blue */
        border-left: 4px solid #3b82f6;
    }
    #sidebar ul li.active > a {
        color: #fff;
        background: #2563eb;
        border-left: 4px solid #60a5fa;
    }
    #sidebar ul li a i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
</style>

<nav id="sidebar">
    <div class="sidebar-header d-flex align-items-center justify-content-center">
        <i class="fa-solid fa-chart-line fa-lg me-2 text-primary"></i>
        <h4 class="m-0 fw-bold text-white">Blue<span class="text-primary">Admin</span></h4>
    </div>

    <ul class="list-unstyled components">
        <p class="text-muted px-4 mb-2"><small>CORE</small></p>
        <li class="active">
            <a href="#"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        </li>
        
        <p class="text-muted px-4 mb-2 mt-3"><small>MANAGEMENT</small></p>
        <li>
            <a href="#"><i class="fa-solid fa-users"></i> Pengguna</a>
        </li>
        <li>
            <a href="#"><i class="fa-solid fa-box"></i> Produk</a>
        </li>
        <li>
            <a href="#"><i class="fa-solid fa-cart-shopping"></i> Transaksi</a>
        </li>

        <p class="text-muted px-4 mb-2 mt-3"><small>SETTINGS</small></p>
        <li>
            <a href="#"><i class="fa-solid fa-gear"></i> Pengaturan</a>
        </li>
        <li>
            <a href="#" class="text-danger-hover"><i class="fa-solid fa-right-from-bracket text-danger"></i> Keluar</a>
        </li>
    </ul>
</nav>