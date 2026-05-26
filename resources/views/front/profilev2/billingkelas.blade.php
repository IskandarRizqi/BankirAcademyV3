<div class="row">
    <div class="col-lg-3">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action text-capitalize br-10 active" id="list-semua-list"
                data-toggle="list" href="#list-semua" role="tab" aria-controls="semua"
                onclick="loadbillingkelas('semua-billing')">semua</a>
            {{-- <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-pembayaran-list"
                data-toggle="list" href="#list-pembayaran" role="tab" aria-controls="pembayaran"
                onclick="loadbillingkelas('pembayaran-billing')">menunggu pembayaran</a> --}}
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-konfirmasi-list"
                data-toggle="list" href="#list-konfirmasi" role="tab" aria-controls="konfirmasi"
                onclick="loadbillingkelas('konfirmasi-billing')">menunggu pembayaran</a>
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-lunas-list"
                data-toggle="list" href="#list-lunas" role="tab" aria-controls="lunas"
                onclick="loadbillingkelas('lunas-billing')">lunas</a>
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-dibatalkan-list"
                data-toggle="list" href="#list-dibatalkan" role="tab" aria-controls="dibatalkan"
                onclick="loadbillingkelas('batal-billing')">dibatalkan</a>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-semua" role="tabpanel" aria-labelledby="list-semua-list">
                <div id="semua-billing">
                </div>
            </div>
            <div class="tab-pane fade" id="list-pembayaran" role="tabpanel" aria-labelledby="list-pembayaran-list">
                <div id="pembayaran-billing">
                    <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <p class="m-0">Pembayaran</p>
                            <p>
                                <b>INV-BLABLA</b>
                            </p>
                            <div class="row">
                                <div class="col-lg-9">
                                    <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan Pelanggan
                                        untuk Manajer
                                        Penjualan</h5>
                                    <p class="m-0">Tanggal pembelian: 09/08/2023 10:26</p>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-info" style="cursor: auto">Pembayaran</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="list-konfirmasi" role="tabpanel" aria-labelledby="list-konfirmasi-list">
                <div id="konfirmasi-billing">
                    <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <p class="m-0">Konfirmasi</p>
                            <p>
                                <b>INV-BLABLA</b>
                            </p>
                            <div class="row">
                                <div class="col-lg-9">
                                    <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan Pelanggan
                                        untuk Manajer
                                        Penjualan</h5>
                                    <p class="m-0">Tanggal pembelian: 09/08/2023 10:26</p>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-warning" style="cursor: auto">Konfirmasi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="list-lunas" role="tabpanel" aria-labelledby="list-lunas-list">
                <div id="lunas-billing">
                    <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <p class="m-0">Lunas</p>
                            <p>
                                <b>INV-BLABLA</b>
                            </p>
                            <div class="row">
                                <div class="col-lg-9">
                                    <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan Pelanggan
                                        untuk Manajer
                                        Penjualan</h5>
                                    <p class="m-0">Tanggal pembelian: 09/08/2023 10:26</p>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-info" style="cursor: auto">Lunas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="list-dibatalkan" role="tabpanel" aria-labelledby="list-dibatalkan-list">
                <div id="batal-billing">
                    <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <p class="m-0">Batal</p>
                            <p>
                                <b>INV-BLABLA</b>
                            </p>
                            <div class="row">
                                <div class="col-lg-9">
                                    <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan Pelanggan
                                        untuk Manajer
                                        Penjualan</h5>
                                    <p class="m-0">Tanggal pembelian: 09/08/2023 10:26</p>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-danger" style="cursor: auto">Batal</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Bukti-->
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="titlepayment"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="class_id" name="class_id" hidden>
                <input type="text" id="class_title" name="class_title" hidden>
                <input type="text" id="class_limit" name="class_limit" hidden>
                <input type="text" id="payment_id" name="payment_id" hidden>
                <input type="text" id="ref" name="ref" hidden>
                {{-- <div class="form-group">
                    <label for="">Kode Promo</label>
                    <input class="form-control" type="text" id="kode_promo" name="kode_promo">
                </div>
                <div class="form-group">
                    <label for="">Jumlah Peserta</label>
                    <input class="form-control" type="number" id="jml_peserta" name="jml_peserta">
                </div> --}}
                <div class="col-lg-12 bottommargin">
                    <label>Upload Bukti Pembayaran:</label><br>
                    <input id="input-3" name="input2[]" type="file" class="file" data-show-upload="false"
                        data-show-caption="true" data-show-preview="true" accept="image/*">
                    @error('input2')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="simpanbukti()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Peserta-->
<div class="modal fade" id="jumlahpesertaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="titlepayment"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="class_id2" name="class_id" hidden>
                <input type="text" id="class_title2" name="class_title" hidden>
                <input type="text" id="class_limit2" name="class_limit" hidden>
                <input type="text" id="payment_id2" name="payment_id" hidden>
                <input type="text" id="ref2" name="ref" hidden>
                <div class="form-group">
                    <label for="">Kode Promo</label>
                    <input class="form-control" type="text" id="kode_promo" name="kode_promo">
                </div>
                <div class="form-group">
                    <label for="">Jumlah Peserta</label>
                    <input class="form-control" type="number" id="jml_peserta" name="jml_peserta">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="simpanbukti()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Invoice-->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="GET" enctype="multipart/form-data" id="formInvoice">
                @csrf
                <div class="modal-header">
                    <h3 style="margin: 0px">Invoice</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="payment_invoice" name="payment_invoice" hidden>
                    <input type="text" id="sertifikat_invoice" name="sertifikat_invoice" hidden>
                    <input type="text" id="jmlp" name="jml_peserta" hidden>
                    <div class="row mb-1">
                        <div class="col-lg-4">
                            <label for="form-control">Kode promo</label>
                            <input class="form-control" type="text" id="kode_promo" name="kode_promo">
                        </div>
                        <div class="col-lg-4">
                            <label for="form-control">Jumlah peserta</label>
                            <input class="form-control" min="1" type="number" id="jml_pesertas" name="jml_peserta"
                                onchange="qtyjumlahpeserta()">
                        </div>
                        <div class="col-lg-4">
                            <label for="form-control">Sertifikat <span class="badge badge-danger"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Biaya cetak dan pengiriman per jumlah peserta akan ditambahkan pada invoice anda ">!</span></label>
                            <select name="sertifikat" class="form-control">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div id="detailpeserta"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="cetakInvoiceSertifikat()">Simpan dan cetak
                        invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function simpaninvoicenew() {
        $('#invoiceModal').modal('hide');
        $('#detailpeserta').html('');
    }

    function qtyjumlahpeserta() {
        // alert('asdsad')
        $('#detailpeserta').html('');
        let jmlpsrt = $('#jml_pesertas').val();
        let detail = '';
        if (jmlpsrt > 0) {
            for (let i = 0; i < jmlpsrt; i++) {
                detail += '    <div class="row">'
                detail += '        <div class="col-lg-4">'
                detail += '            <label for="form-control">Nama lengkap</label>'
                detail += '            <input type="text" class="form-control" name="nama[]">'
                detail += '        </div>'
                detail += '        <div class="col-lg-4">'
                detail += '            <label for="form-control">Email aktif</label>'
                detail += '            <input type="email" class="form-control" name="email[]">'
                detail += '        </div>'
                detail += '        <div class="col-lg-4">'
                detail += '            <label for="form-control">Nomor Handphone</label>'
                detail += '            <input type="number" class="form-control" name="nomor_handphone[]">'
                detail += '        </div>'
                detail += '    </div>'
            }
        }
        $('#detailpeserta').html(detail);
    }
    let class_image = 0;

function loadbillingkelas(type) {
    console.log("type", type);
    let t = 100;
    let s = false;
    let tglbayar = '';
    
    if (type == 'pembayaran-billing') { t = 3; s = 'menunggu pembayaran'; }
    if (type == 'konfirmasi-billing') { t = 2; s = 'menunggu konfirmasi'; }
    if (type == 'lunas-billing') { t = 1; s = 'lunas'; }
    if (type == 'batal-billing') { t = 0; s = 'batal'; }
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Loader transparan Swal
    Swal.fire({
        background: '#0069d900',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    $.ajax({
        url: '/getbillingkelas/' + t,
        method: 'GET',
        success: function(response) {
            let h = '';
            if (response.status == 1 && response.data.billingkelasall.length > 0) {
                response.data.billingkelasall.forEach(v => {
                    
                    // Format Tanggal Indonesia
                    let tglOrder = new Date(v.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                    tglbayar = v.file && v.status != 0 ? new Date(v.updated_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
                    
                    // Penentuan warna badge status dinamis
                    let badgeClass = 'bg-secondary';
                    if (v.status_pembayaran == 'Menunggu Pembayaran') { badgeClass = 'bg-warning text-dark'; }
                    else if (v.status_pembayaran == 'Menunggu Konfirmasi') { badgeClass = 'bg-info text-white'; }
                    else if (v.status_pembayaran == 'Lunas' || v.status_pembayaran == 'Berhasil') { badgeClass = 'text-white bg-success'; }
                    else if (v.status_pembayaran == 'Dibatalkan' || v.status_pembayaran == 'Expired') { badgeClass = 'bg-danger'; }

                    // LOGIKA BARU: Cek invoice khusus Payment Gateway (mengandung kata BANKIR)
                    let targetUrl = '/laman-pembayaran/' + v.id;
                    let targetTarget = ''; // Default buka di tab yang sama
                    
                    if (v.no_invoice && v.no_invoice.toUpperCase().includes('BANKIR')) {
                        // Jika ada link file/payment gateway, arahkan ke file. Jika kosong, fallback ke detail biasa.
                        targetUrl = v.file ? v.file : '#'; 
                        targetTarget = v.file ? 'target="_blank"' : ''; // Buka di tab baru untuk link eksternal/payment gateway
                    }

                    // Template Card List UI 
                    h += '<div class="card border-0 shadow-sm rounded-4 mb-3" style="background: #ffffff; border-left: 5px solid #0d6efd !important;">';
                    h += '  <div class="card-body p-4">';
                    h += '      <div class="row g-3 align-items-center">';
                    
                    // Kolom 1: No Invoice & Nama Event/Kelas
                    h += '          <div class="col-lg-4 col-md-6 col-12">';
                    h += '              <span class="text-muted d-block small fw-semibold text-uppercase tracking-wider">No. Invoice</span>';
                    h += '              <span class="text-primary fw-bold d-block mb-1">' + v.no_invoice + '</span>';
                    h += '              <h6 class="fw-bold text-dark mb-0">' + v.title + '</h6>';
                    h += '          </div>';
                    
                    // Kolom 2: Informasi Tanggal
                    h += '          <div class="col-lg-3 col-md-6 col-12">';
                    h += '              <div class="mb-1">';
                    h += '                  <span class="text-muted small">Tgl. Order: </span>';
                    h += '                  <span class="fw-semibold text-secondary small">' + tglOrder + '</span>';
                    h += '              </div>';
                    h += '              <div>';
                    h += '                  <span class="text-muted small">Tgl. Bayar: </span>';
                    h += '                  <span class="fw-semibold text-secondary small">' + tglbayar + '</span>';
                    h += '              </div>';
                    h += '          </div>';
                    
                    // Kantong Flexbox Status & Button (Anti-Tabrakan)
                    h += '          <div class="col-lg-5 col-md-12 col-12 mt-3 mt-lg-0">';
                    h += '              <div class="d-flex flex-row flex-md-row justify-content-between align-items-center flex-wrap gap-2 justify-content-lg-end">';
                    
                    // Status Badge
                    h += '                  <div class="me-lg-3">';
                    h += '                      <span class="badge ' + badgeClass + ' rounded-pill px-3 py-2 fw-semibold text-capitalize text-wrap" style="max-width: 180px;">' + v.status_pembayaran + '</span>';
                    h += '                  </div>';
                    
                    // Button Lihat Detail / Bayar (Dinonaktifkan jika URL '#' atau diarahkan ke targetUrl baru)
                    h += '                  <div class="w-100 w-sm-auto text-end">';
                    h += '                      <a href="' + targetUrl + '" ' + targetTarget + ' class="btn btn-sm btn-outline-primary rounded-3 px-4 py-2 fw-bold d-inline-flex align-items-center justify-content-center ' + (targetUrl === '#' ? 'disabled' : '') + '">';
                    h += '                          Lihat Detail <i class="fa-solid fa-arrow-right ms-2"></i>';
                    h += '                      </a>';
                    h += '                  </div>';
                    
                    h += '              </div>'; // End Flex
                    h += '          </div>'; // End Kolom Gabungan
                    
                    h += '      </div>'; // End Row
                    h += '  </div>'; // End Card Body
                    h += '</div>'; // End Card
                });
                
                $('#' + type).html(h);
            } else {
                $('#' + type).html('<div class="text-center text-muted my-5 py-5"><i class="fa-solid fa-folder-open fa-2x mb-2 d-block text-black-50"></i>Belum ada data transaksi.</div>');
            }
            Swal.close();
        },
        error: function(response) {
            console.log(response);
            iziToast.warning({
                title: 'Gagal',
                message: 'Harap reload halaman atau hubungi admin',
                position: 'topRight',
            });
            Swal.close();
        }
    });
}

    function bukti(limit, title, class_id, payment, ref, kodepromo, jml_peserta, file, index) {
        $('#class_id').val(class_id);
        $('#payment_id').val(payment);
        $('#class_title').val(title);
        $('#class_limit').val(limit);
        $('#ref').val(ref);

        $('#class_id2').val(class_id);
        $('#payment_id2').val(payment);
        $('#class_title2').val(title);
        $('#class_limit2').val(limit);
        $('#ref2').val(ref);

        if (kodepromo !== 'null') {
            $('#kode_promo').val(kodepromo);
        }
        $('#jml_peserta').val(jml_peserta);
        class_image = index;

        $('#titlepayment').html(decodeURIComponent(title))
    }

    function simpanbukti() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // loader transparant
        Swal.fire({
            background: '#0069d900',
            didOpen: () => {
                Swal.showLoading();
            }
        })
        var fd = new FormData();
        var gambar = $('#input-3')[0].files[0];
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
                if (response.status == 1) {
                    if (response.data) {
                        $('.class_image' + class_image).attr('href', '/getBerkas?rf=' + response.data.file)
                        $('.class_imagenya' + class_image).attr('src', '/getBerkas?rf=' + response.data.file)
                    }
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Input Berhasil',
                        position: 'topRight',
                    });
                    $('#bayarModal').modal('hide')
                    location.reload()
                } else {
                    iziToast.warning({
                        title: 'Gagal',
                        message: response.message,
                        position: 'topRight',
                    });
                }
                Swal.close()
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Input Gagal',
                    position: 'topRight',
                });
                Swal.close()
            }
        });
    }

    function langsungcetak(id, sertifikat, jml_peserta) {

        $('#payment_invoice').val(id);
        $('#sertifikat_invoice').val(sertifikat);
        // $('#jmlp').val(jml_peserta);
        $('#formInvoice').attr('action', '/classes/getinvoice/id');
        $('#formInvoice').submit();
    }

    function modalinvoice(id) {
        $('#payment_invoice').val(id);
    }

    function cetakInvoice() {
        $('#sertifikat_invoice').val(0);
        $('#formInvoice').attr('action', '/classes/getinvoice/id');
        $('#formInvoice').submit();
        $('#invoiceModal').modal('hide');
        $('#detailpeserta').html('');
    }

    function cetakInvoiceSertifikat(paymentId) {
    if (!paymentId) {
        Swal.fire({
            title: "Pemberitahuan",
            text: "ID Pembayaran tidak ditemukan.",
            icon: "error"
        });
        return false;
    }

    // Pastikan Anda memiliki input dengan name/id 'payment_invoice' di dalam #formInvoice Anda
    // Jika belum ada di HTML, fungsi ini akan mencoba mengisi element id #payment_invoice
    if($('#payment_invoice').length) {
        $('#payment_invoice').val(paymentId);
    } else {
        // Fallback jika id inputnya adalah payment_id2 seperti pada modal data Anda
        $('#payment_id2').val(paymentId); 
        // Ubah attribute name-nya menjadi payment_invoice agar dibaca oleh Request $r->payment_invoice di Controller
        $('#payment_id2').attr('name', 'payment_invoice'); 
    }
    
    // Set sertifikat_invoice default aktif (sesuai kebutuhan bisnis logic Anda)
    $('#sertifikat_invoice').val(1);
    
    // Arahkan action URL ke ID yang dinamis sesuai data baris yang di klik
    $('#formInvoice').attr('action', '/classes/getinvoice/' + paymentId);
    $('#formInvoice').attr('target', '_blank');
    
    // Kirim data form ke controller
    $('#formInvoice').submit();
    
    // Bersihkan sisa-sisa modal (jika ada)
    if($('#invoiceModal').length) {
        $('#invoiceModal').modal('hide');
    }
    $('#detailpeserta').html('');
}
</script>