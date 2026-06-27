@extends('layouts.compact')

@section('content')
<style>
    .lms-banner {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 16px; color: white; padding: 50px 30px; margin-bottom: 40px;
    }
    .category-badge {
        background: #eff6ff; color: #2563eb; font-weight: 700;
        padding: 6px 16px; border-radius: 20px; display: inline-block;
    }
    .course-card {
        border: none; border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
    }
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }
    /* Mengantisipasi jarak tombol jika menggunakan Bootstrap 4 yang belum ada fitur gap */
    .button-group-responsive > a, .button-group-responsive > button {
        margin-left: 4px;
    }
    @media (max-width: 575.98px) {
        .button-group-responsive {
            flex-direction: column;
            width: 100%;
            margin-top: 8px;
        }
        .button-group-responsive > a, .button-group-responsive > button {
            margin-left: 0;
            margin-top: 4px;
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="container py-5">
    <div class="lms-banner text-center text-md-left mb-5 shadow-sm">
        <h1 class="display-5 font-weight-bold text-white mb-2">Mau belajar apa hari ini? 🚀</h1>
        <p class="lead mb-0 text-white" style="opacity: 0.9;">Akses materi pelatihan beasiswa terstruktur standar industri.</p>
    </div>

    @forelse($kategori as $kat)
        <div class="mb-5">
            <div class="d-flex align-items-center mb-4">
                <span class="category-badge mr-3"><i class="fas fa-th-large mr-2"></i>{{ $kat->nama }}</span>
                <div class="flex-grow-1 border-top" style="border-color: #e2e8f0 !important;"></div>
            </div>

            <div class="row">
                @forelse($kat->materi as $mat)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 course-card">
                            <div class="card-body d-flex flex-column">
                                <span class="text-muted small mb-2"><i class="fas fa-book-open mr-1"></i> Modul Pelatihan</span>
                                <h4 class="card-title font-weight-bold text-dark mb-2">{{ $mat->nama }}</h4>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($mat->keterangan ?? 'Tidak ada keterangan materi.', 100) }}
                                </p>
                                <div class="border-top pt-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                                    <span class="text-secondary small font-weight-bold mb-2 mb-sm-0">
                                        <i class="fas fa-video mr-1"></i> {{ count($mat->subMateri) }} Materi
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
       style="border-radius: 8px;"
       data-nama="{{ $mat->nama }}"
       data-sudah-aktif="{{ (isset($modulTerkunci) && $modulTerkunci->class_id == $mat->id) ? 'true' : 'false' }}">
        <i class="fas fa-play mr-1"></i> Belajar
    </a>

    @if(isset($modulTerkunci) && $modulTerkunci->class_id == $mat->id)
        <a href="{{ route('siswa.materi.report.latest', $mat->id) }}" class="btn btn-info btn-sm px-3" style="border-radius: 8px;">
            <i class="fas fa-file-alt mr-1"></i> Raport
        </a>
    @endif
@endif
    </div>
@else
                                        <button class="btn btn-light btn-sm px-4 disabled" disabled>Kosong</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted small italic pl-2">Belum ada kelas/materi di kategori ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="text-center py-5 bg-white rounded-lg border shadow-sm">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <h5 class="text-secondary">Belum ada katalog materi yang tersedia saat ini.</h5>
        </div>
    @endif
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
    document.querySelectorAll('.btn-pilih-modul').forEach(button => {
    button.addEventListener('click', function(e) {
        const urlTarget = this.getAttribute('href');
        const namaModul = this.getAttribute('data-nama');
        const sudahAktif = this.getAttribute('data-sudah-aktif') === 'true';

        // JIKA MODUL SUDAH DIAKTIFKAN SEBELUMNYA, LANGSUNG MASUK TANPA SWEETALERT
        if (sudahAktif) {
            return; // Biarkan browser melakukan redirect alami ke urlTarget
        }

        // JIKA MODUL BARU / BELUM PERNAH DIPILIH, TAMPILKAN KONFIRMASI
        e.preventDefault(); // Tahan redirect url asli
        
        Swal.fire({
            title: 'Konfirmasi Pilihan Modul',
            html: `Apakah Anda yakin ingin memilih modul <br><strong>"${namaModul}"</strong>?<br><br><span class="text-danger" style="font-size: 13px;">*PENTING: Anda hanya diperbolehkan memilih 1 modul pelatihan. Pilihan ini tidak dapat diubah kembali!</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Saya Yakin!',
            cancelButtonText: 'Batal',
            borderRadius: '12px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika klik ya, langsung arahkan ke route belajar
                window.location.href = urlTarget;
            }
        });
    });
});
</script>
@endsection