@extends('layouts.compact')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 16px; background: #fff;">
                <div class="badge badge-primary mb-3 py-2 px-3" style="border-radius: 20px;">
                    Bidang: {{ $materi->kategori->nama }}
                </div>
                <h3 class="font-weight-bold text-dark">{{ $materi->nama }}</h3>
                <p class="text-muted text-sm">{{ $materi->keterangan }}</p>
                <div class="alert alert-info small mt-3">
                    <i class="fas fa-check-circle mr-1"></i> Anda terdaftar pada kelas ini.
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h4 class="font-weight-bold mb-4">Silabus & Urutan Materi Belajar</h4>
            
            <div class="timeline-materi">
                @forelse($materi->subMateri as $index => $sub)
                    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; border-left: 5px solid #224abe !important;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge badge-secondary mb-1">Eps. {{ $index + 1 }}</span>
                                <h5 class="font-weight-bold m-0 text-dark">{{ $sub->nama }}</h5>
                                <small class="text-muted">{{ $sub->keterangan ?? 'Tidak ada keterangan' }}</small>
                            </div>
                            <div>
                                <a href="{{ $sub->link }}" target="_blank" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 20px;">
                                    <i class="fas fa-play-circle mr-1"></i> Tonton Video
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-5 text-center rounded shadow-sm">
                        <i class="fas fa-video-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted m-0">Video materi belum diunggah oleh instruktur.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection