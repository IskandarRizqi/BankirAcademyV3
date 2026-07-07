@extends('layouts.compact')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-4" id="cancel-row">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-8 mb-3 mb-md-0">
            <h1 class="font-weight-bold text-dark h3 mb-1">Riwayat Pelatihan Anda</h1>
            <p class="text-muted mb-0">Pantau terus perkembangan belajar dan bab materi yang telah Anda buka.</p>
        </div>
        <div class="col-md-4 text-md-right">
            <a href="{{ route('siswa.umum.index') }}" class="btn btn-primary px-4 py-2.5 font-weight-bold shadow-sm" style="border-radius: 10px; gap: 8px;">
                <i class="fas fa-search mr-2"></i> Jelajahi Materi Baru
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xl-4 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white" style="border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block text-white-50 small font-weight-bold text-uppercase mb-1">Total Bab Diikuti</span>
                        <h2 class="font-weight-extrabold mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $totalBab }}</h2>
                    </div>
                    <div class="p-3 bg-white-10 rounded-circle" style="background: rgba(255,255,255,0.15);">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-4 mb-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px; border-left: 5px solid #10b981 !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase mb-1">Kategori Kursus Aktif</span>
                        <h2 class="font-weight-extrabold text-dark mb-0" style="font-size: 2.2rem; font-weight: 800;">{{ $totalMateri }}</h2>
                    </div>
                    <div class="p-3 bg-soft-success rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                        <i class="fas fa-book-open text-success fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-3">
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
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-3 p-md-4 bg-white" style="border-radius: 16px;">
                <h5 class="font-weight-bold text-dark mb-4">
                    <i class="fas fa-history mr-2 text-primary"></i>Timeline Aktivitas Belajar
                </h5>

                @if($history->count() > 0)
                    <div class="learning-timeline position-relative pl-4" style="border-left: 3px solid #e2e8f0; margin-left: 15px;">
                        @foreach($history as $item)
                            <div class="timeline-item position-relative mb-4 pb-2">
                                
                                <div class="timeline-dot position-absolute bg-primary rounded-circle shadow-sm" 
                                     style="width: 16px; height: 16px; left: -33px; top: 4px; border: 3px solid #fff; transition: all 0.3s;">
                                </div>

                                <div class="card border border-light shadow-none hover-shadow transition-all w-100" style="border-radius: 12px; border: 1px solid #f1f5f9 !important;">
                                    <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                        
                                        <div class="mb-3 mb-md-0">
                                            <span class="badge bg-soft-primary text-primary px-2.5 py-1.5 font-weight-bold mb-2 small" style="background: rgba(59, 130, 246, 0.1); border-radius: 6px;">
                                             p
                                            </span>

                                            <h4 class="h5 font-weight-bold text-dark mb-1 mt-1">
                                                Bab {{ $item->urutan }}: {{ $item->nama_sub }}
                                            </h4>

                                            <small class="text-muted d-block mt-2">
                                                <i class="far fa-clock mr-1 text-danger"></i> Mulai diakses pada: 
                                                <strong>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y, H:i') }} WIB</strong>
                                            </small>
                                        </div>

                                        <div>
                                            <a href="{{ route('siswa.umum.belajar', $item->sub_materi_id) }}" class="btn btn-outline-primary font-weight-bold px-4 py-2" style="border-radius: 8px; font-size: 0.85rem; transition: all 0.2s;">
                                                Lanjutkan Belajar <i class="fas fa-arrow-right ml-2" style="font-size: 0.75rem;"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center">
                        <div class="p-4 bg-light rounded-circle d-inline-block mb-3" style="width: 100px; height: 100px;">
                            <i class="fas fa-folder-open fa-3x text-muted"></i>
                        </div>
                        <h4 class="h5 font-weight-bold text-dark">Belum Ada Riwayat Belajar</h4>
                        <p class="text-muted small mx-auto max-w-sm px-4" style="max-width: 360px;">
                            Anda belum pernah mendaftar ke pelatihan manapun. Silakan buka katalog umum untuk mulai belajar materi pertama Anda.
                        </p>
                        <a href="{{ route('siswa.umum.index') }}" class="btn btn-primary mt-2 px-4 py-2 font-weight-bold shadow-sm" style="border-radius: 8px;">
                            Mulai Cari Materi
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection