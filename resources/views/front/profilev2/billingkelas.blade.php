<div class="row">
    <div class="col-lg-3">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action text-capitalize br-10 active" id="list-semua-list"
                data-toggle="list" href="#list-semua" role="tab" aria-controls="semua"
                onclick="loadbillingkelas('semua-billing')">semua</a>
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-pembayaran-list"
                data-toggle="list" href="#list-pembayaran" role="tab" aria-controls="pembayaran"
                onclick="loadbillingkelas('pembayaran-billing')">menunggu pembayaran</a>
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-konfirmasi-list"
                data-toggle="list" href="#list-konfirmasi" role="tab" aria-controls="konfirmasi"
                onclick="loadbillingkelas('konfirmasi-billing')">menunggu konfirmasi</a>
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
                <input type="text" id="class_id" name="class_id" hidden>
                <input type="text" id="class_title" name="class_title" hidden>
                <input type="text" id="class_limit" name="class_limit" hidden>
                <input type="text" id="payment_id" name="payment_id" hidden>
                <input type="text" id="ref" name="ref" hidden>
                <div class="form-group">
                    <label for="">Kode Promo</label>
                    <input class="form-control" type="text" id="kode_promo" name="kode_promo">
                </div>
                <div class="form-group">
                    <label for="">Jumlah Peserta</label>
                    <input class="form-control" type="number" id="jml_peserta" name="jml_peserta">
                </div>
                {{-- <div class="col-lg-12 bottommargin">
                    <label>Upload Bukti Pembayaran:</label><br>
                    <input id="input-3" name="input2[]" type="file" class="file" data-show-upload="false"
                        data-show-caption="true" data-show-preview="true" accept="image/*">
                    @error('input2')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div> --}}
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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="" method="GET" enctype="multipart/form-data" id="formInvoice" target="_blank">
                @csrf
                <div class="modal-header">
                    <h3 style="margin: 0px">Invoice</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <input type="text" id="payment_invoice" name="payment_invoice" hidden>
                    <input type="text" id="sertifikat_invoice" name="sertifikat_invoice" hidden>
                    <p style="margin: 0px; font-size: 21px">Apakah anda
                        ingin mencetak dengan sertifikat?</p>
                    <span class="badge bg-danger text-white">
                        <div class="spinner-grow spinner-grow-sm">
                        </div>
                        <small style="font-size: 12px">Biaya cetak dan
                            pengiriman Rp. 100.000/kelas ditambahkan ke
                            invoice anda. </small>
                    </span>
                    <div class="d-flex justify-content-center mt-4">
                        <span class="btn btn-warning" target="_blank" title="Invoice"
                            onclick="cetakInvoice()">Tidak</span>
                        <span class="btn btn-primary ml-2" target="_blank" title="Invoice"
                            onclick="cetakInvoiceSertifikat()">Ya</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    let class_image = 0;
    function loadbillingkelas(type) {
        let t = 100;
        let s = false;
        if (type=='pembayaran-billing') {
            t = 3;
            s = 'menunggu pembayaran';
        }
        if (type=='konfirmasi-billing') {
            t = 2;
            s = 'menunggu konfirmasi';
        }
        if (type=='lunas-billing') {
            t = 1;
            s = 'lunas';
        }
        if (type=='batal-billing') {
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
            background:'#0069d900',
            didOpen:()=>{
                Swal.showLoading();
            }
        })
        $.ajax({
            url: '/getbillingkelas/'+t,
            method: 'GET',
            success:function(response)
            {
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
                            s = v.status==1?'Lunas':'Batal';
                        }
                        h+='<div class="card br-10 mb-4" style="background-color: #f7f7f7">';
                        h+='<div class="card-body">';
                        h+='<div class="d-flex justify-content-between">';
                        h+='    <div class="mr-1">';
                        h+='        <h5 class="m-0 text-capitalize">'+type+'</h5>';
                        h+='        <small class="text-secondary">No. Invoice</small>';
                        h+='        <p class="text-uppercase">';
                        h+='            <b>'+v.no_invoice+'</b>';
                        h+='        </p>';
                        h+='    </div>';
                        h+='    <div class="text-right">';
                        // h+='        <small class="text-secondary">Jumlah Peserta</small>';
                        // h+='        <input type="text" class="form-control jumlah_peserta'+n+'" onchange="tambahPeserta('+v.id+','+v.participant_limit+','+ v.class_id+','+n+','+' {{ $reff ? $reff->code : '' }}'+')" '+r+'>';
                        h+='    </div>';
                        h+='    <div class="text-right">';
                            if (v.file) {
                                h+='        <a class="class_image'+n+'" href="/getBerkas?rf='+v.file+'" target="_blank"';
                                h+='            ><img class="class_imagenya'+n+'" src="/getBerkas?rf='+v.file+'"';
                                h+='            width="75%">';
                                h+='        </a>';
                            }
                        // h+='        <small class="text-secondary">Kode Promo</small>';
                        // h+='        <input type="text" class="form-control kode_promo'+n+'" onchange="kodePromo(`'+v.title+'`,'+n+','+v.id+')" '+r+'>';
                        h+='    </div>';
                        h+='    </div>';
                        h+='    <div class="row">';
                        h+='        <div class="col-lg-6">';
                        h+='            <h5 class="m-0">'+v.title+'</h5>';
                        h+='            <p class="m-0">'+new Date(v.created_at).toLocaleDateString('id-ID')+'</p>';
                        h+='        </div>';
                        h+='        <div class="col-lg-6 text-right">';
                            if (v.status_pembayaran == 'Menunggu Pembayaran' || v.status_pembayaran == 'Menunggu Konfirmasi') {
                        h+='            <div class="btn btn-info text-capitalize mr-2" style="cursor: auto" data-toggle="modal" data-target="#jumlahpesertaModal" onclick="bukti('+v.participant_limit+',`'+encodeURIComponent(v.title)+'`,'+v.class_id+','+v.id+','+' {{ $reff ? $reff->code : '' }}'+',`'+v.kode_promo+'`,'+v.jumlah+',`'+v.file+'`,'+n+')">Peserta</div>';
                            }
                        h+='            <div class="btn btn-warning text-capitalize mr-2" style="cursor: auto" data-toggle="modal" data-target="#invoiceModal" onclick="modalinvoice('+v.id+')">Invoice</div>';
                            if (v.status_pembayaran == 'Expired') {
                                h+='            <div class="btn btn-danger text-capitalize" style="cursor: auto">'+v.status_pembayaran+'</div>';
                            }else if(v.status_pembayaran == 'Menunggu Konfirmasi'){
                                h+='            <div class="btn btn-info text-capitalize" style="cursor: auto" data-toggle="modal" data-target="#bayarModal" onclick="bukti('+v.participant_limit+',`'+encodeURIComponent(v.title)+'`,'+v.class_id+','+v.id+','+' {{ $reff ? $reff->code : '' }}'+',`'+v.kode_promo+'`,'+v.jumlah+',`'+v.file+'`,'+n+')">'+v.status_pembayaran+'</div>';
                            }else if(v.status_pembayaran == 'Dibatalkan'){
                                h+='            <div class="btn btn-danger text-capitalize" style="cursor: auto">'+v.status_pembayaran+'</div>';
                            }else if(v.status_pembayaran == 'Menunggu Pembayaran'){
                                h+='            <button class="btn btn-primary text-capitalize" style="cursor: auto" data-toggle="modal" data-target="#bayarModal" onclick="bukti('+v.participant_limit+',`'+encodeURIComponent(v.title)+'`,'+v.class_id+','+v.id+','+' {{ $reff ? $reff->code : '' }}'+',`'+v.kode_promo+'`,'+v.jumlah+',`'+v.file+'`,'+n+')">Upload Bukti</button>';
                            }else{
                                h+='            <div class="btn btn-success text-capitalize" style="cursor: auto">'+v.status_pembayaran+'</div>';
                            }
                        h+='        </div>';
                        h+='    </div>';
                        h+='</div>';
                        h+='</div>';
                    });
                    $('#'+type).html(h);
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
    function bukti(limit,title,class_id, payment, ref, kodepromo,jml_peserta,file,index) {
        $('#class_id').val(class_id);
        $('#payment_id').val(payment);
        $('#class_title').val(title);
        $('#class_limit').val(limit);
        $('#ref').val(ref);

        $('#kode_promo').val(kodepromo);
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
            background:'#0069d900',
            didOpen:()=>{
                Swal.showLoading();
            }
        })
        var fd = new FormData();
        var gambar = $('#input-3')[0].files[0];
        fd.append('gambar',gambar);
        fd.append('kode',$('#kode_promo').val());
        fd.append('jumlah',$('#jml_peserta').val());
        fd.append('class_id',$('#class_id').val());
        fd.append('class_title',$('#class_title').val());
        fd.append('limit',$('#class_limit').val());
        fd.append('payment_id',$('#payment_id').val());
        $.ajax({
            processData: false,
            contentType: false,
            url: '/bayarv2',
            method: 'POST',
            data: fd,
            enctype: 'multipart/form-data',
            success:function(response)
            {
                if (response.status == 1) {
                    $('.class_image'+class_image).attr('href','/getBerkas?rf='+response.data.file)
                    $('.class_imagenya'+class_image).attr('src','/getBerkas?rf='+response.data.file)
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Input Berhasil',
                        position: 'topRight',
                    });
                    $('#bayarModal').modal('hide')
                }else{
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
    function modalinvoice(id) {
        $('#payment_invoice').val(id);
    }
    function cetakInvoice() {
        $('#sertifikat_invoice').val(0);
        $('#formInvoice').attr('action','/classes/getinvoice/id');
        $('#formInvoice').submit();
    }
    function cetakInvoiceSertifikat() {
        $('#sertifikat_invoice').val(1);
        $('#formInvoice').attr('action','/classes/getinvoice/id');
        $('#formInvoice').submit();
    }
</script>