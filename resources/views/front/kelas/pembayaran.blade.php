<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran Anda</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333;
        }
        .pay-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            background: #ffffff;
        }
        .invoice-badge {
            background-color: #e8f0fe;
            color: #1a73e8;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.85rem;
        }
        .bank-option {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            background: #fff;
        }
        .btn-copy {
            background: none;
            border: none;
            color: #0d6efd;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .btn-copy:hover {
            background-color: #f0f7ff;
            color: #0a58ca;
        }
        .total-box {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 16px;
            border: 1px dashed #cbd5e1;
        }
        /* --- STYLING TAMBAHAN UNTUK KONDISI LUNAS --- */
        .total-box.lunas-box {
            background-color: #f0fdf4;
            border: 1px dashed #bbf7d0;
        }
        .success-animation {
            font-size: 4.5rem;
            color: #22c55e;
            animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes scaleIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="text-center mb-5">
                <h2 class="fw-bold">Selesaikan Pembayaran</h2>
                <p class="text-muted">Silakan ikuti instruksi pembayaran di bawah ini untuk mengaktifkan kelas Anda.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card pay-card p-4 d-flex flex-column gap-4 justify-content-center">
                        
                        @if($order->status == 1)
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fa-solid fa-circle-check success-animation"></i>
                                </div>
                                <h4 class="fw-bold text-success mb-2">Pembayaran Lunas!</h4>
                                <p class="text-muted px-4">Terima kasih, pembayaran Anda telah berhasil kami verifikasi secara otomatis. Kelas Anda kini sudah aktif dan siap diakses.</p>
                                <div class="mt-4">
                                    <!-- <a href="/dashboard" class="btn btn-success btn-lg rounded-3 fw-bold px-4 shadow-sm">
                                        <i class="fa-solid fa-graduation-cap me-2"></i>Mulai Belajar Sekarang
                                    </a> -->
                                </div>
                            </div>
                        @else
                            <div>
                                <h5 class="fw-bold mb-3"><i class="fa-solid fa-credit-card text-primary me-2"></i>1. Rekening Tujuan Transfer</h5>
                                <div class="bank-option d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" width="70" height="25" style="object-fit: contain;">
                                        <div>
                                            <span class="d-block fw-bold text-secondary small">Bank BCA</span>
                                            <span class="fw-bold text-dark fs-5" id="rek-bca">8035559091</span>
                                            <span class="d-block text-muted small">a/n PT. Bankir Academy Indonesia</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-copy" onclick="copyToClipboard('8035559091', 'Nomor Rekening BCA')">
                                        <i class="fa-regular fa-copy me-1"></i> Salin
                                    </button>
                                </div>
                                <div class="mt-3 bg-light p-3 rounded-3 small text-muted">
                                    <i class="fa-solid fa-circle-info text-primary me-1"></i> <strong>Penting:</strong> Mohon transfer tepat hingga 3 digit terakhir agar sistem kami dapat memverifikasi pembayaran secara otomatis.
                                </div>
                            </div>

                            <hr class="my-1 text-muted opacity-25">

                            <div>
                                <h5 class="fw-bold mb-3"><i class="fa-solid fa-cloud-arrow-up text-primary me-2"></i>2. Upload Bukti Transaksi</h5>
                                
                                <input type="hidden" id="class_id" value="{{ $kelas->id }}">
                                <input type="hidden" id="class_title" value="{{ $kelas->title }}">
                                <input type="hidden" id="class_limit" value="{{ $order->participant_limit ?? '' }}">
                                <input type="hidden" id="payment_id" value="{{ $order->id }}">
                                <input type="hidden" id="kode_promo" value="{{ $order->kode_promo ?? '' }}">
                                <input type="hidden" id="jml_peserta" value="{{ $order->jumlah }}">

                                <div class="mb-3">
                                    <label class="form-label small text-secondary fw-semibold">Pilih File Bukti Pembayaran (JPG/PNG)</label>
                                    <input id="input-3" type="file" class="form-control rounded-3" accept="image/*">
                                    @error('input2')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="button" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold shadow-sm mt-2" onclick="simpanbukti_halaman()">
                                    <i class="fa-solid fa-circle-check me-2"></i>Kirim Bukti Pembayaran
                                </button>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card pay-card p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold m-0"><i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>Detail Transaksi</h5>
                                <span class="invoice-badge">
                                    {{ $order->no_invoice }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <span class="text-muted small d-block">Nama Kelas</span>
                                <h6 class="fw-bold text-dark mb-1">{{ $kelas->title }}</h6>
                                <div class="d-flex gap-2 mt-1">
                                    <span class="badge bg-secondary fw-normal">{{ $order->jumlah }} Peserta</span>
                                    @if($order->biaya_sertifikat > 0)
                                        <span class="badge bg-info fw-normal text-white">Termasuk Sertifikat</span>
                                    @endif
                                    
                                    @if($order->status == 1)
                                        <span class="badge bg-success fw-normal text-white">Lunas</span>
                                    @endif
                                </div>
                            </div>

                            <hr class="text-muted opacity-25">

                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Subtotal Kelas</span>
                                <span class="fw-semibold">Rp {{ number_format($order->price * $order->jumlah, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($order->biaya_sertifikat > 0)
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Biaya Sertifikat</span>
                                <span class="fw-semibold">Rp {{ number_format($order->biaya_sertifikat, 0, ',', '.') }}</span>
                            </div>
                            @endif

                            <div class="d-flex justify-content-between mb-3 small">
                                <span class="text-muted">Kode Unik <i class="fa-regular fa-circle-question" data-bs-toggle="tooltip" title="Angka acak unik untuk mempercepat verifikasi otomatis"></i></span>
                                <span class="text-success fw-semibold">+Rp {{ $order->unique_code }}</span>
                            </div>

                            @php 
                                $grandTotal = $order->price_final + $order->unique_code;
                            @endphp
                            
                            <div class="total-box d-flex justify-content-between align-items-center mb-3 {{ $order->status == 1 ? 'lunas-box' : '' }}">
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Total Pembayaran</span>
                                    <h3 class="fw-bold {{ $order->status == 1 ? 'text-success' : 'text-primary' }} m-0" id="totalAmount">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h3>
                                </div>
                                @if($order->status != 1)
                                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" onclick="copyToClipboard('{{ $grandTotal }}', 'Nominal Transfer')">
                                    <i class="fa-regular fa-copy"></i> Salin
                                </button>
                                @else
                                <span class="badge bg-success py-2 px-3 rounded-3 fw-bold"><i class="fa-solid fa-check-double me-1"></i> PAID</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4">
                            <a target="_blank" href="{{ url('/classes/getinvoice/' . $order->id) }}?payment_invoice={{ $order->id }}" class="btn btn-light border w-100 rounded-3 mb-2 fw-semibold text-secondary">
                                <i class="fa-solid fa-file-pdf text-danger me-2"></i>Download Invoice (PDF)
                            </a>

                            <a href="/profile" class="btn btn-link btn-sm w-100 text-muted text-decoration-none text-center block mt-2">
                                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast align-items-center text-white bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">
        Berhasil menyalin data!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function copyToClipboard(text, label) {
        navigator.clipboard.writeText(text).then(function() {
            var toastEl = document.getElementById('liveToast');
            var toastMessage = document.getElementById('toastMessage');
            toastMessage.innerHTML = `<i class="fa-solid fa-circle-check text-success me-2"></i> ${label} berhasil disalin!`;
            
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }, function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }

    function simpanbukti_halaman() {
        var gambar = $('#input-3')[0].files[0];
        
        if(!gambar) {
            iziToast.warning({
                title: 'Perhatian',
                message: 'Silakan pilih file gambar bukti transfer terlebih dahulu!',
                position: 'topRight',
            });
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Swal.fire({
            background: '#0069d900',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        var fd = new FormData();
        fd.append('gambar', gambar);
        fd.append('kode', $('#kode_promo').val());
        fd.append('jumlah', $('#jml_peserta').val());
        fd.append('class_id', $('#class_id').val());
        fd.append('class_title', $('#class_title').val());
        fd.append('limit', $('#class_limit').val());
        fd.append('payment_id', $('#payment_id').val());

        $.ajax({
            processData: false,
            contentType: false,
            url: '/bayarv2',
            method: 'POST',
            data: fd,
            enctype: 'multipart/form-data',
            success: function(response) {
                Swal.close();
                if (response.status == 1) {
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Bukti pembayaran berhasil diunggah',
                        position: 'topRight',
                    });
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else {
                    iziToast.warning({
                        title: 'Gagal',
                        message: response.message,
                        position: 'topRight',
                    });
                }
            },
            error: function(response) {
                console.log(response);
                Swal.close();
                iziToast.error({
                    title: 'Gagal',
                    message: 'Terjadi kesalahan sistem, silakan coba lagi.',
                    position: 'topRight',
                });
            }
        });
    }
</script>
</body>
</html>