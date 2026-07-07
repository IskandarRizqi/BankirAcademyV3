@extends('layouts.compact')

@section('content')

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <a href="{{ route('siswa.materi.index') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white d-inline-flex align-items-center shadow-sm" style="border-radius:8px; color:#64748b; font-weight: 600;">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
            </a>
        </div>

        <!-- LMS BANNER STYLE -->
        <div class="lms-banner text-center text-md-left mb-5">
            <span class="badge badge-light text-primary text-uppercase font-weight-bold mb-2 px-3 py-2" style="border-radius: 20px; font-size: 0.75rem;">
                Kategori: {{ $materiUmum->kategori->nama ?? 'Umum' }}
            </span>
            <h1 class="display-5 font-weight-bold text-white mb-2">Kompetensi: {{ $materiUmum->nama }} 🚀</h1>
            <p class="lead mb-0 text-white" style="opacity: 0.9;">Silakan pelajari rangkaian materi kompetensi umum di bawah ini secara berurutan.</p>
        </div>

        <!-- Alert Flash Notification -->
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

        <div class="row">
            <!-- Grid Card Sub Materi (Sisi Kiri) -->
            <div class="col-12 col-lg-8">
                <div class="row">
                    @if($materiUmum->subMateri && $materiUmum->subMateri->count() > 0)
                        @foreach($materiUmum->subMateri as $index => $sub)
                            @php
                                $isChosen = in_array($sub->id, $openedLessons);
                            @endphp
                            <div class="col-12 col-md-6 mb-4">
                                <div class="card h-100 sub-materi-card shadow-sm p-3 {{ $isChosen ? 'border-primary' : '' }}">
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="text-primary small font-weight-bold text-uppercase">
                                            Materi Urutan {{ $sub->urutan ?? ($index + 1) }}
                                        </span>
                                    </div>

                                    <!-- Nama Sub Materi -->
                                    <h5 class="font-weight-bold text-dark h6 mb-2" style="line-height: 1.4;">
                                        {{ $sub->nama }}
                                    </h5>

                                    <!-- Keterangan Singkat -->
                                    <p class="text-secondary small flex-grow-1 text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size:0.8rem;">
                                        {{ $sub->keterangan ?? 'Tidak ada deskripsi tambahan untuk materi ini.' }}
                                    </p>

                                    <hr class="my-2">
                                    
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <i class="fas fa-play-circle text-danger mr-1"></i> {{ $sub->items->count() }} Media Pembelajaran
                                        </small>
                                        
                                        <!-- Proteksi Sistem Lock Modul Terpilih -->
                                        @if(isset($modulTerkunci) && $modulTerkunci->class_id != $materiUmum->id)
                                            <button class="btn btn-sm btn-secondary disabled" style="border-radius:6px; font-size:0.75rem;" disabled>
                                                <i class="fas fa-lock mr-1"></i> Terkunci
                                            </button>
                                        @else
                                            <a href="{{ route('siswa.materi.belajar_umum', [$materiUmum->id, $sub->id]) }}" 
                                               class="btn btn-sm btn-primary text-white py-1 px-3 font-weight-bold btn-pilih-modul" 
                                               style="border-radius:6px; font-size:0.75rem;"
                                               data-nama="{{ $materiUmum->nama }}"
                                               data-sudah-aktif="{{ (isset($modulTerkunci) && $modulTerkunci->class_id == $materiUmum->id) ? 'true' : 'false' }}">
                                                <i class="fas fa-play mr-1"></i> Masuk Belajar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-5 bg-white shadow-sm rounded border" style="border-radius: 12px;">
                                <i class="fas fa-folder-open fa-3x mb-3" style="color: #A3A8B8;"></i>
                                <h5 style="color: #6B7280;">Belum ada daftar bab/sub-materi pada kompetensi ini.</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Panel Deskripsi (Sisi Kanan) -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-summary" style="border-radius: 12px; overflow: hidden;">
                    <div class="p-3 bg-white border-bottom font-weight-bold text-dark d-flex align-items-center">
                        <i class="fas fa-info-circle mr-2 text-primary"></i> Aturan Pembelajaran
                    </div>
                    <div class="card-body bg-white">
                        <p class="small text-muted mb-3">Kompetensi Umum ini mewajibkan pembelajaran terstruktur.</p>
                        <ul class="small text-secondary pl-3 mb-0">
                            <li>Modul akan mengunci status pelatihan Anda saat Anda menekan tombol masuk belajar.</li>
                            <li>Anda wajib mempelajari sub-materi secara urut dari nomor terkecil.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('.btn-pilih-modul').forEach(button => {
        button.addEventListener('click', function (e) {
            const urlTarget = this.getAttribute('href');
            const namaModul = this.getAttribute('data-nama');
            const sudahAktif = this.getAttribute('data-sudah-aktif') === 'true';

            if (sudahAktif) {
                return; // Langsung tembus jika modul ini memang sudah aktif sebelumnya
            }

            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pilihan Modul',
                html: `Apakah Anda yakin ingin mengunci pelatihan pada modul <br><strong>"${namaModul}"</strong>?<br><br><span class="text-danger" style="font-size: 13px;">*PENTING: Anda hanya diperbolehkan memilih 1 modul pelatihan aktif di luar kelas utama. Pilihan tidak dapat diubah!</span>`,
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