@extends('layouts.compact')

@section('content')
<div class="row container" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="classroom-container">
            
            <div class="player-area">
                <div class="mb-4">
                    <a href="{{ route('siswa.materi.index') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white" style="border-radius:8px; color:#64748b;">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
                    </a>
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
                    @if($quizAktif)
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
                                        <div class="soal-card mb-4 p-3 border rounded bg-light">
                                            <h6 class="font-weight-bold text-dark mb-3">
                                                <span class="badge badge-secondary mr-2">{{ $indexSoal + 1 }}</span> 
                                                {{ $item['pertanyaan'] ?? $item['Pertanyaan'] ?? '' }}
                                            </h6>
                                            
                                            <div class="mt-2">
                                                @if(isset($item['opsi']) && is_array($item['opsi']))
                                                    @foreach($item['opsi'] as $keyOpsi => $valOpsi)
                                                        <label class="opsi-label d-block mb-2 style='cursor:pointer;'">
                                                            <input type="radio" name="jawaban[{{ $indexSoal }}]" value="{{ $keyOpsi }}" class="opsi-radio mr-2" required>
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
                        <div class="text-center py-5 bg-white shadow-sm border-0 rounded" style="border-radius:12px;">
                            <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                            <p class="text-secondary mb-0">Data ujian tidak ditemukan.</p>
                        </div>
                    @endif

                @else
                    @if($subMateriAktif)
                        <div class="media-holder mb-4">
                            @if($subMateriAktif->tipe_link == 0) 
                                <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                    <iframe src="{{ $embedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @else
                               <div class="pdf-wrapper" style="height: 600px;">
    <!-- UBAH $subMateriAktif->link MENJADI $embedUrl -->
    <iframe src="{{ $embedUrl }}" width="100%" height="100%" style="border: none;"></iframe>
</div>
                            @endif
                        </div>

                        <div class="materi-info-card bg-white p-4 shadow-sm rounded" style="border-radius: 12px;">
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
                <div class="sidebar-header p-4 bg-white border-bottom">
                    <span class="text-primary small text-uppercase font-weight-bold mb-1 d-block">{{ $materiAktif->kategori->nama }}</span>
                    <h5 class="font-weight-bold text-dark mb-0">{{ $materiAktif->nama }}</h5>
                </div>
                
                <div class="sidebar-content bg-white">
                    <div class="kurikulum-title px-4 py-3 font-weight-bold text-dark" style="background:#f8fafc; border-bottom:1px solid #edf2f7;">Kurikulum Kelas</div>
                    
                    @if($preTest && $statusBeasiswaSiswa == 1)
                        <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=pre" class="playlist-item d-flex align-items-center p-3 text-decoration-none {{ $contentType === 'pre' ? 'active bg-light font-weight-bold' : '' }}" style="border-bottom: 1px solid #edf2f7;">
                            <div class="mr-3">
                                <i class="fas fa-file-signature fa-lg text-warning"></i>
                            </div>
                            <div class="w-100">
                                <span class="d-block small text-muted font-weight-bold mb-1">TAHAP AWAL</span>
                                <div class="text-truncate text-dark" style="font-size: 0.9rem;">📝 Pre-Test: {{ $preTest->judul }}</div>
                            </div>
                        </a>
                    @endif

                    <div class="bg-light px-4 py-2 text-muted font-weight-bold" style="font-size: 0.75rem; border-bottom: 1px solid #edf2f7;">
                        MATERI PELAJARAN ({{ count($materiAktif->subMateri) }} BAB)
                    </div>
                    
                    @foreach($materiAktif->subMateri as $index => $sub)
                        @php
                            $openedLessons = session()->get("materi_progress_{$materiAktif->id}", []);
                            $isLocked = false;

                            // Kunci materi jika siswa beasiswa belum menyelesaikan Pre-test
                            if ($statusBeasiswaSiswa == 1 && $preTest && (!$userProgress || is_null($userProgress->nilai_awal))) {
                                $isLocked = true;
                            }
                            
                            // Kunci materi jika melompati urutan bab
                            if ($index > 0) {
                                $prevMateriValid = $materiAktif->subMateri[$index - 1];
                                if ($prevMateriValid && !in_array($prevMateriValid->id, $openedLessons)) {
                                    $isLocked = true;
                                }
                            }
                        @endphp

                        @if($isLocked)
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3">
                                    <i class="fas fa-lock fa-lg text-secondary"></i>
                                </div>
                                <div class="w-100">
                                    <span class="d-block small text-muted mb-1">Materi {{ $index + 1 }}</span>
                                    <div class="text-truncate" style="font-size: 0.9rem;">{{ $sub->nama }}</div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('siswa.materi.belajar', [$materiAktif->id, $sub->id]) }}" class="playlist-item d-flex align-items-center p-3 text-decoration-none {{ $contentType === 'materi' && $subMateriAktif && $subMateriAktif->id == $sub->id ? 'active bg-light font-weight-bold' : '' }}" style="border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3">
                                    <i class="fas {{ $sub->tipe_link == 0 ? 'fa-play-circle text-danger' : 'fa-file-alt text-success' }} fa-lg"></i>
                                </div>
                                <div class="w-100">
                                    <span class="d-block small text-muted mb-1 text-uppercase">Materi {{ $index + 1 }}</span>
                                    <div class="text-truncate text-dark" style="font-size: 0.9rem;">{{ $sub->nama }}</div>
                                </div>
                            </a>
                        @endif
                    @endforeach

                   @if($postTest && $statusBeasiswaSiswa == 1)
                        <div class="bg-light px-4 py-2 text-muted font-weight-bold" style="font-size: 0.75rem; border-top: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;">
                            TAHAP EVALUASI AKHIR
                        </div>

                        @php
                            // Ambil total materi & progress session untuk menentukan status gembok Post-Test
                            $openedLessons = session()->get("materi_progress_{$materiAktif->id}", []);
                            $isPostTestLocked = count($openedLessons) < count($materiAktif->subMateri);
                        @endphp

                        @if($isPostTestLocked)
                            <!-- Tampilan Kuis Terkunci -->
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3">
                                    <i class="fas fa-lock fa-lg text-secondary"></i>
                                </div>
                                <div class="w-100">
                                    <span class="d-block small text-muted font-weight-bold mb-1">KELULUSAN</span>
                                    <div class="text-truncate" style="font-size: 0.9rem;">🏆 Post-Test: {{ $postTest->judul }}</div>
                                    <small class="text-danger d-block mt-1"><i class="fas fa-info-circle mr-1"></i>Selesaikan semua materi untuk membuka</small>
                                </div>
                            </div>
                        @else
                            <!-- Tampilan Kuis Terbuka -->
                            <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=post" class="playlist-item d-flex align-items-center p-3 text-decoration-none {{ $contentType === 'post' ? 'active bg-light font-weight-bold' : '' }}">
                                <div class="mr-3">
                                    <i class="fas fa-trophy fa-lg text-danger"></i>
                                </div>
                                <div class="w-100">
                                    <span class="d-block small text-muted font-weight-bold mb-1">KELULUSAN</span>
                                    <div class="text-truncate text-dark" style="font-size: 0.9rem;">🏆 Post-Test: {{ $postTest->judul }}</div>
                                </div>
                            </a>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection