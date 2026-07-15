@extends('layouts.compact')

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing px-2 px-md-4 mt-4" id="cancel-row">

    <div class="row">
        <div class="col-12 col-lg-8 mb-4">
            
            @foreach (['success', 'error', 'warning', 'info'] as $msg)
                @if(session($msg))
                    <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show border-0 shadow-sm mb-4 p-3" role="alert" style="border-radius: 12px;">
                        <div class="d-flex align-items-center pr-3">
                            <i class="fas @if($msg == 'success') fa-check-circle @elseif($msg == 'error') fa-exclamation-circle @elseif($msg == 'warning') fa-exclamation-triangle @else fa-info-circle @endif mr-2 fa-lg flex-shrink-0"></i> 
                            <div class="small-mobile-text">{{ session($msg) }}</div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="top: 50%; transform: translateY(-50%);">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endforeach

            @if(!$sudahTerkunci)
                <div class="card shadow-sm custom-card text-center p-4 p-md-5 bg-white mb-4" style="border-radius: 16px;">
                    <div class="py-2 py-md-4">
                        <div class="mb-3 d-inline-flex align-items-center justify-content-center bg-light text-primary rounded-circle" style="width: 70px; height: 70px;">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                        <h3 class="font-weight-bold text-dark h5 h4-md mt-2">Tertarik Mengikuti Pelatihan Ini?</h3>
                        <p class="text-muted mx-auto mb-4 small-mobile-text" style="max-width: 500px; line-height: 1.6;">
                            Anda sedang berada dalam mode pratinjau (preview). Ikuti pelatihan sekarang untuk membuka akses penuh ke semua video, dokumen materi, serta ujian sertifikasi.
                        </p>
                        
                        <form action="{{ route('siswa.materi.ikuti', $materiAktif->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block-mobile px-5 py-2.5 font-weight-bold shadow-sm btn-modern" style="border-radius: 50px;">
                                <i class="fas fa-sign-in-alt mr-2"></i> Ikuti Pelatihan Sekarang
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="bg-white p-4 shadow-sm custom-card mb-4" style="border-radius: 16px;">
                    <h5 class="font-weight-bold text-dark mb-3 dynamic-h5">Tentang Pelatihan</h5>
                    <p class="text-secondary mb-0 small-mobile-text" style="line-height: 1.7; white-space: pre-line;">{{ $materiAktif->keterangan ?? 'Tidak ada deskripsi tambahan untuk modul pelatihan ini.' }}</p>
                </div>

            @else
                @if(($contentType === 'pre' || $contentType === 'post') && $statusBeasiswaSiswa == 1)
                    @if($quizAktif)
                        <div class="card shadow-sm custom-card p-3 p-md-4 bg-white" style="border-radius: 16px;">
                            <div class="d-flex flex-row justify-content-between align-items-center border-bottom pb-3 mb-3">
                                <span class="badge badge-pill {{ $contentType === 'pre' ? 'badge-warning text-dark' : 'badge-danger' }} px-3 py-2 font-weight-bold" style="font-size: 0.75rem;">
                                    <i class="fas fa-file-signature mr-1"></i> {{ $contentType === 'pre' ? 'PRE-TEST' : 'POST-TEST' }}
                                </span>
                                <span class="text-muted small font-weight-bold text-right ml-2" style="font-size: 0.75rem;"><i class="far fa-clock mr-1"></i> Pilihan Ganda</span>
                            </div>
                            
                            <p class="text-muted small mb-4">Silakan jawab pertanyaan di bawah ini dengan memilih salah satu opsi jawaban yang paling tepat.</p>

                            <form action="{{ route('siswa.materi.simpan_test', [$materiAktif->id, $quizAktif->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="classid" value="{{ $materiAktif->id }}">
                                
                                @php
                                    $daftarSoal = is_string($quizAktif->soal) ? json_decode($quizAktif->soal, true) : $quizAktif->soal;
                                @endphp

                                @if(is_array($daftarSoal) && count($daftarSoal) > 0)
                                    @foreach($daftarSoal as $indexSoal => $item)
                                        <div class="mb-4 p-3 p-md-4 border-0 rounded-lg bg-light shadow-sm" style="border-radius: 12px;">
                                            <h6 class="font-weight-bold text-dark mb-3 d-flex align-items-start" style="line-height: 1.6; font-size: 0.95rem;">
                                                <span class="badge badge-dark mr-2 px-2 py-1 flex-shrink-0" style="border-radius: 6px;">{{ $indexSoal + 1 }}</span> 
                                                <span class="flex-grow-1 pt-0.5 small-mobile-text">{{ $item['pertanyaan'] ?? $item['Pertanyaan'] ?? '' }}</span>
                                            </h6>
                                            
                                            <div class="mt-3">
                                                @if(isset($item['opsi']) && is_array($item['opsi']))
                                                    @foreach($item['opsi'] as $keyOpsi => $valOpsi)
                                                        <label class="opsi-label d-flex align-items-center p-3 mb-2 bg-white shadow-sm rounded-lg" style="cursor: pointer; transition: all 0.2s;">
                                                            <input type="radio" name="jawaban[{{ $indexSoal }}]" value="{{ $keyOpsi }}" class="opsi-radio mr-3 flex-shrink-0" required style="width: 18px; height: 18px; accent-color: #4f46e5;">
                                                            <span class="opsi-text text-dark small-mobile-text"><strong>{{ $keyOpsi }}.</strong> {{ $valOpsi }}</span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <div class="text-right mt-4 border-top pt-3">
                                        <button type="submit" class="btn btn-primary btn-block-mobile px-5 py-2.5 font-weight-bold shadow-sm btn-modern">
                                            <i class="fas fa-paper-plane mr-2"></i> Kirim Jawaban
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted bg-light rounded" style="border-radius: 12px;">
                                        <i class="fas fa-exclamation-triangle fa-2x mb-2 text-warning"></i>
                                        <p class="mb-0"><em>Format soal kuis tidak valid atau data kosong.</em></p>
                                    </div>
                                @endif
                            </form>
                        </div>
                    @else
                        <div class="text-center py-5 bg-white shadow-sm custom-card" style="border-radius: 16px;">
                            <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                            <p class="text-secondary mb-0">Data ujian tidak ditemukan.</p>
                        </div>
                    @endif

                @else
                    @if($subMateriAktif)
                        <div class="media-holder mb-4 shadow-sm bg-black overflow-hidden" style="border-radius: 16px; padding: 0;">
                            @if($itemAktif)
                                @if($itemAktif->tipe_link_item == 0) 
                                    <div class="video-wrapper">
                                        <iframe src="{{ $embedUrl }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div class="pdf-wrapper">
                                        <iframe src="{{ $embedUrl }}" width="100%" height="100%" style="border: none;"></iframe>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5 text-white bg-dark">
                                    <p class="mb-0"><em>Media belum tersedia untuk bab pembelajaran ini.</em></p>
                                </div>
                            @endif
                        </div>

                        <div class="bg-white p-4 shadow-sm custom-card mb-4" style="border-radius: 16px;">
                            @if($itemAktif)
                                <div class="mb-3">
                                    <span class="badge badge-pill {{ $itemAktif->tipe_link_item == 0 ? 'badge-danger' : 'badge-success' }} px-3 py-2 font-weight-bold" style="font-size: 11px; white-space: normal; text-align: left; line-height: 1.4;">
                                        <i class="fas {{ $itemAktif->tipe_link_item == 0 ? 'fa-play-circle' : 'fa-file-pdf' }} mr-1"></i> 
                                        Sedang Dibuka: {{ $itemAktif->judul_item }}
                                    </span>
                                </div>
                            @endif
                            <p class="text-secondary small mt-2 mb-0 small-mobile-text" style="line-height: 1.7; white-space: pre-line;">{{ $subMateriAktif->keterangan ?? 'Tidak ada deskripsi tambahan.' }}</p>
                        </div>
                    @else
                        <div class="text-center py-5 bg-white shadow-sm custom-card" style="border-radius: 16px;">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-secondary mb-0 px-3 small-mobile-text">Belum ada materi pelajaran yang tersedia atau cocok untuk akun Anda.</p>
                        </div>
                    @endif
                @endif
            @endif
        </div>

        <div class="col-12 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 sticky-sidebar" style="border-radius: 16px; overflow: hidden;">
                <div class="sidebar-header p-4 bg-white border-bottom">
                    <span class="text-primary small text-uppercase font-weight-bold mb-1 d-block" style="letter-spacing: 0.5px; font-size: 0.75rem;">{{ $materiAktif->kategori->nama }}</span>
                    <h5 class="font-weight-bold text-dark mb-0 dynamic-h5" style="line-height: 1.4;">{{ $materiAktif->nama }}</h5>
                </div>
                
                <div class="sidebar-content bg-white">
                    <div class="kurikulum-title px-4 py-3 font-weight-bold text-dark d-flex align-items-center" style="background:#f8fafc; border-bottom:1px solid #edf2f7; font-size: 0.85rem;">
                        <i class="fas fa-list-ol mr-2 text-primary"></i> Kurikulum Kelas
                    </div>
                    
                    @if($preTest && $statusBeasiswaSiswa == 1)
                        @if(!$sudahTerkunci)
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 ml-1 flex-shrink-0"><i class="fas fa-lock text-secondary"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">TAHAP AWAL</span>
                                    <div class="text-truncate small">{{ $preTest->judul }}</div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=pre" class="playlist-item d-flex align-items-center p-3 text-decoration-none {{ $contentType === 'pre' ? 'playlist-active' : '' }}" style="border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 ml-1 flex-shrink-0">
                                    <i class="fas fa-file-signature fa-lg text-warning"></i>
                                </div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">TAHAP AWAL</span>
                                    <div class="text-truncate text-dark small">{{ $preTest->judul }}</div>
                                </div>
                            </a>
                        @endif
                    @endif

                    <div class="bg-light px-4 py-2 text-muted font-weight-bold border-bottom" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                        MATERI PELAJARAN ({{ count($materiAktif->subMateri) }} BAB)
                    </div>
                    
                    @foreach($materiAktif->subMateri as $index => $sub)
                        @php
                            $isLocked = false;

                            if (!$sudahTerkunci) {
                                $isLocked = true;
                            } else {
                                if ($statusBeasiswaSiswa == 1 && $preTest && (!$userProgress || is_null($userProgress->nilai_awal))) {
                                    $isLocked = true;
                                }
                                // Lock jika bab sebelumnya belum berstatus selesai di DB
                                if ($index > 0) {
                                    $prevMateriValid = $materiAktif->subMateri[$index - 1];
                                    if ($prevMateriValid && !in_array($prevMateriValid->id, $subMateriSelesaiIds)) {
                                        $isLocked = true;
                                    }
                                }
                            }
                            
                            $isBabAktif = ($contentType === 'materi' && $subMateriAktif && $subMateriAktif->id == $sub->id);
                        @endphp

                        @if($isLocked)
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 ml-1 flex-shrink-0">
                                    <i class="fas fa-lock text-secondary"></i>
                                </div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted mb-1" style="font-size: 0.65rem;">Materi {{ $index + 1 }}</span>
                                    <div class="text-truncate small">{{ $sub->nama }}</div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;"><i class="fas fa-layer-group mr-1"></i> {{ $sub->items->count() }} Media</small>
                                </div>
                            </div>
                        @else
                            <div class="p-3 {{ $isBabAktif ? 'bg-light border-left-primary' : '' }}" style="border-bottom: 1px solid #edf2f7;">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="mr-3 ml-1 flex-shrink-0">
                                        @if(in_array($sub->id, $subMateriSelesaiIds))
                                            <i class="fas fa-check-circle text-success"></i>
                                        @else
                                            <i class="fas {{ $sub->items->count() > 1 ? 'fa-boxes text-primary' : ($sub->items->first() && $sub->items->first()->tipe_link_item == 1 ? 'fa-file-alt text-success' : 'fa-play-circle text-danger') }}"></i>
                                        @endif
                                    </div>
                                    <div class="w-100 overflow-hidden">
                                        <span class="d-block text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem;">Materi {{ $index + 1 }}</span>
                                        <div class="text-truncate text-dark small {{ $isBabAktif ? 'font-weight-bold' : '' }}">{{ $sub->nama }}</div>
                                    </div>
                                </div>

                                @if($sub->items && $sub->items->count() > 0)
                                    <div class="mt-2 pl-2 ml-2" style="border-left: 2px solid #e2e8f0;">
                                        @php
                                            // Urutkan item agar sama dengan logika di controller
                                            $sortedItems = $sub->items->sortBy('id');
                                        @endphp
                                        
                                        @foreach($sortedItems as $itemIndex => $mediaItem)
                                            @php
                                                $isMediaActive = ($itemAktif && $itemAktif->id == $mediaItem->id);
                                                $isMediaCompleted = in_array($mediaItem->id, $itemSelesaiIds);
                                                
                                                // 💡 LOGIKA LOCK UNTUK ITEM: 
                                                // Item akan dikunci jika bukan item pertama DAN item sebelumnya belum diselesaikan
                                                $isItemLocked = false;
                                                if ($itemIndex > 0) {
                                                    $prevMediaItem = $sortedItems->values()->get($itemIndex - 1);
                                                    if ($prevMediaItem && !in_array($prevMediaItem->id, $itemSelesaiIds)) {
                                                        $isItemLocked = true;
                                                    }
                                                }
                                            @endphp

                                            @if($isItemLocked)
                                                <div class="d-flex align-items-center py-2 px-2 my-1 text-muted small rounded" 
                                                     style="font-size: 0.78rem; cursor: not-allowed; opacity: 0.6; background: #f8fafc;">
                                                    <i class="fas fa-lock mr-2 text-secondary flex-shrink-0" style="font-size: 0.7rem;"></i>
                                                    <span class="text-truncate">{{ $mediaItem->judul_item }}</span>
                                                </div>
                                            @else
                                                <a href="{{ route('siswa.materi.belajar', [$materiAktif->id, $sub->id]) }}?item_id={{ $mediaItem->id }}" 
                                                   class="d-flex align-items-center py-2 px-2 my-1 text-decoration-none small rounded style-media-link {{ $isMediaActive ? 'bg-primary text-white font-weight-bold shadow-sm' : 'text-secondary' }}"
                                                   style="font-size: 0.78rem;">
                                                    
                                                    @if($isMediaCompleted && !$isMediaActive)
                                                        <i class="fas fa-check text-success mr-2 flex-shrink-0"></i>
                                                    @else
                                                        <i class="fas {{ $mediaItem->tipe_link_item == 0 ? 'fa-play-circle' : 'fa-file-pdf' }} mr-2 {{ $isMediaActive ? 'text-white' : 'text-muted' }} flex-shrink-0"></i>
                                                    @endif

                                                    <span class="text-truncate">{{ $mediaItem->judul_item }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    @if($postTest && $statusBeasiswaSiswa == 1)
                        @php
                            // Validasi kelulusan post test: bandingkan total bab aktif dengan total bab yang complete di DB
                            $isPostTestLocked = !$sudahTerkunci || (count(array_intersect($materiAktif->subMateri->pluck('id')->toArray(), $subMateriSelesaiIds)) < count($materiAktif->subMateri));
                        @endphp

                        @if($isPostTestLocked)
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 ml-1 flex-shrink-0"><i class="fas fa-lock text-secondary"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">KELULUSAN</span>
                                    <div class="text-truncate small">🏆 Post-Test: {{ $postTest->judul }}</div>
                                    <small class="text-danger d-block mt-1" style="font-size: 0.65rem;"><i class="fas fa-info-circle mr-1"></i>Selesaikan semua materi</small>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=post" class="playlist-item d-flex align-items-center p-3 text-decoration-none {{ $contentType === 'post' ? 'playlist-active' : '' }}">
                                <div class="mr-3 ml-1 flex-shrink-0"><i class="fas fa-trophy text-danger fa-lg"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">KELULUSAN</span>
                                    <div class="text-truncate text-dark small">🏆 Post-Test: {{ $postTest->judul }}</div>
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