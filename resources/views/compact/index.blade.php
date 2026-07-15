@extends('layouts.compact')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-4" id="cancel-row">
    
    {{-- ================= HEADERS SECTION ================= --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-8 mb-3 mb-md-0">
            <h1 class="font-weight-bold text-dark h3 mb-1">
                @if(auth()->user()->email == 'cb@bankir.academy') Panel Kendali Sistem Root
                @elseif(auth()->user()->role == 4) Dashboard Performa Bank
                @elseif(auth()->user()->role == 5) Konsol Manajemen Sekolah
                @else Dashboard Pelatihan Anda
                @endif
            </h1>
            <p class="text-muted mb-0">
                @if(auth()->user()->role == 6) Pantau terus perkembangan belajar dan bab materi yang telah Anda buka.
                @else Kelola data enkapsulasi entitas Anda secara terpusat di sini.
                @endif
            </p>
        </div>
        <div class="col-md-4 text-md-right">
            @if(auth()->user()->role == 6)
                <a href="{{ route('siswa.umum.index') }}" class="btn btn-primary px-4 py-2.5 font-weight-bold shadow-sm" style="border-radius: 10px; gap: 8px;">
                    <i class="fas fa-search mr-2"></i> Jelajahi Materi Baru
                </a>
            @endif
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- 1. INTERFACE FOR ROOT                                                     --}}
    {{-- ========================================================================= --}}
    @if(auth()->user()->email == 'cb@bankir.academy')
        <div class="row mb-4">
            <div class="col-12 col-sm-6 col-xl-4 mb-3">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white" style="border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Total Entitas Bank</span>
                            <h2 class="font-weight-extrabold mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $total_bank }}</h2>
                        </div>
                        <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-university fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #10b981 !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Total Sekolah Mitra</span>
                            <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $total_sekolah }}</h2>
                        </div>
                        <div class="p-3 bg-soft-success rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-school text-success fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #f59e0b !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Total Akun Siswa</span>
                            <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $total_siswa }}</h2>
                        </div>
                        <div class="p-3 bg-soft-warning rounded-circle" style="background: rgba(245, 158, 11, 0.1);">
                            <i class="fas fa-users text-warning fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                    <h5 class="font-weight-bold text-dark mb-4"><i class="fas fa-tasks mr-2 text-primary"></i>Daftar Manajemen Bank Mitra Terdaftar</h5>
                    <div class="table-responsive">
                        <table class="table table-hover border-0">
                            <thead>
                                <tr class="text-uppercase text-muted small"><th class="border-0 pl-0">Nama Bank</th><th class="border-0">Email</th><th class="border-0 text-md-right pr-0">Opsi Administrasi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($user_bank as $bank)
                                <tr>
                                    <td class="pl-0 font-weight-bold text-dark">{{ $bank->name }}</td>
                                    <td>{{ $bank->email }}</td>
                                    <td class="text-md-right pr-0">
                                        <button class="btn btn-sm btn-outline-primary font-weight-bold px-3" style="border-radius: 8px;"><i class="fas fa-user-cog mr-1"></i> Kelola User Bank</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- 2. INTERFACE FOR BANK (ROLE 4)                                            --}}
    {{-- ========================================================================= --}}
    @elseif(auth()->user()->role == 4)
        <div class="row mb-4">
            <div class="col-12 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white" style="border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #047857 100%);">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Sekolah Binaan Anda</span>
                            <h2 class="font-weight-extrabold mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $total_sekolah }}</h2>
                        </div>
                        <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #3b82f6 !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Total Siswa Terkoneksi</span>
                            <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $total_siswa }}</h2>
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
                    <h5 class="font-weight-bold text-dark mb-4"><i class="fas fa-chart-pie mr-2 text-success"></i>Monitoring Distribusi Siswa per Sekolah</h5>
                    <div class="table-responsive">
                        <table class="table table-hover border-0">
                            <thead>
                                <tr class="text-uppercase text-muted small"><th class="border-0 pl-0">Nama Sekolah</th><th class="border-0">Email Kontak</th><th class="border-0 text-center">Jumlah Siswa Aktif</th></tr>
                            </thead>
                            <tbody>
                                @forelse($daftar_sekolah as $sch)
                                <tr>
                                    <td class="pl-0 font-weight-bold text-dark">{{ $sch->name }}</td>
                                    <td>{{ $sch->email }}</td>
                                    <td class="text-center"><span class="badge bg-soft-primary text-primary px-3 py-2 font-weight-bold" style="border-radius:6px;">{{ $sch->jumlah_siswa }} Siswa</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center text-muted">Belum terhubung dengan sekolah manapun.</td></tr>
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
                <div class="card border-0 shadow-sm text-white" style="border-radius: 16px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Total Siswa Aktif</span>
                            <h2 class="font-weight-extrabold mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $total_siswa }}</h2>
                        </div>
                        <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #10b981 !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Siswa Jalur Beasiswa</span>
                            <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $total_beasiswa }}</h2>
                        </div>
                        <div class="p-3 bg-soft-success rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-id-badge text-success fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #3b82f6 !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Total Akumulasi Kredit Siswa</span>
                            <h2 class="font-weight-extrabold text-primary mb-0" style="font-size: 1.6rem; font-weight: 800; margin-top: 5px;">Rp {{ number_format($total_tabungan_siswa, 0, ',', '.') }}</h2>
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
                    <h5 class="font-weight-bold text-dark mb-4"><i class="fas fa-user-check mr-2 text-warning"></i>Administrasi Profil Siswa Lembaga</h5>
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
                                        @if($s->siswa && $s->siswa->beasiswa == 1)
                                            <span class="badge badge-warning text-white ml-1" style="font-size: 10px;">Beasiswa</span>
                                        @endif
                                    </td>
                                    <td>{{ $s->siswa->nisn ?? '-' }}</td>
                                    <td>{{ $s->siswa->kelas ?? '-' }}</td>
                                    <td class="text-md-right pr-0 font-weight-bold text-success">Rp {{ number_format($s->siswa->saldo ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">Belum ada siswa terdaftar.</td></tr>
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
    @elseif(auth()->user()->role == 6)
        <!-- Stat Cards Siswa -->
        <div class="row mb-4">
            <!-- KARTU 1: SALDO UTAMA SISWA -->
            <div class="col-12 col-sm-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm text-white" style="border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1"></span>Kredit Siswa
                            <h2 class="font-weight-extrabold mb-0" style="font-size: 1.6rem; font-weight: 800; white-space: nowrap;">
                                Rp {{ number_format($saldo_siswa, 0, ',', '.') }}
                            </h2>
                        </div>
                        <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15); margin-left: 5px;">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KARTU 2: TOTAL BAB DIKUTI -->
            <div class="col-12 col-sm-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #3b82f6 !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Total Bab Diikuti</span>
                            <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2rem; font-weight: 800;">{{ $total_bab }}</h2>
                        </div>
                        <div class="p-3 bg-soft-primary rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                            <i class="fas fa-graduation-cap text-primary fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- KARTU 3: KATEGORI KURSUS AKTIF -->
            <!-- <div class="col-12 col-sm-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #6366f1 !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Kursus Aktif</span>
                            <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2rem; font-weight: 800;">{{ $total_materi }}</h2>
                        </div>
                        <div class="p-3 bg-soft-indigo rounded-circle" style="background: rgba(99, 102, 241, 0.1);">
                            <i class="fas fa-book-open text-indigo fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- KARTU 4: STATUS KEANGGOTAAN -->
            <div class="col-12 col-sm-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #f59e0b !important;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Status Akun</span>
                            <h2 class="font-weight-extrabold text-dark mb-0 h5 mt-2 font-weight-bold" style="color: #f59e0b !important;">
                                @if($profile && $profile->beasiswa == 1)
                                    <span class="badge badge-warning px-2 py-1.5 text-white" style="border-radius: 6px; font-size: 0.75rem;">Beasiswa</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1.5 text-white" style="border-radius: 6px; font-size: 0.75rem;">Reguler</span>
                                @endif
                            </h2>
                        </div>
                        <div class="p-3 bg-soft-warning rounded-circle" style="background: rgba(245, 158, 11, 0.1);">
                            <i class="fas fa-user-shield text-warning fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($profile && $profile->beasiswa == 1)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px; border: 1px solid rgba(59, 130, 246, 0.2) !important;">
                        <h5 class="font-weight-bold text-primary mb-3"><i class="fas fa-unlock-alt mr-2"></i>Akses Modul Beasiswa Aktif Anda</h5>
                        @if($modul_aktif->isEmpty())
                            <p class="text-muted small mb-0">Belum ada paket modul khusus yang aktif di akun beasiswa Anda.</p>
                        @else
                            <div class="row">
                                @foreach($modul_aktif as $modul)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between" style="border-radius: 10px !important;">
                                            <div>
                                                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 10px;">Materi ID: #{{ $modul->class_id }}</small>
                                                <span class="font-weight-bold text-dark d-block mt-1">{{ $modul->materi->nama ?? 'Modul Terbuka' }}</span>
                                            </div>
                                            <span class="badge bg-soft-success text-success p-2 rounded-circle"><i class="fas fa-check"></i></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                    <h5 class="font-weight-bold text-dark mb-4"><i class="fas fa-history mr-2 text-primary"></i>Timeline Aktivitas Belajar</h5>
                    @if($history->count() > 0)
                        <div class="learning-timeline position-relative pl-4" style="border-left: 3px solid #e2e8f0; margin-left: 15px;">
                            @foreach($history as $item)
                                <div class="timeline-item position-relative mb-4 pb-2">
                                    <div class="timeline-dot position-absolute bg-primary rounded-circle shadow-sm" style="width: 16px; height: 16px; left: -33px; top: 4px; border: 3px solid #fff;"></div>
                                    <div class="card border border-light shadow-none hover-shadow transition-all w-100" style="border-radius: 12px; border: 1px solid #f1f5f9 !important;">
                                        <div class="card-body p-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                            <div class="mb-3 mb-md-0">
                                                <h4 class="h5 font-weight-bold text-dark mb-1 mt-1">Bab {{ $item->urutan }}: {{ $item->nama_sub }}</h4>
                                                <small class="text-muted d-block mt-2">
                                                    <i class="far fa-clock mr-1 text-danger"></i> Mulai diakses pada: 
                                                    <strong>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y, H:i') }} WIB</strong>
                                                </small>
                                            </div>
                                            <div>
                                                <a href="{{ route('siswa.umum.belajar', $item->sub_materi_id) }}" class="btn btn-outline-primary font-weight-bold px-4 py-2" style="border-radius: 8px; font-size: 0.85rem;">
                                                    Lanjutkan Belajar <i class="fas fa-arrow-right ml-2" style="font-size: 0.75rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="p-4 bg-light rounded-circle d-inline-block mb-3" style="width: 100px; height: 100px;"><i class="fas fa-folder-open fa-3x text-muted"></i></div>
                            <h4 class="h5 font-weight-bold text-dark">Belum Ada Riwayat Belajar</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection