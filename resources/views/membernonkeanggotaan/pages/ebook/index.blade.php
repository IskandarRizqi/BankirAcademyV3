@extends('layouts.appmembernonanggota')

@section('content')
<div class="row" id="cancel-row">
    <div class="col-12 layout-top-spacing layout-spacing">

        <div class="lms-banner text-center text-md-left mb-4"  style="background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%); padding: 2rem; border-radius: 12px;">
            <h2 class="display-5 font-weight-bold text-white mb-2">Katalog Ebook & Dokumen 📚</h2>
            <p class="mb-0 text-white-50" style="font-size: 1.05rem;">Akses e-book dan modul pembelajaran berkualitas dalam format digital.</p>
        </div>

        <div class="mb-5">
            <div class="d-flex align-items-center mb-4">
                <span class="category-title font-weight-bold text-dark" style="font-size: 1.1rem;">
                    <i class="fas fa-book-reader mr-2 text-primary"></i>Daftar Ebook
                </span>
                <div class="flex-grow-1 border-top ml-3" style="border-color: #E2E8F0 !important;"></div>
            </div>

            <div class="row horizontal-scroll-mobile">
                @forelse($subMateriUmum as $sub)
                    @php
                        $hargaFinal = $sub->harga_final ?? $sub->harga ?? 0;
                        $namaMateri = $sub->nama ?? $sub->nama_kelas ?? 'Ebook Tanpa Nama';
                    @endphp
                    <div class="col-md-4 col-xl-3 card-item-responsive mb-4">
                        <div class="card h-100 border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">
                            
                            {{-- Thumbnail Ebook --}}
                            <div style="position: relative; width: 100%; aspect-ratio: 3 / 2; background-color: #059669;">
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 2.5rem;">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <span class="badge position-absolute" style="bottom: 12px; right: 12px; background: rgba(15, 23, 42, 0.75); color: #fff; backdrop-filter: blur(4px); font-weight: 600; padding: 6px 10px; border-radius: 6px; font-size: 11px;">
                                    @if($hargaFinal > 0)
                                        Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </span>
                            </div>

                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 0.98rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                    {{ $namaMateri }}
                                </h5>
                                
                                <p class="text-muted small flex-grow-1 mb-3" style="line-height: 1.5; font-size: 0.85rem;">
                                    {{ Str::limit($sub->keterangan ?? 'Tidak ada deskripsi ebook.', 75) }}
                                </p>
                                
                                <div class="border-top pt-3 d-flex align-items-center justify-content-between" style="border-color: #F1F5F9 !important;">
                                    <span class="text-muted" style="font-size: 11px; font-weight: 500;">
                                        <i class="fas fa-file-alt mr-1 text-success"></i> {{ $sub->items->count() }} Modul PDF
                                    </span>

                                    @if($sub->items->count() > 0)
                                        <a href="{{ route('ebook.belajar', [$sub->id]) }}" class="btn btn-success btn-sm px-3 font-weight-bold" style="border-radius: 6px; font-size: 12px;">
                                            Baca Ebook <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-light btn-sm px-3 disabled" style="font-size: 12px; color: #9CA3AF; border-radius: 6px;" disabled>
                                            Kosong
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 bg-white border mb-4" style="border-radius: 12px;">
                            <i class="fas fa-folder-open fa-2x mb-3 text-muted"></i>
                            <h6 class="font-weight-bold text-dark mb-1">Belum Ada Ebook Tersedia</h6>
                            <p class="text-muted small mb-0">Ebook materi umum belum ditambahkan oleh administrator.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection