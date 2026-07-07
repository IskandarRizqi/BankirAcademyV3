@extends('layouts.compact')
@section('content')

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">

        <div class="lms-banner text-center text-md-left mb-2">
            <h1 class="display-5 font-weight-bold text-white mb-2">Mau belajar apa hari ini? 🚀</h1>
            <p class="lead mb-0 text-white" style="opacity: 0.9;">Akses materi pelatihan beasiswa terstruktur standar industri.</p>
        </div>

        {{-- ALERT JIKA MASA AKTIF HABIS --}}
        @if(!$isMemberAktif)
            <div class="alert alert-danger p-4 text-center mb-5" style="border-radius: 16px; border: none; background-color: #FEE2E2; color: #991B1B;">
                <i class="fas fa-exclamation-circle fa-3x mb-3 text-danger"></i>
                <h4 class="font-weight-bold mb-2">Masa Aktif Akun Anda Telah Habis!</h4>
                <p class="mb-0">Akses pembelajaran dihentikan. Silakan hubungi pihak sekolah atau administrator untuk memperpanjang masa aktif akun Anda.</p>
            </div>
        @endif

        @forelse($kategori as $kat)
            <div>
                <div class="d-flex align-items-center mb-4">
                    <span class="category-badge mr-3"><i class="fas fa-th-large mr-2"></i>{{ $kat->nama }}</span>
                    <div class="flex-grow-1 border-top" style="border-color: #E2E8F0 !important;"></div>
                </div>

                <div class="row">
                    @forelse($kat->materi as $mat)
                        <div class="col-md-3 mb-4">
                           <div class="card h-100 course-card bg-white">
    
    {{-- 1. THUMBNAIL DINAMIS (Jika ada gambar pakai banner, jika tidak pakai background pattern default) --}}
    <div class="thumbnail-container" style="position: relative; height: 160px; overflow: hidden; background-color: #f3f4f6;">
        @if($mat->banner)
            <img src="{{ asset('storage/banner/' . $mat->banner) }}" alt="Banner {{ $mat->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div class="thumbnail-pattern" style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); opacity: 0.8;"></div>
        @endif
        
        {{-- Icon Dinamis --}}
        <div class="thumbnail-icon" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 2.5rem; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.3));">
            <i class="{{ $mat->icon ?? 'fas fa-graduation-cap' }}"></i>
        </div>
        
        {{-- Format Harga Ke Rupiah --}}
        <span class="price-badge" style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.7); color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
            @if(isset($mat->harga) && $mat->harga > 0)
                Rp {{ number_format($mat->harga, 0, ',', '.') }}
            @else
                Gratis
            @endif
        </span>
    </div>

    <div class="card-body d-flex flex-column pt-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted small"><i class="fas fa-book-open mr-1"></i> Modul Pelatihan</span>
            
            {{-- 2. JUMLAH PESERTA DINAMIS --}}
            <span class="text-muted small font-weight-bold">
                <i class="fas fa-users text-primary mr-1"></i> 
                {{ $mat->jumlah_peserta >= 1000 ? number_format($mat->jumlah_peserta/1000, 1) . 'k+' : $mat->jumlah_peserta }} Diikuti
            </span>
        </div>

        <h4 class="card-title font-weight-bold mb-2 text-dark" style="font-size: 1.15rem; line-height: 1.4;">
            {{ $mat->nama }}
        </h4>
        
        <p class="card-text text-muted small flex-grow-1">
            {{ Str::limit($mat->keterangan ?? 'Tidak ada keterangan materi.', 90) }}
        </p>

                                    <div class="border-top pt-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center" style="border-color: #F1F5F9 !important;">
                                        <span class="text-secondary small font-weight-bold mb-2 mb-sm-0">
                                            <i class="fas fa-video text-danger mr-1"></i> 
                                        </span>

                                        @if(count($mat->subMateri) > 0)
                                            <div class="d-flex button-group-responsive">
                                                @if(isset($modulTerkunci) && $modulTerkunci->class_id != $mat->id)
                                                    <button class="btn btn-secondary btn-sm px-3 disabled" style="border-radius: 8px;" disabled>
                                                        <i class="fas fa-lock mr-1"></i> Terkunci
                                                    </button>
                                                @else
                                                    <a href="{{ route('siswa.materi.belajar', [$mat->id, $mat->subMateri->first()->id]) }}"
                                                       class="btn btn-primary btn-sm px-3 btn-pilih-modul"
                                                       style="border-radius: 8px; background-color: #4F46E5; border-color: #4F46E5;"
                                                       data-nama="{{ $mat->nama }}"
                                                       data-sudah-aktif="{{ (isset($modulTerkunci) && $modulTerkunci->class_id == $mat->id) ? 'true' : 'false' }}">
                                                        <i class="fas fa-play mr-1"></i> Belajar
                                                    </a>

                                                    @if(isset($modulTerkunci) && $modulTerkunci->class_id == $mat->id && $hasPrepostData)
                                                        <a href="{{ route('siswa.materi.report.latest', $mat->id) }}" class="btn btn-info btn-sm px-3 ml-1" style="border-radius: 8px;">
                                                            <i class="fas fa-file-alt mr-1"></i> Raport
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        @else
                                            <button class="btn btn-light btn-sm px-4 disabled" style="border-radius: 8px;" disabled>Kosong</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted small font-italic pl-2">Belum ada kelas/materi di kategori ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            @if($isMemberAktif)
                <div class="text-center py-5 bg-white empty-state-card" style="border-radius: 16px;">
                    <i class="fas fa-folder-open fa-3x mb-3" style="color: #A3A8B8;"></i>
                    <h5 style="color: #6B7280;">Belum ada katalog materi yang tersedia saat ini.</h5>
                </div>
            @endif
        @endforelse

    </div>
</div>

{{-- Script SweetAlert2 tetap sama --}}
<script>
    document.querySelectorAll('.btn-pilih-modul').forEach(button => {
        button.addEventListener('click', function (e) {
            const urlTarget = this.getAttribute('href');
            const namaModul = this.getAttribute('data-nama');
            const sudahAktif = this.getAttribute('data-sudah-aktif') === 'true';

            if (sudahAktif) {
                return;
            }

            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pilihan Modul',
                html: `Apakah Anda yakin ingin memilih modul <br><strong>"${namaModul}"</strong>?<br><br><span class="text-danger" style="font-size: 13px;">*PENTING: Anda hanya diperbolehkan memilih 1 modul pelatihan. Pilihan ini tidak dapat diubah kembali!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Saya Yakin!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlTarget;
                }
            });
        });
    });
</script>
@endsection