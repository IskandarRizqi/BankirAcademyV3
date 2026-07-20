@extends('layouts.compact')

@section('content')
<div class="container-fluid px-2 px-md-4 mt-3" id="cancel-row">
    
    <div class="row mb-3">
        <div class="col-12">
            <div class="mb-2">
                <a href="{{ route('siswa.umum.index') }}" class="btn btn-sm btn-white border px-3 py-2 bg-white d-inline-flex align-items-center shadow-sm" style="border-radius:8px; color:#64748b;">
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
            
            @if($contentType && $quizAktif)
        <div class="card shadow-sm custom-card p-3 p-md-4 bg-white" style="border-radius: 16px;">
            <div class="d-flex flex-row justify-content-between align-items-center border-bottom pb-3 mb-3">
                <span class="badge badge-pill {{ $contentType === 'pre' ? 'badge-warning text-dark' : 'badge-danger' }} px-3 py-2 font-weight-bold" style="font-size: 0.75rem;">
                    <i class="fas fa-file-signature mr-1"></i> {{ $contentType === 'pre' ? 'PRE-TEST' : 'POST-TEST' }}
                </span>
                <span class="text-muted small font-weight-bold text-right ml-2" style="font-size: 0.75rem;"><i class="far fa-clock mr-1"></i> Pilihan Ganda</span>
            </div>
            
           <div id="section-panduan" class="p-4 border-0 shadow-sm position-relative overflow-hidden bg-white" 
     style="border-radius: 20px; border: 1px solid #e2e8f0 !important;">
    
    <div class="text-center">
        <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm" 
             style="width: 64px; height: 64px; background: linear-gradient(135deg, #e0e7ff 0%, #eef2ff 100%);">
            <i class="fas {{ $contentType === 'pre' ? 'fa-rocket text-indigo' : 'fa-trophy text-danger' }} fa-lg" style="font-size: 1.5rem; color: #4f46e5;"></i>
        </div>
        <h4 class="font-weight-bold text-dark mb-2" style="letter-spacing: -0.5px;">
            {{ $contentType === 'pre' ? 'Siap Mengerjakan Pre-Test?' : 'Siap Menghadapi Post-Test?' }}
        </h4>
        <p class="text-muted mx-auto small-mobile-text" style="max-width: 480px; font-size: 0.9rem; line-height: 1.5;">
            {{ $contentType === 'pre' ? 'Uji pemahaman awalmu sebelum masuk kelas. Kerjakan dengan santai untuk mengukur skill dasarmu!' : 'Saatnya membuktikan hasil belajarmu di bab ini. Kerjakan dengan performa terbaikmu!' }}
        </p>
    </div>

    <hr class="my-4" style="border-top: 1px dashed #e2e8f0;">

    <div class="row mb-4">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="text-center h-100 rounded-lg border bg-light-gradient" style="border-radius: 14px; border-color: #f1f5f9 !important; background: #fafafa;">
                <div class="text-primary mb-2 shadow-2xs d-inline-flex bg-white rounded-lg">
                    <i class="fas fa-list-ol fa-fw"></i>
                </div>
                <h6 class="font-weight-bold text-dark mb-1" style="font-size: 0.85rem;">Tipe Soal</h6>
                <p class="text-secondary mb-0" style="font-size: 0.78rem;">Pilihan Ganda (Single Choice)</p>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="text-center h-100 rounded-lg border bg-light-gradient" style="border-radius: 14px; border-color: #f1f5f9 !important; background: #fafafa;">
                <div class="text-success mb-2 shadow-2xs d-inline-flex bg-white rounded-lg">
                    <i class="fas fa-user-shield fa-fw"></i>
                </div>
                <h6 class="font-weight-bold text-dark mb-1" style="font-size: 0.85rem;">Integritas</h6>
                <p class="text-secondary mb-0" style="font-size: 0.78rem;">100% Jujur & Tanpa Menyontek</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="text-center h-100 rounded-lg border bg-light-gradient" style="border-radius: 14px; border-color: #f1f5f9 !important; background: #fafafa;">
                <div class="text-warning mb-2 shadow-2xs d-inline-flex bg-white rounded-lg">
                    <i class="fas fa-bullseye fa-fw"></i>
                </div>
                <h6 class="font-weight-bold text-dark mb-1" style="font-size: 0.85rem;">Fokus & Teliti</h6>
                <p class="text-secondary mb-0" style="font-size: 0.78rem;">Baca cermat sebelum klik submit</p>
            </div>
        </div>
    </div>

    <div class="p-3 mb-4 d-flex align-items-start rounded-lg" style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px;">
        <i class="fas fa-info-circle text-warning mr-3 mt-1" style="font-size: 1.1rem;"></i>
        <div class="small-mobile-text text-warning-dark" style="font-size: 0.8rem; color: #92400e; line-height: 1.5;">
            <strong>Catatan Penting:</strong> Setelah Anda menekan tombol mulai, pastikan koneksi internet stabil. Anda tidak dapat mengulang tes ini setelah jawaban dikirimkan.
        </div>
    </div>

    <div class="text-center">
        <button type="button" id="btn-mulai-kuis" class="btn btn-primary px-5 py-3 font-weight-bold shadow btn-modern btn-lg-responsive w-xs-100" 
                style="border-radius: 50px; font-size: 0.95rem; letter-spacing: 0.3px; transition: all 0.3s ease;">
            <i class="fas fa-play-circle mr-2 fa-lg align-middle"></i> Mulai Ujian Sekarang
        </button>
    </div>
</div>
            <form action="{{ route('siswa.materi.simpan_test', [$subMateriAktif->id, $quizAktif->id]) }}" method="POST" id="form-kuis" class="d-none">
                @csrf
                <input type="hidden" name="classid" value="{{ $subMateriAktif->id }}">
                
                @php
                    $daftarSoal = is_string($quizAktif->soal) ? json_decode($quizAktif->soal, true) : $quizAktif->soal;
                @endphp

                @if(is_array($daftarSoal) && count($daftarSoal) > 0)
                    <div class="progress mb-4 shadow-sm" style="height: 8px; border-radius: 10px;">
                        <div id="quiz-progress-bar" class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>

                    @foreach($daftarSoal as $indexSoal => $item)
                        <div class="wrapper-soal-item d-none" data-soal-index="{{ $indexSoal }}" id="box-soal-{{ $indexSoal }}">
                            <div class="mb-4 p-3 p-md-4 border-0 rounded-lg bg-light shadow-sm" style="border-radius: 12px;">
                                <h6 class="font-weight-bold text-dark mb-3 d-flex align-items-start" style="line-height: 1.6; font-size: 0.95rem;">
                                    <span class="badge badge-dark mr-2 px-2 py-1 flex-shrink-0" style="border-radius: 6px;">{{ $indexSoal + 1 }} dari {{ count($daftarSoal) }}</span> 
                                    <span class="flex-grow-1 pt-0.5 small-mobile-text">{{ $item['pertanyaan'] ?? $item['pertanyaan'] ?? '' }}</span>
                                </h6>
                                
                                <div class="mt-3">
                                    @if(isset($item['opsi']) && is_array($item['opsi']))
                                        @foreach($item['opsi'] as $keyOpsi => $valOpsi)
                                            <label class="opsi-label d-flex align-items-center p-3 mb-2 bg-white shadow-sm rounded-lg label-pilihan-opsi" style="cursor: pointer; transition: all 0.2s;">
                                                <input type="radio" name="jawaban[{{ $indexSoal }}]" value="{{ $keyOpsi }}" class="opsi-radio mr-3 flex-shrink-0 radio-input-opsi" required style="width: 18px; height: 18px; accent-color: #4f46e5;">
                                                <span class="opsi-text text-dark small-mobile-text"><strong>{{ $keyOpsi }}.</strong> {{ $valOpsi }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-3">
                        <button type="button" id="btn-prev-soal" class="btn btn-outline-secondary btn-block-mobile px-4 py-2 font-weight-bold rounded-lg" disabled>
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </button>
                        
                        <button type="button" id="btn-next-soal" class="btn btn-primary btn-block-mobile px-4 py-2 font-weight-bold shadow-sm btn-modern rounded-lg">
                            Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <button type="submit" id="btn-submit-kuis" class="btn btn-success btn-block-mobile px-5 py-2.5 font-weight-bold shadow-sm btn-modern d-none rounded-lg">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Jawaban
                        </button>
                    </div>
                @else
                    <div class="text-center py-5 text-muted bg-light rounded" style="border-radius: 12px;">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2 text-warning"></i>
                        <p class="mb-0"><em>Format soal kuis tidak valid atau data kosong.</em></p>
                    </div>
                @endif
            </form>
        </div>
    @else
                <div class="media-holder mb-4 shadow-sm bg-black rounded overflow-hidden position-relative" style="min-height: 350px;">
                    @if($itemAktif)
                        
                        @if(!$sudahIkuti)
                        <div id="lockedScreen" class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: rgba(15, 23, 42, 0.85); z-index: 5; top: 0; left: 0; backdrop-filter: blur(4px);">
                            <div class="mb-3 p-4 bg-soft-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; background: rgba(59, 130, 246, 0.2); border: 2px dashed #3b82f6;">
                                <i class="fas fa-lock text-primary fa-2x animate-bounce"></i>
                            </div>
                            <h5 class="text-white font-weight-bold mb-2">Materi Terkunci!</h5>
                            <p class="text-white-50 small max-w-md px-md-5 mb-4">
                                Anda harus bergabung ke materi <strong>{{ $subMateriAktif->nama }}</strong> terlebih dahulu sebelum dapat melihat media pembelajaran.
                            </p>
                            
                            <form id="formIkutiPelatihan" action="{{ route('siswa.umum.ikuti', $subMateriAktif->id) }}" method="POST">
                                @csrf
                                <button type="button" onclick="konfirmasiIkuti()" class="btn btn-primary px-4 py-2.5 font-weight-bold shadow border-0 d-inline-flex align-items-center" style="border-radius: 30px; gap: 8px;">
                                    <i class="fas fa-play-circle"></i> Ikuti Pelatihan Ini
                                </button>
                            </form>
                        </div>
                        @endif

                        <div id="mediaContent" style="{{ !$sudahIkuti ? 'filter: blur(8px); pointer-events: none;' : '' }}">
                            @if($itemAktif->tipe_link_item == 0) 
                                <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                                    <iframe src="{{ $sudahIkuti ? $embedUrl : '' }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="pdf-wrapper" style="height: 550px; max-height: 75vh;">
                                    <iframe src="{{ $sudahIkuti ? $embedUrl : '' }}" width="100%" height="100%" style="border: none;"></iframe>
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
            @endif
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
                    
                    @if($preTest)
                        @if(!$sudahIkuti)
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 ml-1 flex-shrink-0"><i class="fas fa-lock text-secondary"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">TAHAP AWAL</span>
                                    <div class="text-truncate small">{{ $preTest->judul }}</div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('siswa.umum.belajar', $subMateriAktif->id) }}?type=pre" class="playlist-item d-flex align-items-center p-3 text-decoration-none playlist-active" style="border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 ml-1 flex-shrink-0">
                                    <i class="fas fa-file-signature fa-lg text-warning"></i>
                                </div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">TAHAP AWAL</span>
                                    <div class="text-truncate text-dark small">{{ $preTest->judul }}</div>
                                </div>
                            </a>
                        @endif
                    @endif

                    <div class="bg-light px-4 py-2 text-muted font-weight-bold border-bottom" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                        MATERI PELAJARAN ({{ count($materiAktif->subMateri ?? []) }} BAB)
                    </div>
                    
                    @foreach($materiAktif->subMateri as $index => $sub)
                        @php
                            $isLocked = false;

                            if (!$sudahIkuti) {
                                $isLocked = true;
                            } else {
                                if ($statusBeasiswaSiswa == 1 && $preTest && (!$userProgress || is_null($userProgress->nilai_awal))) {
                                    $isLocked = true;
                                }
                                // Lock jika bab sebelumnya belum berstatus selesai di DB
                                if ($index > 0) {
                                    $prevMateriValid = $materiAktif->subMateri[$index - 1];
                                    if ($prevMateriValid && !in_array($prevMateriValid->id, $subMateriSelesaiIds ?? [])) {
                                        $isLocked = true;
                                    }
                                }
                            }
                            
                            $isBabAktif = ($subMateriAktif && $subMateriAktif->id == $sub->id);
                        @endphp

                        @if($isLocked)
                           <p></p>
                        @else
                            <div class="p-3 {{ $isBabAktif ? 'bg-light border-left-primary' : '' }}" style="border-bottom: 1px solid #edf2f7;">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="mr-3 ml-1 flex-shrink-0">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="w-100 overflow-hidden">
                                        <span class="d-block text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem;">Materi {{ $index + 1 }}</span>
                                        <div class="text-truncate text-dark small {{ $isBabAktif ? 'font-weight-bold' : '' }}">{{ $sub->nama }}</div>
                                    </div>
                                </div>

                                @if($sub->items && $sub->items->count() > 0)
                                    <div class="mt-2 pl-2 ml-2" style="border-left: 2px solid #e2e8f0;">
                                        @foreach($sub->items as $mediaItem)
                                            <div class="d-flex align-items-center py-2 px-2 my-1 text-muted small rounded" style="font-size: 0.78rem; cursor: not-allowed; opacity: 0.6; background: #f8fafc;">
                                                <i class="fas fa-lock mr-2 text-secondary flex-shrink-0" style="font-size: 0.7rem;"></i>
                                                <span class="text-truncate">{{ $mediaItem->judul_item }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    @if($postTest && $statusBeasiswaSiswa == 1)
                        @php
                            // Validasi kelulusan post test: bandingkan total bab aktif dengan total bab yang complete di DB
                            $isPostTestLocked = !($sudahTerkunci ?? false) || (count(array_intersect($materiAktif->subMateri->pluck('id')->toArray(), $subMateriSelesaiIds ?? [])) < count($materiAktif->subMateri));
                        @endphp

                        @if($isPostTestLocked)
                            <div class="playlist-item d-flex align-items-center p-3 text-muted" style="cursor: not-allowed; opacity: 0.6; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                                <div class="mr-3 ml-1 flex-shrink-0"><i class="fas fa-lock text-secondary"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">KELULUSAN</span>
                                    <div class="text-truncate small">🏆 Post-Test: {{ $postTest->judul }}</div>
                                    <small class="text-danger d-block mt-1" style="font-size: 0.65rem;"><i class="fas fa-info-circle mr-1"></i>Selesaikan semua materi</small>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('siswa.materi.belajar', $materiAktif->id) }}?type=post" class="playlist-item d-flex align-items-center p-3 text-decoration-none playlist-active">
                                <div class="mr-3 ml-1 flex-shrink-0"><i class="fas fa-trophy text-danger fa-lg"></i></div>
                                <div class="w-100 overflow-hidden">
                                    <span class="d-block text-muted font-weight-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">KELULUSAN</span>
                                    <div class="text-truncate text-dark small">🏆 Post-Test: {{ $postTest->judul }}</div>
                                </div>
                            </a>
                        @endif
                    @endif
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