@extends('layouts.compact')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-3" id="cancel-row">
    
    <!-- 1. JUDUL UTAMA (Paling atas, tepat di bawah tombol kembali) -->
    <div class="row mb-3">
        <div class="col-12">
            <!-- Tombol Kembali -->
            <div class="mb-2">
                <a href="{{ route('siswa.materi.index') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white d-inline-flex align-items-center shadow-sm" style="border-radius:8px; color:#64748b;">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
                </a>
            </div>
            
            <!-- Informasi Bab & Judul Konten yang sedang aktif -->
            <div class="bg-white p-3 rounded shadow-sm border">
                <span class="text-primary small text-uppercase font-weight-bold d-block mb-1">
                    {{ $materiAktif->nama }} &middot; <span class="text-muted">Urutan Ke-{{ $subMateriAktif->urutan ?? 1 }}</span>
                </span>
                <h1 class="font-weight-bold text-dark h4 mb-0">
                    @if(($contentType === 'pre' || $contentType === 'post'))
                        {{ $contentType === 'pre' ? 'PRE-TEST: ' . ($quizAktif->judul ?? '') : 'POST-TEST: ' . ($quizAktif->judul ?? '') }}
                    @else
                        {{ $subMateriAktif->nama ?? 'Pilih Materi' }}
                    @endif
                </h1>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Area Utama (Kiri di Desktop, Atas di Mobile) -->
        <div class="col-12 col-lg-8 mb-4">
            
            <!-- Notifikasi Flash -->
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

            <!-- TAMPILAN KUIS (PRE/POST TEST) -->
            @if(($contentType === 'pre' || $contentType === 'post') && $statusBeasiswaSiswa == 1)
                @if($quizAktif)
                    <div class="card shadow-sm border-0 p-3 p-md-4" style="border-radius: 12px; background: #ffffff;">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <span class="badge badge-pill {{ $contentType === 'pre' ? 'badge-warning' : 'badge-danger' }} px-3 py-2">
                                <i class="fas fa-file-signature mr-1"></i> {{ $contentType === 'pre' ? 'PRE-TEST (Awal Kelas)' : 'POST-TEST (Ujian Akhir)' }}
                            </span>
                            <span class="text-muted small font-weight-bold">Format: Pilihan Ganda</span>
                        </div>
                        
                        <p class="text-muted small mb-4">Silakan jawab pertanyaan di bawah ini dengan memilih salah satu opsi jawaban yang paling tepat.</p>
                        <hr>

                        <form action="{{ route('siswa.materi.simpan_test', [$materiAktif->id, $quizAktif->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="classid" value="{{ $materiAktif->id }}">
                            
                            @php
                                $daftarSoal = is_string($quizAktif->soal) ? json_decode($quizAktif->soal, true) : $quizAktif->soal;
                            @endphp

                            @if(is_array($daftarSoal) && count($daftarSoal) > 0)
                                @foreach($daftarSoal as $indexSoal => $item)
                                    <div class="soal-card mb-4 p-3 border rounded bg-light shadow-sm">
                                        <h6 class="font-weight-bold text-dark mb-3 d-flex align-items-start" style="line-height: 1.5;">
                                            <span class="badge badge-secondary mr-2 px-2 py-1">{{ $indexSoal + 1 }}</span> 
                                            <span class="flex-grow-1">{{ $item['pertanyaan'] ?? $item['Pertanyaan'] ?? '' }}</span>
                                        </h6>
                                        
                                        <div class="mt-2 pl-md-4">
                                            @if(isset($item['opsi']) && is_array($item['opsi']))
                                                @foreach($item['opsi'] as $keyOpsi => $valOpsi)
                                                    <label class="opsi-label d-block p-2.5 mb-2 border rounded bg-white shadow-sm position-relative d-flex align-items-center" style="cursor: pointer; transition: all 0.2s;">
                                                        <input type="radio" name="jawaban[{{ $indexSoal }}]" value="{{ $keyOpsi }}" class="opsi-radio mr-3" required style="width: 18px; height: 18px; flex-shrink: 0;">
                                                        <span class="opsi-text text-dark small"><strong>{{ $keyOpsi }}.</strong> {{ $valOpsi }}</span>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div class="text-right mt-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-md-inline px-5 py-2.5 font-weight-bold shadow-sm" style="border-radius: 8px;">
                                        <i class="fas fa-paper-plane mr-2"></i> Kirim Jawaban
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

            <!-- TAMPILAN MATERI (MULTI MEDIA ITEM) -->
            @else
                @if($subMateriAktif)
                    <!-- BOX CANVAS PLAYER/VIEWER MEDIA -->
                    <div class="media-holder mb-4 shadow-sm bg-black rounded overflow-hidden">
                        @if($itemAktif)
                            @if($itemAktif->tipe_link_item == 0) 
                                <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                                    <iframe src="{{ $embedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="pdf-wrapper" style="height: 500px; max-height: 75vh;">
                                    <iframe src="{{ $embedUrl }}" width="100%" height="100%" style="border: none;"></iframe>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5 text-white">
                                <p class="mb-0"><em>Media belum tersedia untuk bab pembelajaran ini.</em></p>
                            </div>
                        @endif
                    </div>

                    <!-- DESKRIPSI SUB MATERI -->
                    <div class="materi-info-card bg-white p-3 p-md-4 shadow-sm rounded" style="border-radius: 12px;">
                        @if($itemAktif)
                            <div class="mb-2">
                                <span class="badge badge-pill {{ $itemAktif->tipe_link_item == 0 ? 'badge-danger' : 'badge-success' }} px-3 py-2">
                                    <i class="fas {{ $itemAktif->tipe_link_item == 0 ? 'fa-play-circle' : 'fa-file-pdf' }} mr-1"></i> 
                                    Sedang Dibuka: {{ $itemAktif->judul_item }}
                                </span>
                            </div>
                        @endif
                        <p class="text-secondary small mt-3" style="line-height: 1.7; white-space: pre-line;">{{ $subMateriAktif->keterangan ?? 'Tidak ada deskripsi tambahan.' }}</p>
                    </div>
                @else
                    <div class="text-center py-5 bg-white shadow-sm border-0 rounded" style="border-radius:12px;">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-secondary mb-0 px-3">Belum ada materi pelajaran yang tersedia atau cocok untuk akun Anda.</p>
                    </div>
                @endif
            @endif
        </div>

        <!-- Area Sidebar Kurikulum (Kanan di Desktop, Bawah di Mobile) -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="border-radius: 12px; overflow: hidden; top: 20px; z-index: 10;">
                <div class="sidebar-header p-3 bg-white border-bottom">
                    <span class="text-primary small text-uppercase font-weight-bold mb-1 d-block">{{ $materiAktif->kategori->nama }}</span>
                    <h5 class="font-weight-bold text-dark mb-0 h6" style="line-height: 1.4;">{{ $materiAktif->nama }}</h5>
                </div>
                
                <div class="sidebar-content bg-white" style="max-height: 65vh; overflow-y: auto;">
                    <div class="kurikulum-title px-3 py-2.5 font-weight-bold text-dark" style="background:#f8fafc; border-bottom:1px solid #edf2f7; font-size: 0.85rem;">
                        <i class="fas fa-list-ol mr-2 text-primary"></i>Kurikulum Kelas
                    </div>
                    
                    <!-- PRE TEST -->
                    @if($preTest && $statusBeasiswaSiswa == 1)
                        <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=pre" class="playlist-item d-flex align-items-center p-3 text-decoration-none {{ $contentType === 'pre' ? 'active bg-light font-weight-bold' : '' }}" style="border-bottom: 1px solid #edf2f7;">
                            <div class="mr-3 flex-shrink-0">
                                <i class="fas fa-file-signature fa-lg text-warning"></i>
                            </div>
                            <div class="w-100 overflow-hidden">
                                <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem;">TAHAP AWAL</span>
                                <div class="text-truncate text-dark small font-weight-normal">{{ $preTest->judul }}</div>
                            </div>
                        </a>
                    @endif

                    <!-- DAFTAR BAB UTAMA -->
                    <div class="bg-light px-3 py-2 text-muted font-weight-bold border-bottom" style="font-size: 0.7rem;">
                        MATERI PELAJARAN ({{ count($materiAktif->subMateri) }} BAB)
                    </div>
                    
                    @foreach($materiAktif->subMateri as $index => $sub)
                        @php
                            $openedLessons = session()->get("materi_progress_{$materiAktif->id}", []);
                            $isLocked = false;

                            if ($statusBeasiswaSiswa == 1 && $preTest && (!$userProgress || is_null($userProgress->nilai_awal))) {
                                $isLocked = true;
                            }
                            
                            if ($index > 0) {
                                $prevMateriValid = $materiAktif->subMateri[$index - 1];
                                if ($prevMateriValid && !in_array($prevMateriValid->id, $openedLessons)) {
                                    $isLocked = true;
                                }
                            }
                            
                            $isBabAktif = ($contentType === 'materi' && $subMateriAktif && $subMateriAktif->id == $sub->id);
                        @endphp

                        @if($isLocked)
                            <!-- Tampilan Bab Terkunci -->
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 flex-shrink-0">
                                    <i class="fas fa-lock text-secondary"></i>
                                </div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted mb-1" style="font-size: 0.65rem;">Materi {{ $index + 1 }}</span>
                                    <div class="text-truncate small">{{ $sub->nama }}</div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;"><i class="fas fa-layer-group mr-1"></i> Terdiri dari {{ $sub->items->count() }} Media</small>
                                </div>
                            </div>
                        @else
                            <!-- Tampilan Bab Terbuka -->
                            <div class="p-3 {{ $isBabAktif ? 'bg-light border-left-primary' : '' }}" style="border-bottom: 1px solid #edf2f7;">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="mr-3 flex-shrink-0">
                                        <i class="fas {{ $sub->items->count() > 1 ? 'fa-boxes text-primary' : ($sub->items->first() && $sub->items->first()->tipe_link_item == 1 ? 'fa-file-alt text-success' : 'fa-play-circle text-danger') }}"></i>
                                    </div>
                                    <div class="w-100 overflow-hidden">
                                        <span class="d-block text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem;">Materi {{ $index + 1 }}</span>
                                        <div class="text-truncate text-dark small {{ $isBabAktif ? 'font-weight-bold' : '' }}">{{ $sub->nama }}</div>
                                    </div>
                                </div>

                                <!-- 2. MODIFIKASI: DAFTAR MEDIA SEKARANG BERADA DI DALAM SINI (NESTED) -->
                                @if($sub->items && $sub->items->count() > 0)
                                    <div class="mt-2 pl-3 border-left ml-2">
                                        @foreach($sub->items as $mediaItem)
                                            @php
                                                $isMediaActive = ($itemAktif && $itemAktif->id == $mediaItem->id);
                                            @endphp
                                            <a href="{{ route('siswa.materi.belajar', [$materiAktif->id, $sub->id]) }}?item_id={{ $mediaItem->id }}" 
                                               class="d-flex align-items-center py-2 px-2 my-1 rounded text-decoration-none small transition-all item-link-media {{ $isMediaActive ? 'bg-primary text-white font-weight-bold shadow-sm' : 'text-secondary hover-bg-light' }}"
                                               style="font-size: 0.78rem;">
                                                <i class="fas {{ $mediaItem->tipe_link_item == 0 ? 'fa-play-circle' : 'fa-file-pdf' }} mr-2 {{ $isMediaActive ? 'text-white' : 'text-muted' }}"></i>
                                                <span class="text-truncate">{{ $mediaItem->judul_item }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    <!-- POST TEST -->
                    @if($postTest && $statusBeasiswaSiswa == 1)
                        @php
                            $openedLessons = session()->get("materi_progress_{$materiAktif->id}", []);
                            $isPostTestLocked = count($openedLessons) < count($materiAktif->subMateri);
                        @endphp

                        @if($isPostTestLocked)
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 flex-shrink-0"><i class="fas fa-lock text-secondary"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem;">KELULUSAN</span>
                                    <div class="text-truncate small">🏆 Post-Test: {{ $postTest->judul }}</div>
                                    <small class="text-danger d-block mt-1" style="font-size: 0.65rem;"><i class="fas fa-info-circle mr-1"></i>Selesaikan semua materi</small>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=post" class="playlist-item d-flex align-items-center p-3 text-decoration-none {{ $contentType === 'post' ? 'active bg-light font-weight-bold' : '' }}">
                                <div class="mr-3 flex-shrink-0"><i class="fas fa-trophy text-danger"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem;">KELULUSAN</span>
                                    <div class="text-truncate text-dark small font-weight-normal">🏆 Post-Test: {{ $postTest->judul }}</div>
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