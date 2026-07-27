@extends('layouts.compact')

@section('content')

<div class="row" id="cancel-row">
    <div class="col-12 layout-top-spacing layout-spacing">

        {{-- BANNER MODERN --}}
        <div class="lms-banner text-center text-md-left mb-4">
            <h2 class="display-5 font-weight-bold text-white mb-2" style="letter-spacing: -0.5px;">Materi Pembelajaran 🚀</h2>
            <p class="mb-0 text-white-50" style="font-size: 1.05rem;">Akses materi berkualitas dan tingkatkan keahlianmu kapan saja.</p>
        </div>

        {{-- ALERT JIKA MASA AKTIF HABIS --}}
        @if(!$isMemberAktif)
            <div class="alert p-4 text-center mb-5" style="border-radius: 12px; background-color: #FEE2E2; color: #991B1B; border: none;">
                <i class="fas fa-exclamation-circle fa-2x mb-2 text-danger"></i>
                <h5 class="font-weight-bold mb-1">Masa Aktif Akun Kamu Habis!</h5>
                <p class="mb-0 opacity-75 small">Akses pembelajaran ditangguhkan sementara. Silakan hubungi pihak sekolah atau administrator untuk memperpanjang masa aktif akun kamu.</p>
            </div>
        @endif

        {{-- KONTEN UTAMA --}}
        @if($isMemberAktif)
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <span class="category-title font-weight-bold text-dark" style="font-size: 1.1rem;">
                        <i class="fas fa-th-large mr-2 text-primary"></i>Katalog Materi
                    </span>
                    <div class="flex-grow-1 border-top ml-3" style="border-color: #E2E8F0 !important; border-width: 1px;"></div>
                </div>

                <div class="row horizontal-scroll-mobile">
                    @forelse($subMateriUmum as $sub)
                        @php
                            // Ambil harga asli (murni angka) dari model
                            $hargaFinal = $sub->harga_final ?? $sub->harga ?? 0;
                            // Ambil nama materi/kelas
                            $namaMateri = $sub->nama ?? $sub->nama_kelas ?? 'Materi Tanpa Nama';
                        @endphp
                        <div class="col-md-4 col-xl-3 card-item-responsive mb-4">
                            <div class="card h-100 border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">
                                
                                {{-- AREA THUMBNAIL --}}
                                <div style="position: relative; width: 100%; aspect-ratio: 3 / 2; background-color: #4F46E5; overflow: hidden;">
                                    
                                    {{-- Cek Apakah Memiliki Thumbnail & File Eksis --}}
                                    @if(!empty($sub->thumbnail) && file_exists(public_path($sub->thumbnail)))
                                        <img src="{{ asset($sub->thumbnail) }}" 
                                             alt="{{ $namaMateri }}" 
                                             style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                    @else
                                        {{-- Fallback: Tampilan Placeholder Jika Tidak Ada Gambar --}}
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 2rem;">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    @endif

                                    {{-- Badge Harga Kartu --}}
                                    <span class="badge position-absolute" style="bottom: 12px; right: 12px; background: rgba(15, 23, 42, 0.75); color: #fff; backdrop-filter: blur(4px); font-weight: 600; padding: 6px 10px; border-radius: 6px; font-size: 11px; z-index: 2;">
                                        @if($hargaFinal > 0)
                                            Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </span>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body d-flex flex-column p-3">
                                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 0.98rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                        {{ $namaMateri }}
                                    </h5>
                                    
                                    <p class="text-muted small flex-grow-1 mb-3" style="line-height: 1.5; font-size: 0.85rem;">
                                        {{ Str::limit($sub->keterangan ?? 'Tidak ada keterangan bab materi untuk saat ini.', 75) }}
                                    </p>
                                    
                                    {{-- FOOTER / ACTION BUTTON --}}
                                    <div class="border-top pt-3 d-flex align-items-center justify-content-between" style="border-color: #F1F5F9 !important;">
                                        @php
                                            // Hitung Video (tipe_link_item = 0) dan Ebook (tipe_link_item = 1)
                                            $totalVideo = $sub->items->where('tipe_link_item', 0)->count();
                                            $totalEbook = $sub->items->where('tipe_link_item', 1)->count();
                                            $totalMedia = $sub->items->count();
                                        @endphp

                                        <div class="d-flex align-items-center gap-2" style="font-size: 11px; font-weight: 500; gap: 8px;">
                                            {{-- Tampilkan badge Video jika ada --}}
                                            @if($totalVideo > 0)
                                                <span class="text-secondary">
                                                    <i class="fas fa-video mr-1 text-danger"></i> {{ $totalVideo }} Video
                                                </span>
                                            @endif

                                            {{-- Tampilkan badge Ebook jika ada --}}
                                            @if($totalEbook > 0)
                                                <span class="text-secondary">
                                                    <i class="fas fa-book mr-1 text-primary"></i> {{ $totalEbook }} Ebook
                                                </span>
                                            @endif

                                            {{-- Jika tidak ada video & ebook sama sekali --}}
                                            @if($totalMedia == 0)
                                                <span class="text-muted">
                                                    <i class="fas fa-folder-open mr-1"></i> 0 Media
                                                </span>
                                            @endif
                                        </div>

                                        @if($totalMedia > 0)
                                            {{-- Tombol jika item tersedia --}}
                                            <a href="{{ route('siswa.umum.belajar', [$sub->id]) }}"
                                               class="btn btn-primary btn-sm px-3 font-weight-bold"
                                               style="border-radius: 6px; font-size: 12px;">
                                                Akses Materi <i class="fas fa-arrow-right ml-1"></i>
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
                                <h6 class="font-weight-bold text-dark mb-1">Belum Ada Materi Tersedia</h6>
                                <p class="text-muted small mb-0">Materi umum belum ditambahkan oleh administrator.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </div>
</div>

@endsection