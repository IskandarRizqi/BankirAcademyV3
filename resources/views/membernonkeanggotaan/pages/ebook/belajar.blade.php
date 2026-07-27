@extends('layouts.appmembernonanggota')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-3" id="cancel-row">
    
    <div class="row mb-3">
        <div class="col-12">
            <div class="mb-2">
                <a href="{{ route('ebook.index') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white d-inline-flex align-items-center shadow-sm" style="border-radius:8px; color:#64748b;">
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
            
                <div class="media-holder mb-4 shadow-sm bg-black rounded overflow-hidden position-relative" style="min-height: 350px;">
                    @if($itemAktif)
                        
                        <div id="mediaContent">
                            @if($itemAktif->tipe_link_item == 0) 
                                <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                                    <iframe src="{{  $embedUrl  }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="pdf-wrapper" style="height: 550px; max-height: 75vh;">
                                    <iframe src="{{ $embedUrl  }}" width="100%" height="100%" style="border: none;"></iframe>
                                </div>
                            @endif
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
        
        </div>

        <div class="col-12 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 sticky-sidebar" style="border-radius: 16px; overflow: hidden;">
                <div class="sidebar-header p-4 bg-white border-bottom">
                    <span class="text-primary small text-uppercase font-weight-bold mb-1 d-block" style="letter-spacing: 0.5px; font-size: 0.75rem;">{{ $materiAktif->kategori->nama ?? '' }}</span>
                    <h5 class="font-weight-bold text-dark mb-0 dynamic-h5" style="line-height: 1.4;">{{ $materiAktif->nama ?? '' }}</h5>
                </div>
                
                <div class="sidebar-content bg-white">
                    <div class="kurikulum-title px-4 py-3 font-weight-bold text-dark d-flex align-items-center" style="background:#f8fafc; border-bottom:1px solid #edf2f7; font-size: 0.85rem;">
                        <i class="fas fa-list-ol mr-2 text-primary"></i> Kurikulum Kelas
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
            text: "Apakah Anda yakin ingin mendaftar dan mengikuti bab '{{ $subMateriAktif->nama ?? '' }}'?",
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
     $(document).ready(function() {
        let currentStep = 0;
        const totalSoal = $(".wrapper-soal-item").length;
     $("#btn-mulai-kuis").on("click", function() {
            $("#section-panduan").slideUp(400, function() {
                $("#form-kuis").removeClass("d-none");
                showSoal(currentStep);
            });
        });
        // 2. Fungsi Menampilkan Soal Berdasarkan Index
        function showSoal(index) {
            $(".wrapper-soal-item").addClass("d-none"); 
            $(`#box-soal-${index}`).removeClass("d-none"); 

            // Update Progress Bar
            let progressPercent = ((index + 1) / totalSoal) * 100;
            $("#quiz-progress-bar").css("width", progressPercent + "%");

            // Pengaturan State Tombol Navigasi
            if (index === 0) {
                $("#btn-prev-soal").attr("disabled", true);
            } else {
                $("#btn-prev-soal").removeAttr("disabled");
            }

            if (index === totalSoal - 1) {
                $("#btn-next-soal").addClass("d-none");
                $("#btn-submit-kuis").removeClass("d-none");
            } else {
                $("#btn-next-soal").removeClass("d-none");
                $("#btn-submit-kuis").addClass("d-none");
            }
        }

        // 3. Tombol Selanjutnya
        $("#btn-next-soal").on("click", function() {
            // Validasi apakah user sudah memilih opsi jawaban di soal yang aktif saat ini
            let inputChecked = $(`#box-soal-${currentStep} .radio-input-opsi:checked`).val();
            if (!inputChecked) {
                alert("Harap pilih salah satu jawaban terlebih dahulu sebelum lanjut!");
                return false;
            }

            if (currentStep < totalSoal - 1) {
                currentStep++;
                showSoal(currentStep);
            }
        });

        // 4. Tombol Kembali
        $("#btn-prev-soal").on("click", function() {
            if (currentStep > 0) {
                currentStep--;
                showSoal(currentStep);
            }
        });

        // Effect Visual: Highlight background opsi saat dipilih
        $(document).on("change", ".radio-input-opsi", function() {
            $(this).closest(".wrapper-soal-item").find(".label-pilihan-opsi").removeClass("bg-indigo-50 border-primary-custom").css("background-color", "#ffffff");
            if ($(this).is(":checked")) {
                $(this).closest(".label-pilihan-opsi").css("background-color", "#f3f4f6");
            }
        });
})
</script>
@endsection