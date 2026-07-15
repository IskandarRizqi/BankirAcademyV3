@extends('layouts.compact')
@section('content')


<div class="row" id="cancel-row">
    <div class="col-12 layout-top-spacing layout-spacing">

        {{-- BANNER MODERN & EYE CATCHING --}}
        <div class="lms-banner text-center text-md-left mb-4">
            <h2 class="display-5 font-weight-bold text-white mb-2" style="letter-spacing: -0.5px;">Mau belajar apa hari ini? 🚀</h2>
            <p class="mb-0 text-white-50" style="font-size: 1.05rem;">Akses materi pelatihan beasiswa terstruktur standar industri untuk masa depanmu.</p>
        </div>

        {{-- FILTER & SEARCH BOX --}}
        <div class="card mb-4 custom-filter-card">
            <div class="card-body p-3">
                <form action="{{ request()->url() }}" method="GET" class="row id="filterForm"">
                    
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-custom" 
                                   placeholder="🔍 Ketik judul materi yang ingin dicari..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-4 mb-2 mb-md-0">
                        <select name="kategori_id" class="form-control form-control-custom" onchange="this.form.submit()">
                            <option value="">📁 Semua Kategori Kelas</option>
                            @foreach($listKategori as $katItem)
                                <option value="{{ $katItem->id }}" {{ request('kategori_id') == $katItem->id ? 'selected' : '' }}>
                                    {{ $katItem->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex">
                        <button type="submit" class="btn btn-primary btn-block btn-custom" style="background: #4F46E5; border: none;">
                            Cari Materi
                        </button>
                        @if(request('search') || request('kategori_id'))
                            <a href="{{ request()->url() }}" class="btn btn-light ml-2 btn-custom text-danger" title="Reset Filter" style="border: 1px solid #E2E8F0;">
                                <i class="fas fa-undo"></i>
                            </a>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        {{-- EMPTY STATE JIKA SEARCH TIDAK KETEMU --}}
        @if($isMemberAktif && $kategori->isEmpty() && (request('search') || request('kategori_id')))
            <div class="text-center py-5 bg-white mb-4 shadow-sm" style="border-radius: 16px;">
                <img src="https://illustrations.popsy.co/white/searching.svg" alt="Not Found" style="height: 160px;" class="mb-3">
                <h5 class="font-weight-bold text-dark">Yah, materi tidak ditemukan...</h5>
                <p class="text-muted small px-3">Coba cek kembali ejaan kata kuncimu atau gunakan filter kategori lainnya.</p>
                <a href="{{ request()->url() }}" class="btn btn-sm btn-primary btn-custom px-4" style="background: #4F46E5; border:none;">Lihat Semua Kelas</a>
            </div>
        @endif

        {{-- ALERT JIKA MASA AKTIF HABIS --}}
        @if(!$isMemberAktif)
            <div class="alert p-4 text-center mb-5" style="border-radius: 16px; background-color: #FEE2E2; color: #991B1B; border: none;">
                <i class="fas fa-exclamation-circle fa-3x mb-3 text-danger"></i>
                <h4 class="font-weight-bold mb-2">Masa Aktif Akun Kamu Habis!</h4>
                <p class="mb-0 opacity-75">Akses materi sementara dihentikan. Hubungi pihak sekolah atau administrator untuk memperpanjang akun kamu, ya!</p>
            </div>
        @endif

        {{-- DAFTAR KATEGORI & MATERI --}}
        @forelse($kategori as $kat)
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <span class="category-title"><i class="fas fa-layer-group mr-2 text-primary"></i>{{ $kat->nama }}</span>
                    <div class="flex-grow-1 border-top ml-3" style="border-color: #F1F5F9 !important; border-width: 2px;"></div>
                </div>

                <div class="row horizontal-scroll-mobile">
    @forelse($kat->materi as $mat)
        <div class="col-md-4 col-xl-3 card-item-responsive">
            <div class="card h-100 course-card-upgrade bg-white">

                {{-- THUMBNAIL AREA (Disesuaikan ke rasio 3:2 / 1090x726) --}}
                <div style="position: relative; width: 100%; aspect-ratio: 3 / 2; overflow: hidden; background-color: #F8FAFC;">
                    @if($mat->banner)
                        <img src="{{ asset('storage/banner/' . $mat->banner) }}" alt="Banner {{ $mat->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #6366F1 0%, #A855F7 100%); opacity: 0.85;"></div>
                    @endif
                    
                    {{-- Icon Overlay --}}
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 2.2rem; filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.15));">
                        <i class="{{ $mat->icon ?? 'fas fa-graduation-cap' }}"></i>
                    </div>
                    
                    {{-- Status Harga / Badge --}}
                    <span class="badge-premium" style="position: absolute; bottom: 12px; right: 12px;">
                        @if(isset($mat->harga) && $mat->harga > 0)
                            Rp {{ number_format($mat->harga, 0, ',', '.') }}
                        @else
                            Gratis ✨
                        @endif
                    </span>
                </div>

                {{-- CARD BODY --}}
                <div class="card-body d-flex flex-column p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted" style="font-size: 11px; font-weight: 500;"><i class="fas fa-book mr-1 text-primary"></i> Modul Belajar</span>
                        <span class="text-secondary" style="font-size: 11px; font-weight: 600;">
                            <i class="fas fa-fire text-warning mr-1"></i> 
                            {{ $mat->jumlah_peserta >= 1000 ? number_format($mat->jumlah_peserta/1000, 1) . 'k+' : $mat->jumlah_peserta }} Siswa
                        </span>
                    </div>

                    <h5 class="card-title font-weight-bold text-dark" style="font-size: 1.05rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $mat->nama }}
                    </h5>
                    
                    <p class="text-muted small flex-grow-1 mb-3" style="line-height: 1.5;">
                        {{ Str::limit($mat->keterangan ?? 'Pelajari modul interaktif ini untuk mengasah keahlianmu.', 80) }}
                    </p>

                    {{-- FOOTER / ACTION BUTTON --}}
                    <div class="border-top d-flex align-items-center justify-content-between" style="border-color: #F8FAFC !important;">
                       <span class="text-muted" style="font-size: 13px; display: flex; gap: 8px; align-items: center;">
    @php
        // Ambil semua tipe_link_item yang ada di dalam sub-materi ini
        // 0 = Video (YouTube), 1 = PDF/Document (Google Drive)
        $allItemTypes = $mat->subMateri->flatMap(function($sub) {
            return $sub->items->pluck('tipe_link_item');
        })->unique()->toArray();
    @endphp {{-- 🌟 Perbaikan: Di sini sebelumnya tertulis @php, sekarang sudah diganti @endphp --}}

    {{-- Tampilkan ikon video jika tipe 0 tersedia --}}
    @if(in_array(0, $allItemTypes))
        <i class="fas fa-video text-danger" title="Tersedia Materi Video" style="cursor: help;"></i>
    @endif

    {{-- Tampilkan ikon PDF/File jika tipe 1 tersedia --}}
    @if(in_array(1, $allItemTypes))
        <i class="fas fa-file-pdf text-warning" title="Tersedia Materi PDF / Dokumen" style="cursor: help;"></i>
    @endif

    {{-- Tampilkan info cadangan jika sub-materi belum memiliki item media sama sekali --}}
    @if(empty($allItemTypes) && $mat->subMateri->count() > 0)
        <i class="fas fa-book text-muted" title="Materi Teks"></i>
    @endif
</span>

                        @if($mat->subMateri->count() > 0)
                            <div class="d-flex">
                                @if(in_array($mat->id, $modulDiikutiIds))
                                    <a href="{{ route('siswa.materi.belajar', [$mat->id, $mat->subMateri->first()->id]) }}"
                                       class="btn btn-success btn-sm px-3 btn-custom" style="background: #10B981; border: none; font-size: 12px;">
                                        Masuk Kelas
                                    </a>
                                    @if($hasPrepostData)
                                        <a href="{{ route('siswa.materi.report.latest', $mat->id) }}" class="btn btn-info btn-sm px-2 ml-1 btn-custom" style="background: #0EA5E9; border: none; font-size: 12px;" title="Lihat Nilai">
                                            <i class="fas fa-file-alt"></i> Nilai
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('siswa.materi.belajar', [$mat->id, $mat->subMateri->first()->id]) }}"
                                       class="btn btn-primary btn-sm px-3 btn-custom btn-pilih-modul"
                                       style="background: #4F46E5; border: none; font-size: 12px;"
                                       data-nama="{{ $mat->nama }}"
                                       data-harga="Rp {{ number_format($mat->harga, 0, ',', '.') }}">
                                        Mulai Belajar
                                    </a>
                                @endif
                            </div>
                        @else
                            <button class="btn btn-light btn-sm px-3 disabled btn-custom" style="font-size: 12px;" disabled>Kosong</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted small font-italic pl-2">Belum ada kelas atau materi di kategori ini.</p>
        </div>
    @endforelse
</div>
            </div>
        @empty
            @if($isMemberAktif)
                <div class="text-center py-5 bg-white shadow-sm" style="border-radius: 16px;">
                    <i class="fas fa-folder-open fa-3x mb-3 text-muted" style="opacity: 0.5;"></i>
                    <h5 class="text-muted font-weight-bold">Katalog materi belum tersedia saat ini.</h5>
                </div>
            @endif
        @endforelse

    </div>
</div>
@endsection