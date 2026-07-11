@extends('layouts.compact')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-4" id="cancel-row">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-8 mb-3 mb-md-0">
            <h1 class="font-weight-bold text-dark h3 mb-1">Riwayat Pelatihan Anda</h1>
            <p class="text-muted mb-0">Pantau terus perkembangan belajar, modul aktif, dan transaksi Anda.</p>
        </div>
        <div class="col-md-4 text-md-right">
            <a href="{{ route('siswa.umum.index') }}" class="btn btn-primary px-4 py-2.5 font-weight-bold shadow-sm" style="border-radius: 10px; gap: 8px;">
                <i class="fas fa-search mr-2"></i> Jelajahi Materi Baru
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm text-white" style="border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Total Bab Diikuti</span>
                        <h2 class="font-weight-extrabold mb-0" style="font-size: 2rem; font-weight: 800;">{{ $totalBab }}</h2>
                    </div>
                    <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #10b981 !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Kategori Kursus Aktif</span>
                        <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2rem; font-weight: 800;">{{ $totalMateri }}</h2>
                    </div>
                    <div class="p-3 bg-soft-success rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                        <i class="fas fa-book-open text-success fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #f59e0b !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Status Keanggotaan</span>
                        <h2 class="font-weight-extrabold text-dark mb-0 h4 mt-2 font-weight-bold" style="color: #f59e0b !important;">
                            @if(auth()->user()->siswa && auth()->user()->siswa->beasiswa == 1)
                                <span class="badge badge-warning px-3 py-2 text-white" style="border-radius: 8px;">Siswa Beasiswa</span>
                            @else
                                <span class="badge badge-secondary px-3 py-2 text-white" style="border-radius: 8px;">Reguler / Umum</span>
                            @endif
                        </h2>
                    </div>
                    <div class="p-3 bg-soft-warning rounded-circle" style="background: rgba(245, 158, 11, 0.1);">
                        <i class="fas fa-user-shield text-warning fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #6366f1 !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Sisa Saldo Membership</span>
                        <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 1.5rem; font-weight: 800;">
                            Rp {{ number_format($saldoSiswa, 0, ',', '.') }}
                        </h2>
                    </div>
                    <div class="p-3 bg-soft-indigo rounded-circle" style="background: rgba(99, 102, 241, 0.1);">
                        <i class="fas fa-wallet text-indigo fa-2x" style="color: #6366f1;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm p-3 p-md-4 bg-white mb-4" style="border-radius: 16px;">
                <h5 class="font-weight-bold text-dark mb-4">
                    <i class="fas fa-history mr-2 text-primary"></i>Timeline Aktivitas Belajar
                </h5>

                @if($history->count() > 0)
                    <div class="learning-timeline position-relative pl-4" style="border-left: 3px solid #e2e8f0; margin-left: 15px;">
                        @foreach($history as $item)
                            <div class="timeline-item position-relative mb-4 pb-2">
                                <div class="timeline-dot position-absolute bg-primary rounded-circle shadow-sm" 
                                     style="width: 16px; height: 16px; left: -33px; top: 4px; border: 3px solid #fff;">
                                </div>
                                <div class="card border border-light shadow-none w-100 p-3" style="border-radius: 12px; border: 1px solid #f1f5f9 !important;">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                        <div class="mb-3 mb-md-0">
                                            <h4 class="h6 font-weight-bold text-dark mb-1">
                                                Bab {{ $item->urutan }}: {{ $item->nama_sub }}
                                            </h4>
                                            <small class="text-muted d-block mt-2">
                                                <i class="far fa-clock mr-1 text-danger"></i> Mulai diakses pada: 
                                                <strong>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y, H:i') }} WIB</strong>
                                            </small>
                                        </div>
                                        <div>
                                            <a href="{{ route('siswa.umum.belajar', $item->sub_materi_id) }}" class="btn btn-outline-primary font-weight-bold px-3 py-1.5" style="border-radius: 8px; font-size: 0.8rem;">
                                                Lanjutkan Belajar <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h6 class="font-weight-bold text-dark">Belum Ada Riwayat Belajar</h6>
                        <p class="text-muted small">Anda belum mulai membuka bab pelajaran apa pun.</p>
                    </div>
                @endif
            </div>

            <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                <h5 class="font-weight-bold text-dark mb-4">
                    <i class="fas fa-receipt mr-2 text-warning"></i>Riwayat Transaksi Kelas
                </h5>

                @if($riwayatTransaksi->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless align-middle">
                            <thead class="bg-light text-muted text-uppercase small">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Kelas</th>
                                    <th>Nominal</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatTransaksi as $tx)
                                <tr>
                                    <td class="small">{{ $tx->created_at->translatedFormat('d M Y, H:i') }}</td>
                                    <td>
                                        <span class="font-weight-bold text-dark">
                                            {{ $tx->materi ? $tx->materi->nama : 'Kelas Terhapus' }}
                                        </span>
                                    </td>
                                    <td class="font-weight-bold text-dark">Rp {{ number_format($tx->nominal_transaksi, 0, ',', '.') }}</td>
                                    <td><span class="badge badge-light px-2 py-1 text-uppercase">{{ $tx->metode_pembayaran }}</span></td>
                                    <td>
                                        @if($tx->status == 'success' || $tx->status == 'berhasil')
                                            <span class="badge badge-success px-2 py-1">Berhasil</span>
                                        @else
                                            <span class="badge badge-warning px-2 py-1">{{ $tx->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                        <h6 class="font-weight-bold text-dark">Belum Ada Transaksi</h6>
                        <p class="text-muted small">Riwayat pembelian kelas atau penggunaan saldo akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                <h5 class="font-weight-bold text-dark mb-3">
                    <i class="fas fa-cubes mr-2 text-success"></i>Modul Kelas Aktif
                </h5>
                <p class="text-muted small mb-4">Daftar modul/kelas utama yang terdaftar pada akun Anda saat ini.</p>

                @if($modulAktif->count() > 0)
                    <div class="d-flex flex-column" style="gap: 12px;">
                        @foreach($modulAktif as $modul)
                            <div class="p-3 rounded d-flex align-items-center justify-content-between border border-light" style="background-color: #f8fafc; border-radius: 12px !important;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 bg-soft-success text-success p-2 rounded-lg" style="background: rgba(16, 185, 129, 0.1);">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold text-dark mb-0 mb-1" style="font-size: 0.9rem;">
                                            {{ $modul->materi ? $modul->materi->nama : 'Modul Tidak Diketahui' }}
                                        </h6>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                                            Terdaftar: {{ $modul->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                                <span class="badge badge-success badge-pill small px-2 py-1" style="font-size: 0.7rem;">Aktif</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-book-open fa-2x text-muted mb-2"></i>
                        <h6 class="font-weight-bold text-dark" style="font-size: 0.9rem;">Belum Mengikuti Modul</h6>
                        <p class="text-muted small" style="font-size: 0.8rem;">Silakan beli atau klaim kelas terlebih dahulu.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection