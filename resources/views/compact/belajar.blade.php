@extends('layouts.compact')

@section('content')
<style>
    body { background-color: #f1f5f9 !important; } 
    .classroom-container { display: flex; min-height: calc(100vh - 65px); color: #334155; }
    .player-area { flex: 3; padding: 2rem; background: #f1f5f9; overflow-y: auto; }
    .sidebar-area { flex: 1; min-width: 360px; max-width: 420px; background: #ffffff; border-left: 1px solid #e2e8f0; display: flex; flex-direction: column; box-shadow: -2px 0 10px rgba(0,0,0,0.02); }
    
    @media (max-width: 991px) {
        .classroom-container { flex-direction: column; }
        .sidebar-area { max-width: 100%; min-width: 100%; border-left: none; border-top: 1px solid #e2e8f0; max-height: 50vh; }
    }

    .media-holder { background: #ffffff; border-radius: 12px; padding: 10px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.08); margin-bottom: 1.5rem; }
    .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px; background: #000; }
    .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
    .pdf-wrapper { width: 100%; height: 650px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }

    .materi-info-card { background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .sidebar-header { padding: 1.5rem; border-bottom: 1px solid #e2e8f0; background: #ffffff; }
    .sidebar-content { overflow-y: auto; flex-grow: 1; }
    .kurikulum-title { background: #f8fafc; color: #64748b; padding: 12px 20px; font-size: 0.8rem; letter-spacing: 1px; font-weight: 700; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }

    .playlist-item { display: flex; align-items: center; padding: 18px 20px; color: #475569; border-bottom: 1px solid #f1f5f9; text-decoration: none; transition: all 0.2s ease; border-left: 4px solid transparent; }
    .playlist-item:hover { background: #f1f5f9; color: #1e3a8a; text-decoration: none; }
    .playlist-item.active { background: #eff6ff; color: #1e40af; font-weight: 600; border-left-color: #2563eb; }
    
    .soal-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 20px; background: #f8fafc; }
    .opsi-label { display: block; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px 16px; margin-bottom: 10px; cursor: pointer; transition: all 0.2s; }
    .opsi-label:hover { background: #f1f5f9; border-color: #94a3b8; }
    .opsi-radio:checked + .opsi-text { font-weight: bold; color: #2563eb; }
    .opsi-radio { margin-right: 10px; }
</style>

<div class="container-fluid p-0">
    <div class="classroom-container">
        
        <div class="player-area">
            <div class="mb-4">
                <a href="{{ route('siswa.materi.index') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white" style="border-radius:8px; color:#64748b;"><i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog</a>
            </div>

            @foreach (['success', 'error', 'warning', 'info'] as $msg)
                @if(session($msg))
                    <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                        <i class="fas @if($msg == 'success') fa-check-circle @elseif($msg == 'error') fa-exclamation-circle @elseif($msg == 'warning') fa-exclamation-triangle @else fa-info-circle @endif mr-2"></i> 
                        {{ session($msg) }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endforeach

            @if(($contentType === 'pre' || $contentType === 'post') && $statusBeasiswaSiswa == 1)
                <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background: #ffffff;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge badge-pill {{ $contentType === 'pre' ? 'badge-warning' : 'badge-danger' }} px-3 py-2">
                            <i class="fas fa-file-signature mr-1"></i> {{ $contentType === 'pre' ? 'PRE-TEST (Awal Kelas)' : 'POST-TEST (Ujian Akhir)' }}
                        </span>
                        <span class="text-muted small font-weight-bold">Format: Pilihan Ganda</span>
                    </div>
                    
                    <h2 class="font-weight-bold text-dark mb-2">{{ $quizAktif->judul ?? 'Ujian Evaluasi' }}</h2>
                    <p class="text-muted mb-4">Silakan jawab pertanyaan di bawah ini dengan memilih salah satu opsi jawaban yang paling tepat.</p>
                    <hr>

                    <form action="{{ route('siswa.materi.simpan_test', [$materiAktif->id, $quizAktif->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="classid" value="{{ $materiAktif->id }}">
                        
                        @php
                            $daftarSoal = is_string($quizAktif->soal) ? json_decode($quizAktif->soal, true) : $quizAktif->soal;
                        @endphp

                        @if(is_array($daftarSoal) && count($daftarSoal) > 0)
                            @foreach($daftarSoal as $indexSoal => $item)
                                <div class="soal-card">
                                    <h6 class="font-weight-bold text-dark mb-3">
                                        <span class="badge badge-secondary mr-2">{{ $indexSoal + 1 }}</span> 
                                        {{ $item['pertanyaan'] ?? $item['Pertanyaan'] ?? '' }}
                                    </h6>
                                    
                                    <div class="mt-2">
                                        @if(isset($item['opsi']) && is_array($item['opsi']))
                                            @foreach($item['opsi'] as $keyOpsi => $valOpsi)
                                                <label class="opsi-label">
                                                    <input type="radio" name="jawaban[{{ $indexSoal }}]" value="{{ $keyOpsi }}" class="opsi-radio" required>
                                                    <span class="opsi-text"><strong>{{ $keyOpsi }}.</strong> {{ $valOpsi }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold shadow-sm" style="border-radius: 8px;">
                                    <i class="fas fa-paper-plane mr-2"></i> Submit Jawaban Anda
                                </button>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-exclamation-triangle fa-2x mb-2 text-warning"></i>
                                <p class="mb-0"><em>Format soal kuis tidak valid atau data kosong.</em></p>
                            </div>
                        @endif
                    </form>
                </div>

            @else
                @if($subMateriAktif)
                    <div class="media-holder">
                        @if($subMateriAktif->tipe_link == 0) 
                            <div class="video-wrapper">
                                <iframe src="{{ $embedUrl }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="pdf-wrapper">
                                <iframe src="{{ $subMateriAktif->link }}#toolbar=0" width="100%" height="100%" style="border: none;"></iframe>
                            </div>
                        @endif
                    </div>

                    <div class="materi-info-card">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-pill {{ $subMateriAktif->tipe_link == 0 ? 'badge-danger' : 'badge-success' }} px-3 py-2 mr-3">
                                <i class="fas {{ $subMateriAktif->tipe_link == 0 ? 'fa-play-circle' : 'fa-file-pdf' }} mr-1"></i> 
                                {{ $subMateriAktif->tipe_link == 0 ? 'Video Tutorial' : 'Modul PDF' }}
                            </span>
                            <span class="text-muted font-weight-bold small">Urutan Ke-{{ $subMateriAktif->urutan }}</span>
                        </div>
                        <h1 class="font-weight-bold text-dark mb-3" style="font-size: 1.8rem;">{{ $subMateriAktif->nama }}</h1>
                        <hr>
                        <p class="text-secondary" style="line-height: 1.8;">{{ $subMateriAktif->keterangan ?? 'Tidak ada deskripsi tambahan.' }}</p>
                    </div>
                @else
                    <div class="text-center py-5 bg-white shadow-sm border-0 rounded" style="border-radius:12px;">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-secondary mb-0">Belum ada materi pelajaran yang tersedia atau cocok untuk akun Anda.</p>
                    </div>
                @endif
            @endif
        </div>

        <div class="sidebar-area">
            <div class="sidebar-header">
                <span class="text-primary small text-uppercase font-weight-bold mb-1 d-block">{{ $materiAktif->kategori->nama }}</span>
                <h5 class="font-weight-bold text-dark mb-0">{{ $materiAktif->nama }}</h5>
            </div>
            
            <div class="sidebar-content">
                <div class="kurikulum-title">Kurikulum Kelas</div>
                
                @if($preTest && $statusBeasiswaSiswa == 1)
                    <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=pre" class="playlist-item {{ $contentType === 'pre' ? 'active' : '' }}">
                        <div class="mr-3">
                            <i class="fas fa-file-signature fa-lg text-warning"></i>
                        </div>
                        <div class="w-100">
                            <span class="d-block small text-muted font-weight-bold mb-1">TAHAP AWAL</span>
                            <div class="text-truncate font-weight-bold" style="font-size: 0.9rem;">📝 Pre-Test: {{ $preTest->judul }}</div>
                        </div>
                    </a>
                @endif

                <div class="bg-light px-4 py-2 text-muted font-weight-bold" style="font-size: 0.75rem;">
                    MATERI PELAJARAN ({{ count($materiAktif->subMateri) }} BAB)
                </div>
                
                @foreach($materiAktif->subMateri as $index => $sub)
                    @php
                        $openedLessons = session()->get("materi_progress_{$materiAktif->id}", []);
                        $isLocked = false;
                        $isWrongType = false;

                        // Pengecekan Hak Akses Beasiswa
                        if (($sub->tipe_beasiswa == 1 && $statusBeasiswaSiswa == 0) || 
                            ($sub->tipe_beasiswa == 2 && $statusBeasiswaSiswa == 1)) {
                            $isWrongType = true;
                            $isLocked = true;
                        }

                        // Kunci materi jika wajib pretest tapi belum dikerjakan (Hanya berlaku untuk penerima beasiswa)
                        if ($statusBeasiswaSiswa == 1 && $preTest && (!$userProgress || is_null($userProgress->nilai_awal))) {
                            $isLocked = true;
                        }
                        
                        // Logika Kunci Urutan Bab Berurutan (Mencegah Loncat Bab)
                        if ($index > 0 && !$isWrongType) {
                            $prevMateriValid = null;
                            for ($i = $index - 1; $i >= 0; $i--) {
                                $prevCheck = $materiAktif->subMateri[$i];
                                $isPrevWrongType = (($prevCheck->tipe_beasiswa == 1 && $statusBeasiswaSiswa == 0) || ($prevCheck->tipe_beasiswa == 2 && $statusBeasiswaSiswa == 1));
                                if (!$isPrevWrongType) {
                                    $prevMateriValid = $prevCheck;
                                    break;
                                }
                            }

                            if ($prevMateriValid && !in_array($prevMateriValid->id, $openedLessons)) {
                                $isLocked = true;
                            }
                        }
                    @endphp

                    @if($isLocked)
                        <div class="playlist-item text-muted" style="cursor: not-allowed; opacity: 0.5; background: #f8fafc;">
                            <div class="mr-3">
                                @if($isWrongType)
                                    <i class="fas fa-ban fa-lg text-danger"></i>
                                @else
                                    <i class="fas fa-lock fa-lg text-secondary"></i>
                                @endif
                            </div>
                            <div class="w-100">
                                <span class="d-block small text-muted mb-1">
                                    Materi {{ $index + 1 }} 
                                    @if($sub->tipe_beasiswa == 1)
                                        <span class="badge badge-warning text-dark font-weight-normal">Khusus Beasiswa</span>
                                    @elseif($sub->tipe_beasiswa == 2)
                                        <span class="badge badge-secondary text-white font-weight-normal">Non-Beasiswa</span>
                                    @endif
                                </span>
                                <div class="text-truncate" style="font-size: 0.9rem; text-decoration: line-through;">{{ $sub->nama }}</div>
                                @if($isWrongType)
                                    <small class="text-danger d-block" style="font-size: 11px;">Tidak tersedia di program Anda</small>
                                @endif
                            </div>
                        </div>
                    @else
                        <a href="{{ route('siswa.materi.belajar', [$materiAktif->id, $sub->id]) }}" class="playlist-item {{ $contentType === 'materi' && $subMateriAktif && $subMateriAktif->id == $sub->id ? 'active' : '' }}">
                            <div class="mr-3">
                                <i class="fas {{ $sub->tipe_link == 0 ? 'fa-play-circle text-danger' : 'fa-file-alt text-success' }} fa-lg opacity-75"></i>
                            </div>
                            <div class="w-100">
                                <span class="d-block small text-muted mb-1">
                                    Materi {{ $index + 1 }}
                                    @if($sub->tipe_beasiswa == 1)
                                        <span class="badge badge-warning text-dark font-weight-normal">Beasiswa</span>
                                    @elseif($sub->tipe_beasiswa == 2)
                                        <span class="badge badge-light border text-muted font-weight-normal">Umum</span>
                                    @endif
                                </span>
                                <div class="text-truncate" style="font-size: 0.9rem;">{{ $sub->nama }}</div>
                            </div>
                        </a>
                    @endif
                @endforeach

                @if($postTest && $statusBeasiswaSiswa == 1)
                    <div class="bg-light px-4 py-2 text-muted font-weight-bold" style="font-size: 0.75rem;">
                        TAHAP EVALUASI AKHIR
                    </div>
                    <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=post" class="playlist-item {{ $contentType === 'post' ? 'active' : '' }}">
                        <div class="mr-3">
                            <i class="fas fa-trophy fa-lg text-danger"></i>
                        </div>
                        <div class="w-100">
                            <span class="d-block small text-muted font-weight-bold mb-1">KELULUSAN</span>
                            <div class="text-truncate font-weight-bold" style="font-size: 0.9rem;">🏆 Post-Test: {{ $postTest->judul }}</div>
                        </div>
                    </a>
                @endif
            </div>
        </div>

    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection