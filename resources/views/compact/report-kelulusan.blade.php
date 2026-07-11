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
                    <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}" class="btn btn-white text-dark font-weight-bold px-4 py-2 w-sm-100" style="border-radius: 8px; background:#fff;">
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
    <div class="summary-box mb-4">
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
    </div>

    @if($tipeQuiz == 0 || ($tipeQuiz == 1 && $isLulus) || $isManajemen)
        <div class="review-card">
            <h4 class="font-weight-bold text-dark mb-1 h5-sm">
                <i class="fas fa-poll-h mr-2 text-primary"></i> 
                Analisis Jawaban - {{ $tipeQuiz == 0 ? 'Pre-Test' : 'Post-Test' }}
            </h4>
            <p class="text-muted small mb-3">Berikut adalah lembar koreksi lembar jawaban kuis.</p>
            <hr>

            @if(is_array($daftarSoal) && count($daftarSoal) > 0)
                @foreach($daftarSoal as $index => $item)
                    @php
                        $kunci = strtoupper(trim($item['jawaban'] ?? $item['Jawaban'] ?? ''));
                        $jawabanSiswa = isset($jawabanUser[$index]) ? strtoupper(trim($jawabanUser[$index])) : '';
                        $isBenar = ($kunci === $jawabanSiswa);
                    @endphp

                    <div class="soal-box mb-3 p-3 border" style="border-radius: 8px;">
                        <div class="d-flex flex-column-reverse flex-sm-row justify-content-sm-between align-items-sm-start gap-2 mb-3">
                            <h6 class="font-weight-bold text-dark mb-0 pr-sm-5" style="line-height: 1.5;">
                                <span class="badge badge-secondary mr-2">{{ $index + 1 }}</span>
                                {{ $item['pertanyaan'] ?? $item['Pertanyaan'] ?? '' }}
                            </h6>
                            <div>
                                @if($isBenar)
                                    <span class="badge bg-success text-white px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Benar</span>
                                @else
                                    <span class="badge bg-danger text-white px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Salah</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-2 pl-sm-4">
                            @if(isset($item['opsi']) && is_array($item['opsi']))
                                @foreach($item['opsi'] as $keyOpsi => $valOpsi)
                                    @php
                                        $keyOpsiUpper = strtoupper(trim($keyOpsi));
                                        $styleText = 'text-dark';
                                        $bgItem = 'background: transparent;';
                                        $icon = '<i class="far fa-circle mr-2 text-muted"></i>';
                                        
                                        if ($keyOpsiUpper === $kunci) {
                                            $styleText = 'text-success font-weight-bold';
                                            $bgItem = 'background: #f0fdf4; border-radius: 6px;';
                                            $icon = '<i class="fas fa-check-circle mr-2 text-success"></i>';
                                        }
                                        
                                        if ($keyOpsiUpper === $jawabanSiswa && !$isBenar) {
                                            $styleText = 'text-danger font-weight-bold';
                                            $bgItem = 'background: #fef2f2; border-radius: 6px;';
                                            $icon = '<i class="fas fa-times-circle mr-2 text-danger"></i>';
                                        }
                                    @endphp
                                    <div class="p-2 mb-1 border-bottom {{ $styleText }} d-flex align-items-start" style="font-size:0.9rem; {{ $bgItem }}">
                                        <span class="mr-1">{!! $icon !!}</span>
                                        <div class="text-wrap w-100">
                                            <strong>{{ $keyOpsiUpper }}.</strong> {{ $valOpsi }}
                                            @if($keyOpsiUpper === $jawabanSiswa)
                                                <span class="badge badge-light border text-muted ml-1 small font-weight-normal d-inline-block mt-1 mt-sm-0">(Jawaban Siswa)</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-exclamation-circle fa-3x mb-3 text-muted"></i>
                    <p>Tidak ada data tinjauan soal untuk kuis ini.</p>
                </div>
            @endif
        </div>
    @else
        <div class="card mt-4 border-0 shadow-sm text-center py-5" style="border-radius: 12px; background: #fff;">
            <div class="card-body px-3">
                <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                <h5 class="font-weight-bold text-dark">Analisis Jawaban Dikunci</h5>
                <p class="text-muted container px-2" style="max-width: 500px;">
                    Maaf, detail lembar jawaban belum dapat ditampilkan karena nilai Anda masih di bawah batas kelulusan (**KKM 70**). Silakan pelajari kembali materi dan ikuti ujian remedi.
                </p>
            </div>
        </div>
    @endif

</div>
@endsection