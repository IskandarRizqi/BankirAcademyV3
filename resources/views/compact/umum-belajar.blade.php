@extends('layouts.compact')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-3" id="cancel-row">
    
    <div class="row mb-3">
        <div class="col-12">
            <div class="mb-2">
                <a href="{{ route('siswa.umum.index') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white d-inline-flex align-items-center shadow-sm" style="border-radius:8px; color:#64748b;">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog Umum
                </a>
            </div>
            
            <div class="bg-white p-3 rounded shadow-sm border">
                <span class="text-primary small text-uppercase font-weight-bold d-block mb-1">
                    {{ $materiAktif->nama ?? 'Materi Umum' }} &middot; <span class="text-muted">Urutan Ke-{{ $subMateriAktif->urutan ?? 1 }}</span>
                </span>
                <h1 class="font-weight-bold text-dark h4 mb-0">
                    {{ $subMateriAktif->nama ?? 'Pilih Materi' }}
                </h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8 mb-4">
            
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

            @if($subMateriAktif)
                <div class="media-holder mb-4 shadow-sm bg-black rounded overflow-hidden position-relative" style="min-height: 350px;">
                    @if($itemAktif)
                        
                        @if(!$sudahIkuti)
                        <div id="lockedScreen" class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: rgba(15, 23, 42, 0.85); z-index: 5; top: 0; left: 0; backdrop-filter: blur(4px);">
                            <div class="mb-3 p-4 bg-soft-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; background: rgba(59, 130, 246, 0.2); border: 2px dashed #3b82f6;">
                                <i class="fas fa-lock text-primary fa-2x animate-bounce"></i>
                            </div>
                            <h5 class="text-white font-weight-bold mb-2">Materi Terkunci!</h5>
                            <p class="text-white-50 small max-w-md px-md-5 mb-4">
                                Anda harus bergabung ke materi <strong>{{ $subMateriAktif->nama }}</strong> terlebih dahulu sebelum dapat melihat media pembelajaran.
                            </p>
                            
                            <form id="formIkutiPelatihan" action="{{ route('siswa.umum.ikuti', $subMateriAktif->id) }}" method="POST">
                                @csrf
                                <button type="button" onclick="konfirmasiIkuti()" class="btn btn-primary px-4 py-2.5 font-weight-bold shadow border-0 d-inline-flex align-items-center" style="border-radius: 30px; gap: 8px;">
                                    <i class="fas fa-play-circle"></i> Ikuti Pelatihan Ini
                                </button>
                            </form>
                        </div>
                        @endif

                        <div id="mediaContent" style="{{ !$sudahIkuti ? 'filter: blur(8px); pointer-events: none;' : '' }}">
                            @if($itemAktif->tipe_link_item == 0) 
                                <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                                    <iframe src="{{ $sudahIkuti ? $embedUrl : '' }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="pdf-wrapper" style="height: 550px; max-height: 75vh;">
                                    <iframe src="{{ $sudahIkuti ? $embedUrl : '' }}" width="100%" height="100%" style="border: none;"></iframe>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5 text-white">
                            <p class="mb-0"><em>Media belum tersedia untuk bab pembelajaran ini.</em></p>
                        </div>
                    @endif
                </div>

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
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="border-radius: 12px; overflow: hidden; top: 20px; z-index: 4;">
                <div class="sidebar-header p-3 bg-white border-bottom">
                    <span class="text-primary small text-uppercase font-weight-bold mb-1 d-block">Daftar Isi Bab Ini</span>
                    <h5 class="font-weight-bold text-dark mb-0 h6" style="line-height: 1.4;">{{ $subMateriAktif->nama }}</h5>
                </div>
                
                <div class="sidebar-content bg-white" style="max-height: 65vh; overflow-y: auto;">
                    <div class="kurikulum-title px-3 py-2.5 font-weight-bold text-dark" style="background:#f8fafc; border-bottom:1px solid #edf2f7; font-size: 0.85rem;">
                        <i class="fas fa-scroll mr-2 text-primary"></i>Media Pembelajaran ({{ $subMateriAktif->items->count() }})
                    </div>
                    
                    <div class="p-2">
                        @if($subMateriAktif->items && $subMateriAktif->items->count() > 0)
                            @foreach($subMateriAktif->items as $mediaItem)
                                @php
                                    $isMediaActive = ($itemAktif && $itemAktif->id == $mediaItem->id);
                                @endphp
                                <a href="{{ $sudahIkuti ? route('siswa.umum.belajar', [$subMateriAktif->id]).'?item_id='.$mediaItem->id : 'javascript:void(0)' }}" 
                                   @if(!$sudahIkuti) onclick="pemberitahuanKunci()" @endif
                                   class="d-flex align-items-center py-2.5 px-3 my-1 rounded text-decoration-none small transition-all item-link-media {{ $isMediaActive && $sudahIkuti ? 'bg-primary text-white font-weight-bold shadow-sm' : 'text-secondary hover-bg-light' }}"
                                   style="font-size: 0.82rem; gap: 10px; {{ !$sudahIkuti ? 'cursor: not-allowed; opacity:0.6;' : '' }}">
                                    <i class="fas {{ $mediaItem->tipe_link_item == 0 ? 'fa-play-circle' : 'fa-file-pdf' }} {{ $isMediaActive && $sudahIkuti ? 'text-white' : 'text-muted' }}" style="font-size: 1.1rem;"></i>
                                    <span class="text-truncate">{{ $mediaItem->judul_item }}</span>
                                </a>
                            @endforeach
                        @else
                            <div class="text-center p-3 text-muted small">
                                <em>Tidak ada item media di bab ini.</em>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi SweetAlert saat tombol "Ikuti Pelatihan Ini" diklik
    function konfirmasiIkuti() {
        Swal.fire({
            title: 'Mulai Pelatihan?',
            text: "Apakah Anda yakin ingin mendaftar dan mengikuti bab '{{ $subMateriAktif->nama }}'?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ikuti Sekarang!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Menampilkan loading state
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang mendaftarkan Anda ke pelatihan ini.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                document.getElementById('formIkutiPelatihan').submit();
            }
        });
    }

    // Pemberitahuan jika menu sidebar diklik saat status masih terkunci
    function pemberitahuanKunci() {
        Swal.fire({
            title: 'Akses Terbatas',
            text: 'Silakan klik tombol "Ikuti Pelatihan Ini" terlebih dahulu untuk membuka daftar materi.',
            icon: 'warning',
            confirmButtonColor: '#3085d6'
        });
    }
</script>
@endsection