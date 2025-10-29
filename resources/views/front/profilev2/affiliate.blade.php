<div class="container">
    <div class="row">
        <div class="col-lg-4 mb-2">
            <div class="card " style="background-color: #007bff; border-radius:10px;">
                <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                    <label for="" class="text-white m-0"> Saldo Kredit</label>
                    <p class="text-white" style="margin-bottom: 12px">Rp. 0</p>
                    <label for="" class="text-white m-0">Saldo Affiliate</label>
                    <p class="m-0 text-white" style="">Rp. {{number_format($cashback['amount'])}}</p>
                    {{-- <h2 class="text-white text-center">Rp {{number_format(isset($saldoProses)?$saldoProses:0)}}
                    </h2> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-2">
            <div class="card " style="background-color: #17a2b8;  border-radius:10px;">
                <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                    <label for="" class="text-white">Saldo</label>
                    <h2 class="text-white text-center">Rp {{number_format(isset($saldo)?$saldo:0)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-2">
            <div class="card " style="background-color: #ffc107;  border-radius:10px;">
                <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                    <label for="" class="text-white">Total Penarikan</label>
                    <h2 class="text-white text-center">Rp {{number_format(isset($saldoPenarikan)?$saldoPenarikan:0)}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action text-capitalize br-10 active"
                    id="list-kode-refferal-list" data-toggle="list" href="#list-kode-refferal" role="tab"
                    aria-controls="kode-refferal">Kode Refferal</a>
                <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-withdraw-list"
                    data-toggle="list" href="#list-withdraw" role="tab" aria-controls="withdraw">Withdraw & Top Up</a>
                <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-ppob-list"
                    data-toggle="list" href="#list-ppob" role="tab" aria-controls="ppob">PPOB</a>
                <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-sdank-list"
                    data-toggle="list" href="#list-sdank" role="tab" aria-controls="sdank">Syarat & Ketentuan</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-kode-refferal" role="tabpanel"
                    aria-labelledby="list-kode-refferal-list">
                    {{-- <form action="/set-master-refferal" method="POST">
                        @csrf
                    </form> --}}
                    <input type="text" name="id" id="id" class="form-control" value="{{$reff?$reff->id:''}}" hidden>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="" style="font-size: 10px">Kode Refferal <span class=""
                                        style="color: red">*</span></label>
                                <input type="text" name="kode" id="kode" class="form-control" placeholder="1234567890"
                                    value="{{$reff?$reff->code:''}}">
                                @error('kode')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="" style="font-size: 10px">SPESIAL KARAKTER AKAN DI RUBAH KE (-) ATAU
                                    (_) <span class="" style="color: red">*</span></label>
                                <input type="text" name="url" id="url" class="form-control" placeholder="sitejo"
                                    value="{{$reff?$reff->url:''}}">
                                @error('url')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-primary mt-4" onclick="setreferral()">Simpan</button>
                        </div>
                    </div>
                    <div class="">
                        <label for="">Data Pengguna Refferal</label>
                        <div class="table-responsive">
                            <table id="datatable1" class="table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referralku as $k => $r)
                                    <tr>
                                        <td>{{$k +1}}</td>
                                        <td>{{$r->name}}</td>
                                        <td>{{$r->users?$r->users->email:'Tidak ada'}}</td>
                                        <td>{{$r->available?'Terpakai':'Belum Terpakai'}}</td>
                                        {{-- <td>Aksi</td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="list-withdraw" role="tabpanel" aria-labelledby="list-withdraw-list">
                    <div class="">
                        <form action="/withdrawMember" method="POST">
                            @csrf
                            <label for="">Withdraw Saldo</label>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="">Nama Bank</label>
                                    <input type="text" name="nama_bank" id="nama_bank" class="form-control">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">No Rekening</label>
                                    <input type="text" name="no_rekening" id="no_rekening" class="form-control">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Nominal</label>
                                    <input type="number" name="nominal_penarikan" id="nominal_penarikan"
                                        class="form-control">
                                    <div class="product-pricing" id="nominalval"></div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm">Proses</button>
                                </div>
                            </div>
                        </form>
                        <label for="">History Penarikan</label>
                        <div class="table-responsive">
                            <table id="datatable2" class="table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No Rekening</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdraw as $key => $w)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$w->nama_bank}}</td>
                                        <td>{{$w->no_rekening}}</td>
                                        <td>
                                            @switch($w->status)
                                            @case(0)
                                            Permohonan
                                            @break
                                            @case(1)
                                            Proses
                                            @break
                                            @case(2)
                                            Gagal
                                            @break
                                            @case(3)
                                            Selesai
                                            @break
                                            Tidak Ditemukan
                                            @endswitch
                                        </td>
                                        <td>0</td>
                                        {{-- <td>Aksi</td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="list-ppob" role="tabpanel" aria-labelledby="list-ppob-list">
                    <img src="/upcoming_absen_post_test_Cara pakai_promo_copy_2.jpg" alt="">
                    <div class="tabs tabs-alt tabs-justify clearfix ui-tabs ui-corner-all ui-widget ui-widget-content"
                        id="tab-10">
                        <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
                            role="tablist">
                            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                                aria-controls="tabs-1" aria-labelledby="ui-id-25" aria-selected="false"
                                aria-expanded="false"><a href="#tabs-1" role="presentation" tabindex="-1"
                                    class="ui-tabs-anchor" id="ui-id-25">Pascabayar</a></li>
                            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                                aria-controls="tabs-2" aria-labelledby="ui-id-26" aria-selected="false"
                                aria-expanded="false"><a href="#tabs-2" role="presentation" tabindex="-1"
                                    class="ui-tabs-anchor" id="ui-id-26">Prabayar</a></li>
                        </ul>
                        <div class="tab-container">
                            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                id="tabs-1" aria-labelledby="ui-id-25" role="tabpanel" aria-hidden="true"
                                style="display: none;">
                                <div id="intro-onepages-container" class="row col-mb-50 mb-0">
                                    <div class="grid-intro-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                        <div class="portfolio-item">
                                            <a href="#" target="_blank">
                                                <div class="card shadow-lg" style="border-radius: 20px;">
                                                    <div class="card-body">
                                                        <img src="/GambarV2/pascabayar/ico_pln.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="portfolio-desc center pb-0">
                                                    <h3>PLN</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="grid-intro-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                        <div class="portfolio-item">
                                            <a href="#" target="_blank">
                                                <div class="card shadow-lg" style="border-radius: 20px;">
                                                    <div class="card-body">
                                                        <img src="/GambarV2/pascabayar/ico_telkom.png" alt="Designer">
                                                    </div>
                                                </div>
                                                <div class="portfolio-desc center pb-0">
                                                    <h3>Telkom</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="grid-intro-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                        <div class="portfolio-item">
                                            <a href="#" target="_blank">
                                                <div class="card shadow-lg" style="border-radius: 20px;">
                                                    <div class="card-body">
                                                        <img src="/GambarV2/pascabayar/ico_pdam.png" alt="Parallax">
                                                    </div>
                                                </div>
                                                <div class="portfolio-desc center pb-0">
                                                    <h3>PDAM</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="grid-intro-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                        <div class="portfolio-item">
                                            <a href="#" target="_blank">
                                                <div class="card shadow-lg" style="border-radius: 20px;">
                                                    <div class="card-body">
                                                        <img src="/GambarV2/pascabayar/ico_pbb.png" alt="Tourism">
                                                    </div>
                                                </div>
                                                <div class="portfolio-desc center pb-0">
                                                    <h3>PBB</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="grid-intro-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                        <div class="portfolio-item">
                                            <a href="#" target="_blank">
                                                <div class="card shadow-lg" style="border-radius: 20px;">
                                                    <div class="card-body">
                                                        <img src="/GambarV2/pascabayar/ico_bpjs.png" alt="Developer">
                                                    </div>
                                                </div>
                                                <div class="portfolio-desc center pb-0">
                                                    <h3>BPJS</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                id="tabs-2" aria-labelledby="ui-id-26" role="tabpanel" aria-hidden="true"
                                style="display: none;">
                                <div id="intro-onepages-container" class="row col-mb-50 mb-0">
                                    <div class="grid-intro-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                        <div class="portfolio-item">
                                            <a href="#" target="_blank">
                                                <div class="card shadow-lg" style="border-radius: 20px;">
                                                    <div class="card-body">
                                                        <img src="/GambarV2/pascabayar/ico_pln.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="portfolio-desc center pb-0">
                                                    <h3>PLN</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="grid-intro-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                        <div class="portfolio-item">
                                            <a href="#" target="_blank">
                                                <div class="card shadow-lg" style="border-radius: 20px;">
                                                    <div class="card-body">
                                                        <img src="/GambarV2/prabayar/ico_pulsa.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="portfolio-desc center pb-0">
                                                    <h3>Pulsa</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="list-sdank" role="tabpanel" aria-labelledby="list-sdank-list">
                    <img src="/upcoming_absen_post_test_Cara pakai_promo_copy_2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#nominal_penarikan').on('input',function () {
        $('#nominalval').html(toRupiah($('#nominal_penarikan').val()))
    })
    function toRupiah(params) {
		return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(params);
	}
    function setreferral(){
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
                url: '/set-master-refferal',
                method: 'POST',
                data: {
                    kode:$('#kode').val(),
                    url:$('#url').val(),
                },
                success:function(response)
                {
                    let h = '';
                    Swal.close()
                    if (response.success == 1) {
                        Swal.fire({
                            title:'Refferal Tersimpan',
                            icon:'success',
                        });
                    }
                    Swal.fire({
                        title:response.message,
                        icon:'info',
                    });
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
</script>