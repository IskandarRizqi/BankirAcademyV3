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
            <form action="bayar" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="class_id" name="class_id" hidden>
                    <input type="text" id="payment_id" name="payment_id" hidden>
                    <input type="text" id="ref" name="ref" hidden>
                    <div class="form-group" hidden>
                        <label for="">Jumlah Peserta</label>
                        <input class="form-control" type="number" id="jml_peserta" name="jml_peserta">
                    </div>
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
                    <button type="submit" class="btn btn-primary">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
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
                        let r = '';
                        if (v.status_pembayaran == 'Expired') {
                            r = 'readonly';
                        }
                        if (v.file) {
                            r = 'readonly';
                        }
                        // console.log(encodeURIComponent(v.title));
                        let title = encodeURIComponent(v.title);
                        if (!s) {
                            s = v.status==1?'Lunas':'Batal';
                        }
                        h+='<div class="card br-10 mb-4" style="background-color: #f7f7f7">';
                        h+='<div class="card-body">';
                        h+='<div class="d-flex justify-content-between">';
                        h+='    <div class="">';
                        h+='        <h5 class="m-0 text-capitalize">'+type+'</h5>';
                        h+='        <small class="text-secondary">No. Invoice</small>';
                        h+='        <p class="text-uppercase">';
                        h+='            <b>'+v.no_invoice+'</b>';
                        h+='        </p>';
                        h+='    </div>';
                        h+='    <div class="text-right">';
                        h+='        <small class="text-secondary">Jumlah Peserta</small>';
                        h+='        <input type="text" class="form-control jumlah_peserta'+n+'" onchange="tambahPeserta('+v.id+','+v.participant_limit+','+ v.class_id+','+n+','+' {{ $reff ? $reff->code : '' }}'+')" '+r+'>';
                        h+='    </div>';
                        h+='    <div class="text-right">';
                        h+='        <small class="text-secondary">Kode Promo</small>';
                        h+='        <input type="text" class="form-control kode_promo'+n+'" onchange="kodePromo(`'+v.title+'`,'+n+','+v.id+')" '+r+'>';
                        h+='    </div>';
                        h+='</div>';
                        h+='    <div class="row">';
                        h+='        <div class="col-lg-9">';
                        h+='            <h5 class="m-0">'+v.title+'</h5>';
                        h+='            <p class="m-0">'+new Date(v.created_at).toLocaleDateString('id-ID')+'</p>';
                        h+='        </div>';
                        h+='        <div class="col-lg-3 text-center">';
                            if (v.status_pembayaran == 'Expired') {
                                h+='            <div class="btn btn-danger text-capitalize" style="cursor: auto">'+v.status_pembayaran+'</div>';
                            }else if(v.status_pembayaran == 'Menunggu Konfirmasi'){
                                h+='            <div class="btn btn-info text-capitalize" style="cursor: auto">'+v.status_pembayaran+'</div>';
                            }else if(v.status_pembayaran == 'Dibatalkan'){
                                h+='            <div class="btn btn-danger text-capitalize" style="cursor: auto">'+v.status_pembayaran+'</div>';
                            }else if(v.status_pembayaran == 'Menunggu Pembayaran'){
                                h+='            <button class="btn btn-primary text-capitalize" style="cursor: auto" data-toggle="modal" data-target="#bayarModal" onclick="bukti('+v.class_id+','+v.id+','+' {{ $reff ? $reff->code : '' }}'+')">'+v.status_pembayaran+'</button>';
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
    function bukti(class_id, payment, ref) {
        $('#class_id').val(class_id);
        $('#payment_id').val(payment);
        $('#ref').val(ref);        
    }
    function kodePromo(id,n,idpaymnet) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/kode-promo",
            method: 'post',
            data: {
                id: id,
                kode: $('.kode_promo'+n).val(),
                idpayment: idpaymnet
            },
            success: function(result) {
                if (result.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                    })
                    location.reload()
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf',
                        text: result.message,
                    })
                }
                // setTimeout(() => {
                //     location.reload();
                // }, 1000);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                // var errors = jqXhr.responseJSON;
                // var errorsHtml = '';
                // console.log(errors['errors']);
            }
        })
    }
    function tambahPeserta(params, limit, classid, n, ref) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "bayar",
            method: 'post',
            data: {
                payment_id: params,
                limit: limit,
                classid: classid,
                jumlah: val,
                ref: ref,
            },
            success: function(result) {
                if (result.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message,
                    })
                }
                // setTimeout(() => {
                //     location.reload();
                // }, 1000);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                // var errors = jqXhr.responseJSON;
                // var errorsHtml = '';
                // console.log(errors['errors']);
            }
        })
    }
</script>