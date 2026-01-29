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
                    <!-- <p style="margin: 0px; font-size: 21px">Apakah anda
                        ingin mencetak dengan sertifikat?</p>
                    <span class="badge bg-danger text-white">
                        <div class="spinner-grow spinner-grow-sm">
                        </div>
                        <small style="font-size: 12px">Biaya cetak dan
                            pengiriman Rp. 100.000/kelas ditambahkan ke
                            invoice anda. </small>
                    </span> -->
                    <!-- <div class="d-flex justify-content-center mt-4">
                        <span class="btn btn-warning" target="_blank" title="Invoice"
                            onclick="cetakInvoice()">Tidak</span>
                        <span class="btn btn-primary ml-2" target="_blank" title="Invoice"
                            onclick="cetakInvoiceSertifikat()">Ya</span>
                    </div> -->
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
        let t = 100;
        let s = false;
        let tglbayar = '';
        if (type == 'pembayaran-billing') {
            t = 3;
            s = 'menunggu pembayaran';
        }
        if (type == 'konfirmasi-billing') {
            t = 2;
            s = 'menunggu konfirmasi';
        }
        if (type == 'lunas-billing') {
            t = 1;
            s = 'lunas';
        }
        if (type == 'batal-billing') {
            t = 0;
            s = 'batal';
        }
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
        $.ajax({
            url: '/getbillingkelas/' + t,
            method: 'GET',
            success: function(response) {
                let h = '';
                if (response.status == 1) {
                    let n = 0;
                    response.data.billingkelasall.forEach(v => {
                        n++;
                        let r = 'readonly';
                        if (v.status_pembayaran == 'Menunggu Konfirmasi') {
                            r = '';
                        }
                        if (v.status_pembayaran == 'Menunggu Pembayaran') {
                            r = '';
                        }
                        // console.log(encodeURIComponent(v.title));
                        let title = encodeURIComponent(v.title);
                        if (!s) {
                            s = v.status == 1 ? 'Lunas' : 'Batal';
                        }

                        if (v.file && v.status == 0) {
                            s = 'menunggu pembayaran'
                        }
                        // if (v.file && v.status == 0) {
                        //     s = 'menunggu konfirmasi'
                        //     tglbayar = new Date(v.updated_at).toLocaleDateString('id-ID')
                        // }
                        if (v.file && v.status != 0) {
                            tglbayar = new Date(v.updated_at).toLocaleDateString('id-ID')
                        }
                        let file = encodeURIComponent(v.file);
                        h += '<div class="card br-10 mb-4" style="background-color: #f7f7f7">';
                        h += '<div class="card-body">';
                        h += '<div class="d-flex justify-content-between">';
                        h += '<div class="d-flex flex-wrap" style="width:100%;">';

                        // Kolom 1–4 (baris pertama)
                        h += '    <div style="flex:0 0 25%; max-width:25%; padding:5px;">';
                        h += '        <small class="text-secondary">No. Invoice</small>';
                        h += '        <p class="text-uppercase"><b>' + v.no_invoice + '</b></p>';
                        h += '    </div>';

                        h += '    <div style="flex:0 0 25%; max-width:25%; padding:5px;">';
                        h += '        <small class="text-secondary">Event</small>';
                        h += '        <p class="text-uppercase"><b>' + v.title + '</b></p>';
                        h += '    </div>';

                        h += '    <div style="flex:0 0 25%; max-width:25%; padding:5px;">';
                        h += '        <small class="text-secondary">Tgl.Order</small>';
                        h += '        <p class="text-uppercase"><b>' + new Date(v.created_at).toLocaleDateString('id-ID') + '</b></p>';
                        h += '    </div>';

                        h += '    <div style="flex:0 0 25%; max-width:25%; padding:5px;">';
                        h += '        <small class="text-secondary">Tgl.Pembayaran</small>';
                        h += '        <p class="text-uppercase"><b>' + tglbayar + '</b></p>';
                        h += '    </div>';


                        // h += '    <div style="flex:0 0 25%; max-width:25%; padding:5px;">';
                        // h += '        <small class="text-secondary">Gambar</small><br><br>';

                        // if (v.file && v.file !== '') {
                        //     h += '        <a href="#" onclick="window.open(\'/getBerkasbukti?rf=' + v.file + '\', \'_blank\'); return false;" ';
                        //     h += '           style="color:#007bff; text-decoration:underline; font-size:17px;">Preview</a>';
                        // } else {
                        //     h += '        <span style="color:red; font-size:14px;">Belum ada upload bukti</span>';
                        // }

                        // h += '    </div>';


                        h += '    <div style="flex:0 0 25%; max-width:25%; padding:5px;">';
                        h += '        <small class="text-secondary">Status</small>';
                        h += '        <p class="text-uppercase"><b>' + s + '</b></p>';
                        h += '    </div>';

                        h += '</div>';


                        // h+='    <div class="text-right">';
                        // h+='        <small class="text-secondary">Jumlah Peserta</small>';
                        // h+='        <input type="text" class="form-control jumlah_peserta'+n+'" onchange="tambahPeserta('+v.id+','+v.participant_limit+','+ v.class_id+','+n+','+' {{ $reff ? $reff->code : '' }}'+')" '+r+'>';
                        // h+='    </div>';
                        h += '    <div class="text-right">';

                        // h+='        <small class="text-secondary">Kode Promo</small>';
                        // h+='        <input type="text" class="form-control kode_promo'+n+'" onchange="kodePromo(`'+v.title+'`,'+n+','+v.id+')" '+r+'>';
                        h += '    </div>';
                        h += '    </div>';
                        h += '    <div class="row">';
                        // h+='        <div class="col-lg-6">';
                        // h+='            <h5 class="m-0">'+v.title+'</h5>';
                        // h+='            <p class="m-0">'+new Date(v.created_at).toLocaleDateString('id-ID')+'</p>';
                        // h+='        </div>';
                        h += '        <div class="col-lg-12 text-right">';
                        // if (v.status_pembayaran == 'Menunggu Pembayaran' || v.status_pembayaran == 'Menunggu Konfirmasi') {
                        //     h += '            <div class="btn btn-info text-capitalize mr-2" style="cursor: auto" data-toggle="modal" data-target="#jumlahpesertaModal" onclick="bukti(' + v.participant_limit + ',`' + encodeURIComponent(v.title) + '`,' + v.class_id + ',' + v.id + ',' + `' {{ $reff ? $reff->code : '' }}'` + ',`' + v.kode_promo + '`,' + v.jumlah + ',`' + v.file + '`,' + n + ')">Peserta</div>';
                        // }

                        if (v.sudah_cetak == 1) {
                            h += '<div class="btn btn-warning text-capitalize mr-2" style="cursor: auto; border-radius: 6px !important; padding: 6px 16px !important; font-weight: 500;" onclick="langsungcetak(' + v.id + ',' + v.biaya_sertifikat + v.jumlah + ')">Invoice</div>';
                        } else {
                            h += '<div class="btn btn-warning text-capitalize mr-2" style="cursor: auto; border-radius: 6px !important; padding: 6px 16px !important; font-weight: 500;" data-toggle="modal" data-target="#invoiceModal" onclick="modalinvoice(' + v.id + ')">Invoice</div>';
                        }

                        if (v.status_pembayaran == 'Expired') {
                            h += '            <div class="btn btn-danger text-capitalize" style="cursor: auto">' + v.status_pembayaran + '</div>';
                        } else if (v.status_pembayaran == 'Menunggu Konfirmasi') {
                            h += '            <div class="btn btn-info text-capitalize" style="cursor: auto" data-toggle="modal" data-target="#bayarModal" onclick="bukti(' + v.participant_limit + ',`' + encodeURIComponent(v.title) + '`,' + v.class_id + ',' + v.id + ',' + `' {{ $reff ? $reff->code : '' }}'` + ',`' + v.kode_promo + '`,' + v.jumlah + ',`' + v.file + '`,' + n + ')">' + v.status_pembayaran + '</div>';
                        } else if (v.status_pembayaran == 'Dibatalkan') {
                            h += '            <div class="btn btn-danger text-capitalize" style="cursor: auto">' + v.status_pembayaran + '</div>';
                        } else if (v.status_pembayaran == 'Menunggu Pembayaran') {
                            // h += '            <button class="btn btn-primary text-capitalize" style="cursor: auto" data-toggle="modal" data-target="#bayarModal" onclick="bukti(' + v.participant_limit + ',`' + encodeURIComponent(v.title) + '`,' + v.class_id + ',' + v.id + ',' + `' {{ $reff ? $reff->code : '' }}'` + ',`' + v.kode_promo + '`,' + v.jumlah + ',`' + v.file + '`,' + n + ')">Upload Bukti</button>';
                            h += '            <a href='+ v.file +' class="btn btn-primary text-capitalize" style="cursor: auto">Bayar Sekarang</a>';
                        } else {
                            h += '            <div class="btn btn-success text-capitalize" style="cursor: auto">' + v.status_pembayaran + '</div>';
                        }
                        h += '        </div>';
                        h += '    </div>';
                        h += '</div>';
                        h += '</div>';
                    });
                    $(function() {
                        $('#btnimg').on('click', function() {
                            let img = $(this).attr('attimg')
                            Swal.fire({
                                imageUrl: img,
                                imageHeight: 250,
                                imageAlt: "A tall image"
                            });
                        });
                    });
                    $('#' + type).html(h);

                }
                Swal.close()
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Harap reload atau kontak admin',
                    position: 'topRight',
                });
                Swal.close()
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

    function cetakInvoiceSertifikat() {
        let jumlahpeserta = $('#jml_pesertas').val();
        if (jumlahpeserta < 1) {
            Swal.fire({
                title: "Pemberitahuan",
                text: "Jumlah peserta anda belum di isi",
                icon: "info"
            });
            return false;
        } else {
            // target="_blank"
            $('#sertifikat_invoice').val(1);
            $('#formInvoice').attr('action', '/classes/getinvoice/id');
            $('#formInvoice').attr('target', '_blank');
            $('#formInvoice').submit();
            $('#invoiceModal').modal('hide');
            $('#detailpeserta').html('');
        }

    }
</script>