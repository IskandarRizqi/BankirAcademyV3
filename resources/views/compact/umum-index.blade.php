@extends('layouts.compact')

@section('content')


<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">

        {{-- BANNER UTAMA --}}
        <div class="lms-banner-gradient text-center text-md-left p-5 mb-5 text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 font-weight-bold mb-2 text-white">Materi Pembelajaran 🚀</h1>
                    <p class="lead mb-0 text-white" style="opacity: 0.9; font-size: 1.1rem;">Akses materi berkualitas dan tingkatkan keahlianmu kapan saja.</p>
                </div>
            </div>
        </div>

        {{-- ALERT JIKA MASA AKTIF HABIS --}}
        @if(!$isMemberAktif)
            <div class="alert p-4 text-center mb-5" style="border-radius: 16px; background-color: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5;">
                <i class="fas fa-exclamation-circle fa-3x mb-3" style="color: #DC2626;"></i>
                <h4 class="font-weight-bold mb-2">Masa Aktif Akun Anda Telah Habis!</h4>
                <p class="mb-0" style="max-width: 600px; margin: 0 auto; color: #7F1D1D;">Akses pembelajaran ditangguhkan sementara. Silakan hubungi pihak sekolah atau administrator untuk memperpanjang masa aktif akun Anda.</p>
            </div>
        @endif

        {{-- KONTEN UTAMA --}}
        @if($isMemberAktif)
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <span class="category-badge mr-3">
                        <i class="fas fa-th-large mr-2 text-primary"></i>Katalog Materi
                    </span>
                    <div class="flex-grow-1 border-top" style="border-color: #E5E7EB !important;"></div>
                </div>

                <div class="row">
                    @forelse($subMateriUmum as $sub)
                        <div class="col-md-4 mb-4 d-flex align-items-stretch">
                            <div class="card course-card w-100">
                                
                                {{-- CREATIVE THUMBNAIL PLACEHOLDER --}}
                                <div class="thumbnail-placeholder d-flex align-items-center justify-content-center">
                                    <div class="thumbnail-icon shadow-sm">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div style="position: absolute; bottom: 12px; left: 16px;">
                                        <span class="badge badge-dark opacity-75 px-2 py-1" style="font-size: 11px; background: rgba(0,0,0,0.6); border-radius: 4px;">
                                            <i class="fas fa-book-open mr-1"></i> Bab Materi
                                        </span>
                                    </div>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body d-flex flex-column p-4">
                                    <h4 class="card-title font-weight-bold mb-2 text-dark" style="line-height: 1.4; font-size: 1.2rem;">
                                        {{ $sub->nama }}
                                    </h4>
                                    <p class="card-text text-muted small flex-grow-1 mb-4" style="line-height: 1.6;">
                                        {{ Str::limit($sub->keterangan ?? 'Tidak ada keterangan bab materi untuk saat ini.', 110) }}
                                    </p>
                                    
                                    <div class="border-top pt-3 d-flex flex-row justify-content-between align-items-center" style="border-color: #F3F4F6 !important;">
                                        <span class="text-secondary small font-weight-bold">
                                            <i class="fas fa-video mr-1 text-muted"></i> {{ $sub->items->count() }} Media
                                        </span>

                                        @if($sub->items->count() > 0)
                                            <a href="{{ route('siswa.umum.belajar', [$sub->id]) }}"
                                               class="btn btn-primary btn-sm px-4 font-weight-bold"
                                               style="border-radius: 10px; transition: all 0.2s;">
                                                Mulai <i class="fas fa-arrow-right ml-1" style="font-size: 11px;"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-light btn-sm px-3 disabled" style="border-radius: 10px; color: #9CA3AF;" disabled>
                                                Kosong
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        {{-- EMPTY STATE MODERN --}}
                        <div class="col-12">
                            <div class="text-center py-5 bg-white shadow-sm" style="border-radius: 16px; border: 1px solid #E5E7EB;">
                                <div class="mb-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #F3F4F6; border-radius: 50%;">
                                    <i class="fas fa-folder-open fa-2x" style="color: #9CA3AF;"></i>
                                </div>
                                <h5 class="font-weight-bold" style="color: #374151;">Belum Ada Materi Tersedia</h5>
                                <p class="text-muted small mb-0">Materi umum belum ditambahkan oleh administrator. Silakan kembali lagi nanti!</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </div>
</div>
@endsection