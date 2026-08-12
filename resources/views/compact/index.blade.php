@extends('layouts.compact')

@section('content')
    <div class="container-fluid px-2 px-md-4 mt-4" id="cancel-row">
        {{-- ================= HEADERS SECTION ================= --}}
        <div class="row mb-4 align-items-center">
            <div class="col-md-8 mb-3 mb-md-0">
                <h1 class="font-weight-bold text-dark h3 mb-1">
                    @if (\App\Support\AdminPanel::canAccess(auth()->user()))
                        Panel Kendali Sistem Root
                    @elseif(auth()->user()->role == 4)
                        Dashboard Performa Bank
                    @elseif(auth()->user()->role == 5)
                        Konsol Manajemen Merchant
                    @else
                        Dashboard Pelatihan Anda
                    @endif
                </h1>
                <p class="text-muted mb-0">
                    @if (\App\Support\AdminPanel::canAccess(auth()->user()))
                        Ringkasan kondisi platform, aktivitas pengguna, konten, dan operasional Bankir Academy.
                    @elseif(auth()->user()->role == 6)
                        Pantau terus perkembangan belajar dan bab materi yang telah Anda buka.
                    @else
                        Kelola data enkapsulasi entitas Anda secara terpusat di sini.
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-md-right">
                @if (auth()->user()->role == 6)
                    <a href="{{ route('siswa.umum.index') }}" class="btn btn-primary px-4 py-2.5 font-weight-bold shadow-sm"
                        style="border-radius: 10px; gap: 8px;">
                        <i class="fas fa-search mr-2"></i> Jelajahi Materi Baru
                    </a>
                @endif
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- 1. INTERFACE FOR ROOT                                                     --}}
        {{-- ========================================================================= --}}
        @if (\App\Support\AdminPanel::canAccess(auth()->user()))
            <style>
                .root-dashboard .root-hero {
                    background: linear-gradient(115deg, #172554 0%, #1e40af 55%, #2563eb 100%);
                    border-radius: 20px;
                    overflow: hidden;
                    position: relative;
                }

                .root-dashboard .root-hero:after {
                    background: rgba(255, 255, 255, .08);
                    border-radius: 50%;
                    content: '';
                    height: 260px;
                    position: absolute;
                    right: -90px;
                    top: -125px;
                    width: 260px;
                }

                .root-dashboard .metric-card,
                .root-dashboard .section-card {
                    background: #fff;
                    border: 0;
                    border-radius: 16px;
                    box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
                }

                .root-dashboard .metric-card {
                    min-height: 132px;
                }

                .root-dashboard .metric-icon {
                    align-items: center;
                    border-radius: 12px;
                    display: flex;
                    height: 44px;
                    justify-content: center;
                    width: 44px;
                }

                .root-dashboard .section-title {
                    font-size: 1rem;
                    font-weight: 800;
                }

                .root-dashboard .section-subtitle {
                    font-size: .78rem;
                }

                .root-dashboard .quick-link {
                    align-items: center;
                    background: #f8fafc;
                    border: 1px solid #e2e8f0;
                    border-radius: 12px;
                    color: #1e293b;
                    display: flex;
                    font-size: .78rem;
                    font-weight: 700;
                    min-height: 72px;
                    padding: 12px;
                    transition: .2s ease;
                }

                .root-dashboard .quick-link:hover {
                    background: #eff6ff;
                    border-color: #93c5fd;
                    color: #1d4ed8;
                    text-decoration: none;
                    transform: translateY(-2px);
                }

                .root-dashboard .quick-link i {
                    font-size: 1.1rem;
                    margin-right: 9px;
                    width: 20px;
                }

                .root-dashboard .progress {
                    background: #eef2f7;
                    border-radius: 20px;
                    height: 7px;
                }

                .root-dashboard .progress-bar {
                    border-radius: 20px;
                }

                .root-dashboard .table td,
                .root-dashboard .table th {
                    vertical-align: middle;
                }

                .root-dashboard .table thead th {
                    border-top: 0;
                    color: #94a3b8;
                    font-size: .68rem;
                    letter-spacing: .05em;
                    text-transform: uppercase;
                }

                .root-dashboard .table tbody td {
                    border-color: #f1f5f9;
                    font-size: .82rem;
                }

                .root-dashboard .status-dot {
                    border-radius: 50%;
                    display: inline-block;
                    height: 8px;
                    margin-right: 5px;
                    width: 8px;
                }

                @media (max-width: 575.98px) {
                    .root-dashboard .root-hero h2 {
                        font-size: 1.35rem;
                    }

                    .root-dashboard .root-hero p {
                        font-size: .78rem;
                    }
                }
            </style>

            <div class="root-dashboard">
                <div class="root-hero text-white mb-4">
                    <div class="p-4 p-md-5 position-relative" style="z-index: 1;">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <span class="badge badge-light text-primary px-3 py-2 mb-3"
                                    style="border-radius: 30px; font-size: .68rem; letter-spacing: .08em;">ROOT SYSTEM
                                    OVERVIEW</span>
                                <h2 class="font-weight-bold mb-2">Pusat kendali Bankir Academy</h2>
                                <p class="text-white-50 mb-0">Pantau pertumbuhan ekosistem, kesiapan konten, transaksi, dan
                                    aktivitas platform dari satu tempat.</p>
                            </div>
                            <div class="col-lg-4 text-lg-right mt-4 mt-lg-0">
                                <div class="small text-white-50 mb-1">Pembaruan terakhir</div>
                                <div class="font-weight-bold"><i class="far fa-clock mr-1"></i>
                                    {{ now()->format('d M Y, H:i') }} WIB</div>
                                <div class="small text-white-50 mt-2"><span class="status-dot bg-success"></span>Data
                                    dashboard tersinkron saat halaman dibuka</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="metric-card p-4 h-100">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-2">Bank mitra</div>
                                    <div class="h3 font-weight-bold text-dark mb-1">{{ number_format($total_bank) }}</div>
                                    <div class="small text-success"><i class="fas fa-network-wired mr-1"></i> Entitas
                                        operasional</div>
                                </div>
                                <div class="metric-icon" style="background: #dbeafe; color: #2563eb;"><i
                                        class="fas fa-university"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="metric-card p-4 h-100">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-2">Merchant / sekolah
                                    </div>
                                    <div class="h3 font-weight-bold text-dark mb-1">{{ number_format($total_sekolah) }}
                                    </div>
                                    <div class="small text-success"><i class="fas fa-check-circle mr-1"></i> Mitra terdaftar
                                    </div>
                                </div>
                                <div class="metric-icon" style="background: #d1fae5; color: #059669;"><i
                                        class="fas fa-school"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="metric-card p-4 h-100">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-2">Peserta</div>
                                    <div class="h3 font-weight-bold text-dark mb-1">{{ number_format($total_siswa) }}</div>
                                    <div class="small text-primary"><i class="fas fa-user-check mr-1"></i>
                                        {{ number_format($active_users) }} akun aktif</div>
                                </div>
                                <div class="metric-icon" style="background: #fef3c7; color: #d97706;"><i
                                        class="fas fa-users"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="metric-card p-4 h-100">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-2">Kelas aktif</div>
                                    <div class="h3 font-weight-bold text-dark mb-1">{{ number_format($active_kelas) }}</div>
                                    <div class="small text-muted">dari {{ number_format($total_kelas) }} total kelas</div>
                                </div>
                                <div class="metric-icon" style="background: #ede9fe; color: #7c3aed;"><i
                                        class="fas fa-chalkboard-teacher"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <div class="section-card p-4 h-100" style="border-left: 4px solid #2563eb;">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div>
                                    <span class="badge badge-primary px-2 py-1 mb-2"
                                        style="font-size: .66rem; border-radius: 5px;">SKEMA 01</span>
                                    <h5 class="section-title mb-1">Calon Bankir</h5>
                                    <div class="section-subtitle text-muted">Bank membina sekolah dan peserta menuju karier
                                        perbankan.</div>
                                </div>
                                <div class="metric-icon" style="background: #dbeafe; color: #2563eb;"><i
                                        class="fas fa-user-graduate"></i></div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="small text-muted">Bank mitra</div>
                                    <div class="h4 font-weight-bold text-dark mb-0">{{ number_format($total_bank) }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="small text-muted">Sekolah / merchant</div>
                                    <div class="h4 font-weight-bold text-dark mb-0">{{ number_format($total_sekolah) }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Peserta</div>
                                    <div class="h4 font-weight-bold text-dark mb-0">{{ number_format($total_siswa) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Menunggu approval beasiswa</div>
                                    <div class="h4 font-weight-bold text-warning mb-0">
                                        {{ number_format($pending_beasiswa) }}</div>
                                </div>
                            </div>
                            <a href="{{ route('users.index') }}"
                                class="small font-weight-bold text-primary d-inline-block mt-3">Kelola ekosistem peserta <i
                                    class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-card p-4 h-100" style="border-left: 4px solid #7c3aed;">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div>
                                    <span class="badge px-2 py-1 mb-2 text-white"
                                        style="background: #7c3aed; font-size: .66rem; border-radius: 5px;">SKEMA 02</span>
                                    <h5 class="section-title mb-1">Bankir</h5>
                                    <div class="section-subtitle text-muted">Member individu dan perusahaan untuk
                                        pengembangan profesional.</div>
                                </div>
                                <div class="metric-icon" style="background: #ede9fe; color: #7c3aed;"><i
                                        class="fas fa-briefcase"></i></div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="small text-muted">Total member</div>
                                    <div class="h4 font-weight-bold text-dark mb-0">
                                        {{ number_format($total_bankir_members) }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="small text-muted">Membership aktif</div>
                                    <div class="h4 font-weight-bold text-success mb-0">
                                        {{ number_format($active_bankir_members) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Perusahaan / individu</div>
                                    <div class="h4 font-weight-bold text-dark mb-0">{{ number_format($company_members) }}
                                        <span class="text-muted font-weight-normal">/</span>
                                        {{ number_format($individual_members) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Pendapatan lunas</div>
                                    <div class="h4 font-weight-bold text-dark mb-0">Rp
                                        {{ number_format($bankir_revenue, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <a href="{{ route('memberships.index') }}" class="small font-weight-bold"
                                style="color: #7c3aed; display: inline-block; margin-top: 1rem;">Kelola membership bankir
                                <i class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <div class="section-card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h5 class="section-title mb-1">Kesiapan ekosistem pembelajaran</h5>
                                    <div class="section-subtitle text-muted">Komponen utama yang tersedia di platform</div>
                                </div>
                                <i class="fas fa-layer-group text-primary"></i>
                            </div>
                            @php
                                $contentRows = [
                                    [
                                        'label' => 'Bidang',
                                        'value' => $total_kategori,
                                        'color' => '#2563eb',
                                        'icon' => 'fa-folder',
                                    ],
                                    [
                                        'label' => 'Kompetensi',
                                        'value' => $total_materi,
                                        'color' => '#7c3aed',
                                        'icon' => 'fa-book',
                                    ],
                                    [
                                        'label' => 'Materi / bab',
                                        'value' => $total_sub_materi,
                                        'color' => '#059669',
                                        'icon' => 'fa-file-alt',
                                    ],
                                    [
                                        'label' => 'Instruktur aktif',
                                        'value' => $active_instruktur,
                                        'color' => '#d97706',
                                        'icon' => 'fa-user-tie',
                                    ],
                                ];
                                $contentMax = max(1, collect($contentRows)->max('value'));
                            @endphp
                            @foreach ($contentRows as $content)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"><span
                                            class="small font-weight-bold text-dark"><i
                                                class="fas {{ $content['icon'] }} mr-2"
                                                style="color: {{ $content['color'] }};"></i>{{ $content['label'] }}</span><span
                                            class="small font-weight-bold text-muted">{{ number_format($content['value']) }}</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar"
                                            style="width: {{ ($content['value'] / $contentMax) * 100 }}%; background: {{ $content['color'] }};">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="border-top pt-3 mt-4 d-flex justify-content-between small"><span
                                    class="text-muted"><i class="fas fa-briefcase mr-1"></i> Lowongan aktif</span><strong
                                    class="text-dark">{{ number_format($active_loker) }} <span
                                        class="text-muted font-weight-normal">/
                                        {{ number_format($total_loker) }}</span></strong></div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="section-card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h5 class="section-title mb-1">Distribusi akun</h5>
                                    <div class="section-subtitle text-muted">Pengguna berdasarkan entitas</div>
                                </div><i class="fas fa-chart-pie text-success"></i>
                            </div>
                            @php $userTotal = max(1, array_sum($user_distribution)); @endphp
                            @foreach ([['label' => 'Bank mitra', 'key' => 'bank', 'color' => '#2563eb'], ['label' => 'Merchant / sekolah', 'key' => 'sekolah', 'color' => '#059669'], ['label' => 'Peserta', 'key' => 'siswa', 'color' => '#d97706']] as $distribution)
                                @php $distributionValue = $user_distribution[$distribution['key']]; @endphp
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle mr-3"
                                        style="background: {{ $distribution['color'] }}; height: 10px; width: 10px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between small mb-1"><span
                                                class="text-muted">{{ $distribution['label'] }}</span><strong>{{ number_format($distributionValue) }}</strong>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar"
                                                style="background: {{ $distribution['color'] }}; width: {{ ($distributionValue / $userTotal) * 100 }}%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="bg-light rounded p-3 mt-4">
                                <div class="small text-muted mb-1">Total akun operasional</div>
                                <div class="h4 font-weight-bold text-dark mb-0">
                                    {{ number_format(array_sum($user_distribution)) }}</div>
                                <div class="small text-muted mt-1">{{ number_format($inactive_users) }} akun belum aktif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-5 mb-3 mb-lg-0">
                        <div class="section-card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h5 class="section-title mb-1">Operasional pembayaran</h5>
                                    <div class="section-subtitle text-muted">Status transaksi pada seluruh kanal</div>
                                </div><i class="fas fa-wallet text-warning"></i>
                            </div>
                            <div class="row no-gutters mb-3">
                                <div class="col-4 pr-2">
                                    <div class="bg-light rounded p-3">
                                        <div class="small text-muted">Pending</div>
                                        <div class="h4 font-weight-bold text-warning mb-0">
                                            {{ number_format($payment_pending) }}</div>
                                    </div>
                                </div>
                                <div class="col-4 px-1">
                                    <div class="bg-light rounded p-3">
                                        <div class="small text-muted">Lunas</div>
                                        <div class="h4 font-weight-bold text-success mb-0">
                                            {{ number_format($payment_paid) }}</div>
                                    </div>
                                </div>
                                <div class="col-4 pl-2">
                                    <div class="bg-light rounded p-3">
                                        <div class="small text-muted">Batal</div>
                                        <div class="h4 font-weight-bold text-danger mb-0">
                                            {{ number_format($payment_canceled) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top pt-3">
                                <div class="small text-muted mb-1">Total nominal transaksi lunas</div>
                                <div class="h4 font-weight-bold text-dark mb-1">Rp
                                    {{ number_format($payment_revenue, 0, ',', '.') }}</div>
                                <div class="small text-muted">Kelas: {{ number_format($class_payment_paid) }} lunas,
                                    {{ number_format($class_payment_pending) }} belum lunas</div>
                            </div>
                            <a href="{{ route('admin.payments.index') }}"
                                class="btn btn-outline-primary btn-sm font-weight-bold mt-3"
                                style="border-radius: 8px;">Buka manajemen pembayaran <i
                                    class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="section-card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h5 class="section-title mb-1">Aktivitas sistem terbaru</h5>
                                    <div class="section-subtitle text-muted">Perubahan data yang baru dilakukan</div>
                                </div><a href="{{ route('activity.index') }}"
                                    class="small font-weight-bold text-primary">Lihat semua</a>
                            </div>
                            @forelse($recent_activity as $activity)
                                <div class="d-flex align-items-center border-bottom py-3"
                                    style="border-color: #f1f5f9 !important;">
                                    <div class="metric-icon mr-3"
                                        style="background: #eff6ff; color: #2563eb; height: 36px; width: 36px;"><i
                                            class="fas fa-history small"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="small font-weight-bold text-dark">
                                            {{ $activity->description ?: ucfirst($activity->event ?? 'Aktivitas') }}</div>
                                        <div class="small text-muted">{{ $activity->causer->name ?? 'System' }} ·
                                            {{ $activity->created_at->diffForHumans() }}</div>
                                    </div><span
                                        class="badge badge-light text-muted">{{ ucfirst($activity->event ?? 'log') }}</span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-2"></i>
                                    <div class="small">Belum ada aktivitas yang tercatat.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <div class="section-card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h5 class="section-title mb-1">Transaksi terbaru</h5>
                                    <div class="section-subtitle text-muted">Lima transaksi terakhir yang masuk ke sistem
                                    </div>
                                </div><a href="{{ route('admin.payments.index') }}"
                                    class="small font-weight-bold text-primary">Kelola</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pl-0">Pengguna</th>
                                            <th>Produk</th>
                                            <th>Status</th>
                                            <th class="text-right pr-0">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_payments as $payment)
                                            @php $paymentStatus = (int) $payment->status; @endphp
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="font-weight-bold text-dark">
                                                        {{ $payment->user->name ?? 'Pengguna' }}</div>
                                                    <div class="small text-muted">{{ $payment->no_invoice }}</div>
                                                </td>
                                                <td class="text-muted">{{ ucfirst($payment->pembelian ?? 'Transaksi') }}
                                                </td>
                                                <td>
                                                    @if ($paymentStatus === \App\Models\DataPayment::STATUS_PAID)
                                                        <span class="badge badge-success">Lunas</span>
                                                    @elseif($paymentStatus === \App\Models\DataPayment::STATUS_PENDING)
                                                        <span
                                                        class="badge badge-warning text-white">Pending</span>@else<span
                                                            class="badge badge-danger">Batal</span>
                                                    @endif
                                                </td>
                                                <td class="text-right pr-0 font-weight-bold text-dark">Rp
                                                    {{ number_format($payment->nominal ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">Belum ada
                                                    transaksi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="section-card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h5 class="section-title mb-1">Pintasan pengelolaan</h5>
                                    <div class="section-subtitle text-muted">Akses cepat menu yang sering digunakan</div>
                                </div><i class="fas fa-bolt text-warning"></i>
                            </div>
                            <div class="row">
                                @foreach ([['route' => 'users.index', 'label' => 'Pengguna', 'icon' => 'fa-users', 'color' => '#2563eb'], ['route' => 'materi.index', 'label' => 'Kompetensi', 'icon' => 'fa-book-open', 'color' => '#7c3aed'], ['route' => 'classes.index', 'label' => 'Daftar kelas', 'icon' => 'fa-chalkboard', 'color' => '#059669'], ['route' => 'instructor.index', 'label' => 'Instruktur', 'icon' => 'fa-user-tie', 'color' => '#d97706'], ['route' => 'admin.loker.index', 'label' => 'Loker', 'icon' => 'fa-briefcase', 'color' => '#db2777'], ['route' => 'activity.index', 'label' => 'Log aktivitas', 'icon' => 'fa-history', 'color' => '#0891b2']] as $shortcut)
                                    <div class="col-6 mb-2"><a href="{{ route($shortcut['route']) }}"
                                            class="quick-link"><i class="fas {{ $shortcut['icon'] }}"
                                                style="color: {{ $shortcut['color'] }};"></i><span>{{ $shortcut['label'] }}</span></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-card p-3 p-md-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="section-title mb-1"><i class="fas fa-university text-primary mr-2"></i>Bank mitra
                                terbaru</h5>
                            <div class="section-subtitle text-muted">Akun root dan akun sistem tidak ditampilkan sebagai
                                bank operasional.</div>
                        </div><a href="{{ route('users.index') }}" class="small font-weight-bold text-primary">Kelola
                            pengguna</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="pl-0">Nama bank</th>
                                    <th>Email</th>
                                    <th>Status akun</th>
                                    <th class="text-right pr-0">Terdaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user_bank as $bank)
                                    <tr>
                                        <td class="pl-0 font-weight-bold text-dark">{{ $bank->name }}</td>
                                        <td class="text-muted">{{ $bank->email }}</td>
                                        <td>
                                            @if ((int) $bank->is_active === 1)
                                                <span class="text-success small font-weight-bold"><span
                                                    class="status-dot bg-success"></span>Aktif</span>@else<span
                                                    class="text-muted small font-weight-bold"><span
                                                        class="status-dot bg-secondary"></span>Belum aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-right pr-0 text-muted small">
                                            {{ optional($bank->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada bank mitra
                                            operasional.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 2. INTERFACE FOR BANK (ROLE 4)                                            --}}
            {{-- ========================================================================= --}}
        @elseif(auth()->user()->role == 4)
            <div class="row mb-4">
                <div class="col-12 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm bg-gradient-primary text-white"
                        style="border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #047857 100%);">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Merchant
                                    Binaan Anda</span>
                                <h2 class="font-weight-extrabold mb-0" style="font-size: 2.2rem; font-weight: 800;">
                                    {{ $total_sekolah }}</h2>
                            </div>
                            <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                                <i class="fas fa-school fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm bg-white"
                        style="border-radius: 16px; border-left: 5px solid #3b82f6 !important;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Total Peserta
                                    Terkoneksi</span>
                                <h2 class="font-weight-extrabold text-dark mb-0"
                                    style="font-size: 2.2rem; font-weight: 800;">{{ $total_siswa }}</h2>
                            </div>
                            <div class="p-3 bg-soft-primary rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-user-graduate text-primary fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                        <h5 class="font-weight-bold text-dark mb-4"><i
                                class="fas fa-chart-pie mr-2 text-success"></i>Monitoring Distribusi Peserta per Merchant
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover border-0">
                                <thead>
                                    <tr class="text-uppercase text-muted small">
                                        <th class="border-0 pl-0">Nama Merchant</th>
                                        <th class="border-0">Email Kontak</th>
                                        <th class="border-0 text-center">Jumlah Peserta Aktif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($daftar_sekolah as $sch)
                                        <tr>
                                            <td class="pl-0 font-weight-bold text-dark">{{ $sch->name }}</td>
                                            <td>{{ $sch->email }}</td>
                                            <td class="text-center"><span
                                                    class="badge bg-soft-primary text-primary px-3 py-2 font-weight-bold"
                                                    style="border-radius:6px;">{{ $sch->jumlah_siswa }} Peserta</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum terhubung dengan
                                                merchant manapun.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 3. INTERFACE FOR SEKOLAH (ROLE 5)                                         --}}
            {{-- ========================================================================= --}}
        @elseif(auth()->user()->role == 5)
            <div class="row mb-4">
                <div class="col-12 col-sm-6 col-xl-4 mb-3">
                    <div class="card border-0 shadow-sm text-white"
                        style="border-radius: 16px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Total
                                    Peserta Aktif</span>
                                <h2 class="font-weight-extrabold mb-0" style="font-size: 2.2rem; font-weight: 800;">
                                    {{ $total_siswa }}</h2>
                            </div>
                            <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4 mb-3">
                    <div class="card border-0 shadow-sm bg-white"
                        style="border-radius: 16px; border-left: 5px solid #10b981 !important;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Siswa Jalur
                                    Beasiswa</span>
                                <h2 class="font-weight-extrabold text-dark mb-0"
                                    style="font-size: 2.2rem; font-weight: 800;">{{ $total_beasiswa }}</h2>
                            </div>
                            <div class="p-3 bg-soft-success rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-id-badge text-success fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4 mb-3">
                    <div class="card border-0 shadow-sm bg-white"
                        style="border-radius: 16px; border-left: 5px solid #3b82f6 !important;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Total Akumulasi
                                    Kredit Peserta</span>
                                <h2 class="font-weight-extrabold text-primary mb-0"
                                    style="font-size: 1.6rem; font-weight: 800; margin-top: 5px;">Rp
                                    {{ number_format($total_tabungan_siswa, 0, ',', '.') }}</h2>
                            </div>
                            <div class="p-3 bg-soft-primary rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-wallet text-primary fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                        <h5 class="font-weight-bold text-dark mb-4"><i
                                class="fas fa-user-check mr-2 text-warning"></i>Administrasi Profil Peserta Lembaga</h5>
                        <div class="table-responsive">
                            <table class="table table-hover border-0">
                                <thead>
                                    <tr class="text-uppercase text-muted small">
                                        <th class="border-0 pl-0">Nama Lengkap</th>
                                        <th class="border-0">NISN</th>
                                        <th class="border-0">Kelas</th>
                                        <th class="border-0 text-md-right pr-0">Saldo Tabungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($daftar_siswa as $s)
                                        <tr>
                                            <td class="pl-0 font-weight-bold text-dark">
                                                {{ $s->name }}
                                                @if ($s->siswa && $s->siswa->beasiswa == 1)
                                                    <span class="badge badge-warning text-white ml-1"
                                                        style="font-size: 10px;">Beasiswa</span>
                                                @endif
                                            </td>
                                            <td>{{ $s->siswa->nisn ?? '-' }}</td>
                                            <td>{{ $s->siswa->kelas ?? '-' }}</td>
                                            <td class="text-md-right pr-0 font-weight-bold text-success">Rp
                                                {{ number_format($s->siswa->saldo ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada peserta terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 4. INTERFACE FOR SISWA (TAMPILAN TIMELINE ORIGINAL ANDA)                  --}}
            {{-- ========================================================================= --}}
            {{-- ========================================================================= --}}
            {{-- 4. INTERFACE FOR SISWA (TAMPILAN MODERN GEN-Z)                            --}}
            {{-- ========================================================================= --}}
        @elseif(auth()->user()->role == 6)
            <div class="row mb-4">
                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm text-white h-100"
                        style="border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Kredit
                                    Peserta</span>
                                <h2 class="font-weight-extrabold mb-0"
                                    style="font-size: 1.4rem; font-weight: 800; white-space: nowrap;">
                                    Rp {{ number_format($saldo_siswa, 0, ',', '.') }}
                                </h2>
                            </div>
                            <div class="p-2 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                                <i class="fas fa-wallet fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm bg-white h-100"
                        style="border-radius: 16px; border-left: 5px solid #3b82f6 !important;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Bab
                                    Diikuti</span>
                                <h2 class="font-weight-extrabold text-dark mb-0"
                                    style="font-size: 1.6rem; font-weight: 800;">{{ $total_bab }}</h2>
                            </div>
                            <div class="p-2 bg-soft-primary rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-graduation-cap text-primary fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm bg-white h-100"
                        style="border-radius: 16px; border-left: 5px solid #f59e0b !important;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Status
                                    Akun</span>
                                <div class="mt-1">
                                    @if ($profile && $profile->beasiswa == 1)
                                        <span class="badge badge-warning px-2.5 py-1.5 text-white shadow-sm"
                                            style="border-radius: 6px; font-size: 0.75rem;">Beasiswa</span>
                                    @else
                                        <span class="badge badge-secondary px-2.5 py-1.5 text-white"
                                            style="border-radius: 6px; font-size: 0.75rem;">Reguler</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-2 bg-soft-warning rounded-circle" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-user-shield text-warning fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm bg-white h-100"
                        style="border-radius: 16px; border-left: 5px solid #a855f7 !important;">
                        <div class="card-body p-3 flex-column d-flex justify-content-center">
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1"><i
                                    class="fas fa-unlock-alt text-purple mr-1"></i> Modul Beasiswa</span>
                            @if ($profile && $profile->beasiswa == 1 && !$modul_aktif->isEmpty())
                                <div class="d-flex align-items-center mt-1"
                                    style="gap: 4px; overflow-x: auto; white-space: nowrap; py-1;">
                                    @foreach ($modul_aktif as $modul)
                                        <span class="badge bg-light text-dark border p-2 text-truncate"
                                            style="max-width: 100px; border-radius: 6px; font-size: 11px;"
                                            title="{{ $modul->materi->nama ?? 'Modul' }}">
                                            ⚡ {{ $modul->materi->nama ?? 'Modul' }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted small mt-1" style="font-size: 11px;">Tidak ada modul aktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm position-relative overflow-hidden"
                        style="border-radius: 20px; background: linear-gradient(105deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%); min-height: 140px;">
                        <div class="position-absolute"
                            style="width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%; top: -50px; right: -20px;">
                        </div>
                        <div class="position-absolute"
                            style="width: 90px; height: 90px; background: rgba(255,255,255,0.06); border-radius: 50%; bottom: -20px; left: 30%;">
                        </div>

                        <div class="card-body p-4 p-md-4.5 d-flex flex-column flex-md-row align-items-md-center justify-content-between text-white position-relative"
                            style="z-index: 2;">
                            <div class="mb-3 mb-md-0 max-w-md">
                                <span
                                    class="badge bg-white text-dark font-weight-bold px-3 py-1.5 text-uppercase mb-2 shadow-sm"
                                    style="border-radius: 30px; font-size: 11px; letter-spacing: 1px;">🚀 Level Up Your
                                    Skill</span>
                                <h3 class="font-weight-extrabold mb-1" style="font-weight: 800; letter-spacing: -0.5px;">
                                    Investasi Masa Depan Mulai dari Nol! ✨</h3>
                                <p class="text-white-50 mb-0 small font-weight-medium">Klaim voucher pelatihan premium &
                                    program magang bersertifikat khusus anak SMK/SMA. Jangan sampai FOMO!</p>
                            </div>
                            <div>
                                <a href="#eksplor-materi"
                                    class="btn btn-white text-dark font-weight-bold px-4 py-2.5 shadow transition-all hover-scale"
                                    style="border-radius: 12px; background: #fff; font-size: 0.9rem; border: none;">
                                    Ambil Slot Sekarang <i class="fas fa-fire ml-2 text-warning"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-stream mr-2 text-primary"
                                    style="font-size: 1.1rem;"></i>Aktivitas Belajar</h5>
                            <span class="badge bg-light text-muted px-2 py-1 font-weight-bold"
                                style="font-size: 11px;">Terbaru</span>
                        </div>

                        @if ($history->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($history as $item)
                                    <div class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-light flex-wrap flex-sm-nowrap transition-all"
                                        style="border-bottom: 1px dashed #f1f5f9 !important;">
                                        <div class="d-flex align-items-center mr-3 mb-2 mb-sm-0" style="gap: 12px;">
                                            <div class="d-flex align-items-center justify-content-center bg-soft-primary rounded-circle text-primary flex-shrink-0"
                                                style="width: 32px; height: 32px; background: rgba(59, 130, 246, 0.1);">
                                                <i class="fas fa-book-reader" style="font-size: 0.85rem;"></i>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold text-dark mb-0"
                                                    style="font-size: 0.9rem; line-height: 1.3;">Bab {{ $item->urutan }}:
                                                    {{ $item->nama_sub }}</h6>
                                                <span class="text-muted d-inline-block mt-0.5" style="font-size: 11px;">
                                                    <i class="far fa-clock mr-1 text-muted"></i>
                                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M, H:i') }}
                                                    WIB
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('siswa.umum.belajar', $item->sub_materi_id) }}"
                                                class="btn btn-sm btn-light text-primary font-weight-bold px-3"
                                                style="border-radius: 6px; font-size: 0.8rem; background: #f8fafc; border: 1px solid #e2e8f0;">
                                                Gas Belajar <i class="fas fa-chevron-right ml-1"
                                                    style="font-size: 0.7rem;"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="p-3 bg-light rounded-circle d-inline-block mb-2"
                                    style="width: 70px; height: 70px; line-height: 40px;">
                                    <i class="fas fa-folder-open fa-2x text-muted"></i>
                                </div>
                                <h6 class="font-weight-bold text-muted mb-0">Belum ada history belajar nih.</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
