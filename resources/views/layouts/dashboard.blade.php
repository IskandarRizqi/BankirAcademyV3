@extends('layouts.master')

@section('title', 'Dashboard Utama')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="fw-bold text-dark m-0">Ringkasan Analitik</h2>
        <p class="text-muted">Selamat datang kembali, Admin! Berikut adalah performa hari ini.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted fw-normal">Total Pendapatan</h6>
                    <h3 class="fw-bold mb-0">Rp 24.500.000</h3>
                    <span class="text-success small fw-semibold"><i class="fa-solid fa-arrow-up"></i> +12% bln ini</span>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                    <i class="fa-solid fa-wallet fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #3b82f6 !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted fw-normal">Pesanan Baru</h6>
                    <h3 class="fw-bold mb-0">1,420</h3>
                    <span class="text-success small fw-semibold"><i class="fa-solid fa-arrow-up"></i> +8% hari ini</span>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-3 text-info">
                    <i class="fa-solid fa-cart-shopping fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #60a5fa !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted fw-normal">Pengguna Baru</h6>
                    <h3 class="fw-bold mb-0">382</h3>
                    <span class="text-danger small fw-semibold"><i class="fa-solid fa-arrow-down"></i> -2% mggu ini</span>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                    <i class="fa-solid fa-users fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #1e40af !important;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted fw-normal">Tingkat Konversi</h6>
                    <h3 class="fw-bold mb-0">4.83%</h3>
                    <span class="text-success small fw-semibold"><i class="fa-solid fa-arrow-up"></i> +0.5%</span>
                </div>
                <div class="bg-dark bg-opacity-10 p-3 rounded-3 text-dark">
                    <i class="fa-solid fa-chart-pie fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom-0">
                <h5 class="m-0 fw-bold text-dark">Transaksi Terbaru</h5>
                <button class="btn btn-sm btn-primary"><i class="fa-solid fa-download me-1"></i> Ekspor Laporan</button>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>ID Order</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-blue">#TRX-9821</td>
                            <td>Ahmad Dhani</td>
                            <td>Hosting Cloud Premium</td>
                            <td>18 Jun 2026</td>
                            <td>Rp 450.000</td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1.5">Sukses</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-blue">#TRX-9820</td>
                            <td>Siti Nurbaya</td>
                            <td>Domain .com (1 Tahun)</td>
                            <td>18 Jun 2026</td>
                            <td>Rp 165.000</td>
                            <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1.5">Pending</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-blue">#TRX-9819</td>
                            <td>Budi Utomo</td>
                            <td>Sertifikat SSL Wildcard</td>
                            <td>17 Jun 2026</td>
                            <td>Rp 1.200.000</td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1.5">Sukses</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-blue">#TRX-9818</td>
                            <td>Clara Anastasia</td>
                            <td>VPS Enterprise G3</td>
                            <td>17 Jun 2026</td>
                            <td>Rp 850.000</td>
                            <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1.5">Gagal</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection