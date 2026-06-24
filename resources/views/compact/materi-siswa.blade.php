@extends('layouts.compact') 
@section('content')
<style>
    .dashboard-wrapper { background-color: #f8fafc; min-height: 100vh; }
    .course-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white; border-radius: 16px; padding: 40px; margin-bottom: 35px;
    }
    .kategori-section {
        background: #ffffff; border-radius: 12px; padding: 24px;
        margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .kategori-title {
        font-size: 1.4rem; font-weight: 800; color: #1e293b;
        margin-bottom: 20px; padding-left: 10px; border-left: 5px solid #4e73df;
    }
    .materi-accent-card {
        border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 12px; overflow: hidden;
    }
    .materi-header-btn {
        width: 100%; text-align: left; background: #f8fafc; padding: 16px;
        font-weight: 700; color: #1e3a8a; border: none; display: flex;
        justify-content: space-between; align-items: center; transition: background 0.2s;
    }
    .materi-header-btn:hover { background: #f1f5f9; text-decoration: none; }
    .video-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 12px 20px; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;
    }
    .video-item:hover { background: #fafafa; }
    .video-item:last-child { border-bottom: none; }
</style>

<div class="dashboard-wrapper py-4">
    <div class="container">
        
        <div class="course-header text-center text-md-left">
            <h1 class="display-5 text-white font-weight-bold mb-2">Katalog Materi Pelatihan 📚</h1>
            <p class="lead mb-0 text-white" style="opacity: 0.95;">Silakan jelajahi bidang kategori dan materi video pembelajaran di bawah ini.</p>
        </div>

        @forelse($kategori as $kat)
            <div class="kategori-section">
                <h2 class="kategori-title"><i class="fas fa-tags text-primary mr-2"></i>{{ $kat->nama }}</h2>
                
                <div class="accordion" id="accordionKategori{{ $kat->id }}">
                    @forelse($kat->materi as $indexMat => $mat)
                        <div class="materi-accent-card">
                            
                            <button class="materi-header-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseMateri{{ $mat->id }}" aria-expanded="false">
                                <div>
                                    <i class="fas fa-book mr-2 text-secondary"></i> {{ $mat->nama }}
                                    <span class="badge badge-light border ml-2 font-weight-normal text-muted">
                                        {{ count($mat->subMateri) }} Video
                                    </span>
                                </div>
                                <i class="fas fa-chevron-down text-muted small"></i>
                            </button>

                            <div id="collapseMateri{{ $mat->id }}" class="collapse" data-parent="#accordionKategori{{ $kat->id }}">
                                <div class="card-body p-0 bg-white">
                                    <p class="text-muted small px-4 pt-3 mb-2"><em>{{ $mat->keterangan ?? 'Tidak ada keterangan materi.' }}</em></p>
                                    
                                    @forelse($mat->subMateri as $indexSub => $sub)
                                        <div class="video-item">
                                            <div>
                                                <span class="badge badge-primary mr-2">Eps. {{ $indexSub + 1 }}</span>
                                                <strong class="text-dark">{{ $sub->nama }}</strong>
                                                @if($sub->keterangan)
                                                    <span class="text-muted d-block small pl-5">{{ $sub->keterangan }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ $sub->link }}" target="_blank" class="btn btn-sm btn-outline-success px-3" style="border-radius: 20px;">
                                                    <i class="fas fa-play mr-1"></i> Tonton
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center text-muted small">
                                            <i class="fas fa-video-slash mr-1"></i> Belum ada video/sub materi untuk materi ini.
                                        </div>
                                    @endforelse

                                </div>
                            </div>

                        </div>
                    @empty
                        <p class="text-muted pl-2 small"><em>Belum ada materi di dalam kategori ini.</em></p>
                    @endforelse
                </div>

            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-lg border">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-secondary">Belum ada data kategori tersedia.</h5>
            </div>
        @endif

    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection