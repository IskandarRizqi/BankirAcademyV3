@extends('layouts.compact')

@section('content')
<div class="report-container">

    {{-- Alert Flash Session --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius:10px;"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius:10px;"><i class="fas fa-exclamation-triangle mr-2"></i> {{ session('warning') }}</div>
    @endif
    
    {{-- Banner Status Utama Berdasarkan Skor Ujian Saat ini --}}
    @if($tipeQuiz == 0)
        <div class="pretest-card mb-4">
            <div class="mb-3"><i class="fas fa-file-signature fa-4x text-white icon-header"></i></div>
            
            @if($isManajemen)
                <h1 class="font-weight-bold text-white title-responsive">Laporan Hasil Pre-Test Siswa</h1>
                <p class="lead mb-2 text-white desc-responsive">Rekapitulasi nilai evaluasi awal siswa pada modul <strong>{{ $materiAktif->nama }}</strong></p>
            @else
                <h1 class="font-weight-bold text-white title-responsive">Hasil Pre-Test Berhasil Disimpan</h1>
                <p class="lead mb-2 text-white desc-responsive">Terima kasih telah menyelesaikan evaluasi awal untuk kelas <strong>{{ $materiAktif->nama }}</strong></p>
            @endif

            <div class="score-badge">{{ round($progressAktif->nilai_awal) }}</div>
            
            <div class="mb-3">
                <span class="badge badge-pill badge-light text-warning font-weight-bold px-3 py-2 text-wrap">Jenis Evaluasi: Pre-Test</span>
            </div>

            <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                @if($isManajemen)
                    <a href="{{ route('manajemen.laporan.index') }}" class="btn btn-white text-dark font-weight-bold px-4 py-2 w-sm-100" style="border-radius: 8px; background:#fff;">
                        <i class="fas fa-arrow-left mr-2 text-primary"></i> Kembali ke Panel Laporan
                    </a>
                @else
                    <a href="{{ route('siswa.materi.index') }}" class="btn btn-white text-dark font-weight-bold px-4 py-2 w-sm-100" style="border-radius: 8px; background:#fff;">
                        <i class="fas fa-book-open mr-2 text-warning"></i> Mulai Belajar Materi
                    </a>
                @endif
            </div>
        </div>
    @else
        @if($progressAktif->nilai_akhir >= 70)
            <div class="success-card mb-4">
                <div class="mb-3"><i class="fas fa-trophy fa-4x text-warning icon-header"></i></div>
                
                @if($isManajemen)
                    <h1 class="font-weight-bold text-white title-responsive">Laporan Hasil Post-Test (Lulus)</h1>
                    <p class="lead mb-2 text-white desc-responsive">Siswa dinyatakan lulus pada modul <strong>{{ $materiAktif->nama }}</strong></p>
                @else
                    <h1 class="font-weight-bold text-white title-responsive">Selamat! Anda Lulus</h1>
                    <p class="lead mb-2 text-white desc-responsive">Anda telah menyelesaikan Post-Test untuk kelas <strong>{{ $materiAktif->nama }}</strong></p>
                @endif

                <div class="score-badge">{{ round($progressAktif->nilai_akhir) }}</div>
                <div class="mb-3">
                    <span class="badge badge-pill badge-success px-3 py-2 text-wrap">Status: LULUS (KKM 70)</span>
                </div>
                
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                    @if($isManajemen)
                        <a href="{{ route('manajemen.laporan.index') }}" class="btn btn-warning font-weight-bold px-4 py-2 w-sm-100" style="border-radius: 8px;">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Panel Laporan
                        </a>
                    @else
                        <a href="{{ route('siswa.materi.index') }}" class="btn btn-warning font-weight-bold px-4 py-2 w-sm-100" style="border-radius: 8px;">
                            <i class="fas fa-th mr-2"></i> Kembali ke Katalog Materi
                        </a>
                    @endif

                    {{-- TOMBOL DOWNLOAD SERTIFIKAT DI PERTAHANKAN --}}
                    @if($sertifikatMateri)
                        @if($sertifikatMateri->target_type == 'sub_materi')
                            <a href="{{ route('submateri.sertifikat', $sertifikatMateri->sub_materi_id) }}" class="btn btn-light text-primary font-weight-bold px-4 py-2 w-sm-100" style="border-radius:8px;">
                                <i class="fas fa-download mr-2"></i> Unduh Sertifikat (PDF)
                            </a>
                        @else
                            <a href="{{ route('materi.sertifikat', $materiAktif->id) }}" class="btn btn-light text-primary font-weight-bold px-4 py-2 w-sm-100" style="border-radius:8px;">
                                <i class="fas fa-download mr-2"></i> Unduh Sertifikat (PDF)
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        @else
            <div class="failed-card mb-4">
                <div class="mb-3"><i class="fas fa-times-circle fa-4x text-white icon-header"></i></div>
                
                @if($isManajemen)
                    <h1 class="font-weight-bold text-white title-responsive">Laporan Hasil Post-Test (Belum Lulus)</h1>
                    <p class="lead mb-2 text-white desc-responsive">Hasil evaluasi akhir siswa pada modul <strong>{{ $materiAktif->nama }}</strong></p>
                @else
                    <h1 class="font-weight-bold text-white title-responsive">Belum Mencapai Batas Kelulusan</h1>
                    <p class="lead mb-2 text-white desc-responsive">Hasil evaluasi akhir Anda untuk kelas <strong>{{ $materiAktif->nama }}</strong></p>
                @endif

                <div class="score-badge">{{ round($progressAktif->nilai_akhir) }}</div>
                <div class="mb-3">
                    <span class="badge badge-pill badge-warning px-3 py-2 text-wrap">Status: TIDAK LULUS (KKM 70)</span>
                </div>
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                    @if($isManajemen)
                        <a href="{{ route('manajemen.laporan.index') }}" class="btn btn-light text-dark font-weight-bold px-4 py-2 w-sm-100" style="border-radius: 8px; background:#fff;">
                            <i class="fas fa-arrow-left mr-2 text-primary"></i> Kembali ke Panel Laporan
                        </a>
                    @else
                        <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=post" class="btn btn-light text-danger font-weight-bold px-4 py-2 w-sm-100" style="border-radius: 8px; background:#fff;">
                            <i class="fas fa-sync mr-2"></i> Coba Remedi Ujian Kembali
                        </a>
                    @endif
                </div>
            </div>
        @endif
    @endif

    {{-- DASHBOARD RINGKASAN PERBANDINGAN NILAI --}}
    <!-- <div class="summary-box mb-4">
        <h5 class="font-weight-bold text-dark mb-3">
            <i class="fas fa-chart-bar mr-2 text-info"></i> Ringkasan Evaluasi Modul
        </h5>
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="score-card-mini">
                    <span class="text-uppercase small text-muted font-weight-bold d-block mb-1">Nilai Pre-Test</span>
                    @if($preTestRecord)
                        <h2 class="font-weight-bold text-warning mb-0">{{ round($preTestRecord->nilai_awal) }}</h2>
                        <span class="text-muted small">Dikerjakan pada: {{ $preTestRecord->created_at ? $preTestRecord->created_at->format('d M Y H:i') : '-' }}</span>
                    @else
                        <h2 class="font-weight-bold text-muted mb-0">-</h2>
                        <span class="text-muted small">Belum Mengikuti Pre-Test</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="score-card-mini">
                    <span class="text-uppercase small text-muted font-weight-bold d-block mb-1">Nilai Post-Test (Terakhir)</span>
                    @if($postTestRecord)
                        <h2 class="font-weight-bold mb-0 {{ $postTestRecord->nilai_akhir >= 70 ? 'text-success' : 'text-danger' }}">
                            {{ round($postTestRecord->nilai_akhir) }}
                        </h2>
                        <span class="text-muted small">Percobaan Ke-{{ $postTestRecord->jml_jawaban ?? 1 }}</span>
                    @else
                        <h2 class="font-weight-bold text-muted mb-0">-</h2>
                        <span class="text-muted small">Belum Mengikuti Post-Test</span>
                    @endif
                </div>
            </div>
        </div>
    </div> -->

</div>
@endsection