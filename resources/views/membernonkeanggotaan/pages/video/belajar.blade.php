@extends('layouts.appmembernonanggota')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-3" id="cancel-row">
    
    <div class="row mb-3">
        <div class="col-12">
            <div class="mb-2">
                <a href="{{ url('/kelas-event') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white d-inline-flex align-items-center shadow-sm" style="border-radius:8px; color:#64748b;">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Pembelajaran Anda
                </a>
            </div>
            
            <div class="bg-white p-3 rounded shadow-sm border">
                <span class="text-danger small text-uppercase font-weight-bold d-block mb-1">
                    <i class="fas fa-play-circle mr-1"></i> Player Video Pembelajaran &middot; <span class="text-muted">Urutan Ke-{{ $subMateriAktif->urutan ?? 1 }}</span>
                </span>
                <h1 class="font-weight-bold text-dark h4 mb-0">
                    {{ $subMateriAktif->nama ?? 'Pilih Video' }}
                </h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8 mb-4">
            
            {{-- Video Player Responsive --}}
            <div class="media-holder mb-4 shadow-sm bg-black rounded overflow-hidden position-relative" style="min-height: 350px;">
                @if($itemAktif)
                    <div id="mediaContent">
                        <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                            <iframe src="{{ $embedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center text-white" style="height: 350px;">
                        <p class="mb-0">Tidak ada video yang dapat diputar.</p>
                    </div>
                @endif
            </div>

            <div class="materi-info-card bg-white p-3 p-md-4 shadow-sm rounded" style="border-radius: 12px;">
                @if($itemAktif)
                    <div class="mb-2">
                        <span class="badge badge-pill badge-danger px-3 py-2">
                            <i class="fas fa-play-circle mr-1"></i> Sedang Diputar: {{ $itemAktif->judul_item }}
                        </span>
                    </div>
                @endif
                <p class="text-secondary small mt-3" style="line-height: 1.7; white-space: pre-line;">{{ $subMateriAktif->keterangan ?? 'Tidak ada deskripsi tambahan.' }}</p>
            </div>
        
        </div>

        {{-- Sidebar Daftar Playlist Video --}}
        <div class="col-12 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 sticky-sidebar" style="border-radius: 16px; overflow: hidden;">
                <div class="sidebar-header p-4 bg-white border-bottom">
                    <span class="text-danger small text-uppercase font-weight-bold mb-1 d-block" style="letter-spacing: 0.5px; font-size: 0.75rem;">Playlist Video</span>
                    <h5 class="font-weight-bold text-dark mb-0 dynamic-h5" style="line-height: 1.4;">{{ $subMateriAktif->nama ?? '' }}</h5>
                </div>
                
                <div class="sidebar-content bg-white">
                    <div class="kurikulum-title px-4 py-3 font-weight-bold text-dark d-flex align-items-center" style="background:#f8fafc; border-bottom:1px solid #edf2f7; font-size: 0.85rem;">
                        <i class="fas fa-list-ol mr-2 text-danger"></i> Daftar Materi Video
                    </div>
                    
                    <div class="list-group list-group-flush">
                        @forelse($subMateriAktif->items as $item)
                            <a href="{{ route('video.belajar', ['sub_materi_id' => $subMateriAktif->id, 'item_id' => $item->id]) }}" 
                               class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4 {{ ($itemAktif && $itemAktif->id == $item->id) ? 'bg-light font-weight-bold text-danger' : 'text-dark' }}">
                                <i class="fas fa-play-circle mr-3 {{ ($itemAktif && $itemAktif->id == $item->id) ? 'text-danger' : 'text-muted' }}"></i>
                                <span>{{ $item->judul_item }}</span>
                            </a>
                        @empty
                            <div class="p-4 text-center text-muted small">Belum ada video.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
