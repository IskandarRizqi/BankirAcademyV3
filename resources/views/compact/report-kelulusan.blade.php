@extends('layouts.compact')

@section('content')
<style>
    body { background-color: #f1f5f9 !important; }
    .report-container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
    
    /* Card Header Styling */
    .success-card { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3); }
    .failed-card { background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 100%); color: white; border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(220, 38, 220, 0.3); }
    .pretest-card { background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%); color: white; border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.3); }
    
    .score-badge { font-size: 3.5rem; font-weight: 800; background: rgba(255,255,255,0.2); display: inline-block; padding: 0.5rem 2rem; border-radius: 12px; margin: 1rem 0; }
    
    /* Comparison Score Dashboard */
    .summary-box { background: #ffffff; border-radius: 12px; padding: 1.5rem; margin-top: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .score-card-mini { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.25rem; text-align: center; }
    
    /* Review Questions Styling */
    .review-card { background: #ffffff; border-radius: 12px; padding: 1.5rem; margin-top: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .soal-box { border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 15px; background: #f8fafc; position: relative; }
    .status-badge { float: right; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }
</style>

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
            <div class="mb-3"><i class="fas fa-file-signature fa-4x text-white"></i></div>
            <h1 class="font-weight-bold text-white">Hasil Pre-Test Berhasil Disimpan</h1>
            <p class="lead mb-2 text-white">Terima kasih telah menyelesaikan evaluasi awal untuk kelas <strong>{{ $materiAktif->nama }}</strong></p>
            <div class="score-badge">{{ round($progressAktif->nilai_awal) }}</div>
            <div>
                <span class="badge badge-pill badge-light text-warning font-weight-bold px-3 py-2">Tahap Terbuka: Silakan Masuk Ke Materi</span>
            </div>
            <div class="mt-4">
                <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}" class="btn btn-white text-dark font-weight-bold px-4 py-2" style="border-radius: 8px; background:#fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <i class="fas fa-book-open mr-2 text-warning"></i> Mulai Belajar Materi
                </a>
            </div>
        </div>
    @else
        @if($progressAktif->nilai_akhir >= 70)
            <div class="success-card mb-4">
                <div class="mb-3"><i class="fas fa-trophy fa-4x text-warning"></i></div>
                <h1 class="font-weight-bold text-white">Selamat! Anda Lulus</h1>
                <p class="lead mb-2 text-white">Anda telah menyelesaikan Post-Test untuk kelas <strong>{{ $materiAktif->nama }}</strong></p>
                <div class="score-badge">{{ round($progressAktif->nilai_akhir) }}</div>
                <div>
                    <span class="badge badge-pill badge-success px-3 py-2">Status: LULUS (KKM 70)</span>
                </div>
                <div class="mt-4">
                    <a href="{{ route('siswa.materi.index') }}" class="btn btn-warning font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        <i class="fas fa-th mr-2"></i> Kembali ke Katalog Materi
                    </a>
                </div>
            </div>
        @else
            <div class="failed-card mb-4">
                <div class="mb-3"><i class="fas fa-times-circle fa-4x text-white"></i></div>
                <h1 class="font-weight-bold">Belum Mencapai Batas Kelulusan</h1>
                <p class="lead mb-2">Hasil evaluasi akhir Anda untuk kelas <strong>{{ $materiAktif->nama }}</strong></p>
                <div class="score-badge">{{ round($progressAktif->nilai_akhir) }}</div>
                <div>
                    <span class="badge badge-pill badge-warning px-3 py-2">Status: TIDAK LULUS (KKM 70)</span>
                </div>
                <div class="mt-4">
                    <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=post" class="btn btn-light text-danger font-weight-bold px-4 py-2" style="border-radius: 8px; background:#fff;">
                        <i class="fas fa-sync mr-2"></i> Coba Remedi Ujian Kembali
                    </a>
                </div>
            </div>
        @endif
    @endif

    {{-- DASHBOARD RINGKASAN PERBANDINGAN NILAI (PRE-TEST VS POST-TEST) --}}
    <div class="summary-box">
        <h5 class="font-weight-bold text-dark mb-3">
            <i class="fas fa-chart-bar mr-2 text-info"></i> Ringkasan Evaluasi Modul
        </h5>
        <div class="row">
            {{-- Kolom Pre Test --}}
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
            {{-- Kolom Post Test --}}
            <div class="col-md-6">
                <div class="score-card-mini">
                    <span class="text-uppercase small text-muted font-weight-bold d-block mb-1">Nilai Post-Test (Terakhir)</span>
                    @if($postTestRecord)
                        <h2 class="font-weight-bold mb-0 {{ $postTestRecord->nilai_akhir >= 70 ? 'text-success' : 'text-danger' }}">
                            {{ round($postTestRecord->nilai_akhir) }}
                        </h2>
                        <span class="text-muted small">Percobaan Ke-{{ $postTestRecord->jml_jawaban }}</span>
                    @else
                        <h2 class="font-weight-bold text-muted mb-0">-</h2>
                        <span class="text-muted small">Belum Mengikuti Post-Test</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="review-card">
        <h4 class="font-weight-bold text-dark mb-1">
            <i class="fas fa-poll-h mr-2 text-primary"></i> 
            Analisis Jawaban - {{ $tipeQuiz == 0 ? 'Pre-Test' : 'Post-Test' }}
        </h4>
        <p class="text-muted small mb-3">Berikut adalah lembar koreksi lembar jawaban kuis yang baru saja Anda kirimkan.</p>
        <hr>

        @if(is_array($daftarSoal) && count($daftarSoal) > 0)
            @foreach($daftarSoal as $index => $item)
                @php
                    // Ambil kunci jawaban yang benar
                    $kunci = strtoupper(trim($item['jawaban'] ?? $item['Jawaban'] ?? ''));
                    
                    // Ambil jawaban siswa berdasarkan index iterasi soal saat ini
                    $jawabanSiswa = isset($jawabanUser[$index]) ? strtoupper(trim($jawabanUser[$index])) : '';
                    
                    // Cek apakah jawaban siswa benar
                    $isBenar = ($kunci === $jawabanSiswa);
                @endphp

                <div class="soal-box">
                    <div>
                        @if($isBenar)
                            <span class="status-badge bg-success text-white"><i class="fas fa-check-circle mr-1"></i> Benar</span>
                        @else
                            <span class="status-badge bg-danger text-white"><i class="fas fa-times-circle mr-1"></i> Salah</span>
                        @endif
                        
                        <h6 class="font-weight-bold text-dark mb-3 pr-5" style="line-height: 1.5;">
                            <span class="badge badge-secondary mr-2">{{ $index + 1 }}</span>
                            {{ $item['pertanyaan'] ?? $item['Pertanyaan'] ?? '' }}
                        </h6>
                    </div>

                    <div class="mt-2 pl-4">
                        @if(isset($item['opsi']) && is_array($item['opsi']))
                            @foreach($item['opsi'] as $keyOpsi => $valOpsi)
                                @php
                                    $keyOpsiUpper = strtoupper(trim($keyOpsi));
                                    $styleText = 'text-dark';
                                    $bgItem = 'background: transparent;';
                                    $icon = '<i class="far fa-circle mr-2 text-muted"></i>';
                                    
                                    // Jika Opsi ini adalah Kunci Jawaban yang Benar
                                    if ($keyOpsiUpper === $kunci) {
                                        $styleText = 'text-success font-weight-bold';
                                        $bgItem = 'background: #f0fdf4; border-radius: 6px;';
                                        $icon = '<i class="fas fa-check-circle mr-2 text-success"></i>';
                                    }
                                    
                                    // Jika Opsi ini dipilih Siswa tapi Ternyata Salah
                                    if ($keyOpsiUpper === $jawabanSiswa && !$isBenar) {
                                        $styleText = 'text-danger font-weight-bold';
                                        $bgItem = 'background: #fef2f2; border-radius: 6px;';
                                        $icon = '<i class="fas fa-times-circle mr-2 text-danger"></i>';
                                    }
                                @endphp
                                <div class="p-2 mb-1 border-bottom {{ $styleText }}" style="font-size:0.9rem; {{ $bgItem }}">
                                    {!! $icon !!} <strong>{{ $keyOpsiUpper }}.</strong> {{ $valOpsi }}
                                    
                                    @if($keyOpsiUpper === $jawabanSiswa)
                                        <span class="badge badge-light border text-muted ml-2 small font-weight-normal">(Jawaban Anda)</span>
                                    @endif
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

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection