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
    {{-- ========================================================================= --}}
    {{-- 4. INTERFACE FOR SISWA (TAMPILAN MODERN GEN-Z)                            --}}
    {{-- ========================================================================= --}}
    @elseif(auth()->user()->role == 6)
        <div class="row mb-4">
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-white h-100" style="border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Kredit Siswa</span>
                            <h2 class="font-weight-extrabold mb-0" style="font-size: 1.4rem; font-weight: 800; white-space: nowrap;">
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
                <div class="card border-0 shadow-sm bg-white h-100" style="border-radius: 16px; border-left: 5px solid #3b82f6 !important;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Bab Diikuti</span>
                            <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 1.6rem; font-weight: 800;">{{ $total_bab }}</h2>
                        </div>
                        <div class="p-2 bg-soft-primary rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                            <i class="fas fa-graduation-cap text-primary fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm bg-white h-100" style="border-radius: 16px; border-left: 5px solid #f59e0b !important;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Status Akun</span>
                            <div class="mt-1">
                                @if($profile && $profile->beasiswa == 1)
                                    <span class="badge badge-warning px-2.5 py-1.5 text-white shadow-sm" style="border-radius: 6px; font-size: 0.75rem;">Beasiswa</span>
                                @else
                                    <span class="badge badge-secondary px-2.5 py-1.5 text-white" style="border-radius: 6px; font-size: 0.75rem;">Reguler</span>
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
                <div class="card border-0 shadow-sm bg-white h-100" style="border-radius: 16px; border-left: 5px solid #a855f7 !important;">
                    <div class="card-body p-3 flex-column d-flex justify-content-center">
                        <span class="d-block text-muted small font-weight-bold text-uppercase mb-1"><i class="fas fa-unlock-alt text-purple mr-1"></i> Modul Beasiswa</span>
                        @if($profile && $profile->beasiswa == 1 && !$modul_aktif->isEmpty())
                            <div class="d-flex align-items-center mt-1" style="gap: 4px; overflow-x: auto; white-space: nowrap; py-1;">
                                @foreach($modul_aktif as $modul)
                                    <span class="badge bg-light text-dark border p-2 text-truncate" style="max-width: 100px; border-radius: 6px; font-size: 11px;" title="{{ $modul->materi->nama ?? 'Modul' }}">
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
                <div class="card border-0 shadow-sm position-relative overflow-hidden" style="border-radius: 20px; background: linear-gradient(105deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%); min-height: 140px;">
                    <div class="position-absolute" style="width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%; top: -50px; right: -20px;"></div>
                    <div class="position-absolute" style="width: 90px; height: 90px; background: rgba(255,255,255,0.06); border-radius: 50%; bottom: -20px; left: 30%;"></div>
                    
                    <div class="card-body p-4 p-md-4.5 d-flex flex-column flex-md-row align-items-md-center justify-content-between text-white position-relative" style="z-index: 2;">
                        <div class="mb-3 mb-md-0 max-w-md">
                            <span class="badge bg-white text-dark font-weight-bold px-3 py-1.5 text-uppercase mb-2 shadow-sm" style="border-radius: 30px; font-size: 11px; letter-spacing: 1px;">🚀 Level Up Your Skill</span>
                            <h3 class="font-weight-extrabold mb-1" style="font-weight: 800; letter-spacing: -0.5px;">Investasi Masa Depan Mulai dari Nol! ✨</h3>
                            <p class="text-white-50 mb-0 small font-weight-medium">Klaim voucher pelatihan premium & program magang bersertifikat khusus anak SMK/SMA. Jangan sampai FOMO!</p>
                        </div>
                        <div>
                            <a href="#eksplor-materi" class="btn btn-white text-dark font-weight-bold px-4 py-2.5 shadow transition-all hover-scale" style="border-radius: 12px; background: #fff; font-size: 0.9rem; border: none;">
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
                        <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-stream mr-2 text-primary" style="font-size: 1.1rem;"></i>Aktivitas Belajar</h5>
                        <span class="badge bg-light text-muted px-2 py-1 font-weight-bold" style="font-size: 11px;">Terbaru</span>
                    </div>

                    @if($history->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($history as $item)
                                <div class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-light flex-wrap flex-sm-nowrap transition-all" style="border-bottom: 1px dashed #f1f5f9 !important;">
                                    <div class="d-flex align-items-center mr-3 mb-2 mb-sm-0" style="gap: 12px;">
                                        <div class="d-flex align-items-center justify-content-center bg-soft-primary rounded-circle text-primary flex-shrink-0" style="width: 32px; height: 32px; background: rgba(59, 130, 246, 0.1);">
                                            <i class="fas fa-book-reader" style="font-size: 0.85rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold text-dark mb-0" style="font-size: 0.9rem; line-height: 1.3;">Bab {{ $item->urutan }}: {{ $item->nama_sub }}</h6>
                                            <span class="text-muted d-inline-block mt-0.5" style="font-size: 11px;">
                                                <i class="far fa-clock mr-1 text-muted"></i> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M, H:i') }} WIB
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('siswa.umum.belajar', $item->sub_materi_id) }}" class="btn btn-sm btn-light text-primary font-weight-bold px-3" style="border-radius: 6px; font-size: 0.8rem; background: #f8fafc; border: 1px solid #e2e8f0;">
                                            Gas Belajar <i class="fas fa-chevron-right ml-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="p-3 bg-light rounded-circle d-inline-block mb-2" style="width: 70px; height: 70px; line-height: 40px;">
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