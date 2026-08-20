@extends('layouts.appmembernonanggota')
@section('content')
    <style>
        .member-dashboard-grid {
            row-gap: 24px;
        }

        .dashboard-card-column {
            display: flex;
        }
    </style>

    <div class="row member-dashboard-grid" id="cancel-row">
        {{-- Card 1: Membership Status (Sesuai Komponen Asli Anda) --}}
        <div class="col-lg-6 col-12 layout-top-spacing layout-spacing dashboard-card-column">
            @include('membernonkeanggotaan.components.ui.membership-status')
        </div>

        {{-- Card 2: Ringkasan Akses Produk --}}
        <div class="col-lg-6 col-12 layout-top-spacing layout-spacing dashboard-card-column">
            @include('membernonkeanggotaan.components.ui.product-overview-card', [
                'totalClasses' => $totalClasses,
                'totalEbooks' => $totalEbooks,
                'totalVideos' => $totalVideos,
            ])
        </div>

        {{-- Card 3: Grafik Distribusi Status Pembayaran --}}
        <div class="col-lg-5 col-12 layout-top-spacing layout-spacing dashboard-card-column">
            @include('membernonkeanggotaan.components.ui.payment-chart-card', ['stats' => $paymentStats])
        </div>

        {{-- Card 4: Riwayat Transaksi Terbaru --}}
        <div class="col-lg-7 col-12 layout-top-spacing layout-spacing dashboard-card-column">
            @include('membernonkeanggotaan.components.ui.recent-payments-card', [
                'payments' => $recentPayments,
            ])
        </div>
    </div>
@endsection
