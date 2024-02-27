<div class="container">
    <div class="row">
        <div class="col-lg-4 mb-2">
            <div class="card br-1" style="background-color: #005CFF">
                <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                    <label for="" class="text-white m-0">Saldo Kredit</label>
                    <p class="text-white" style="margin-bottom: 12px">Rp. 0</p>
                    <label for="" class="text-white m-0">Saldo Affiliate</label>
                    <p class="m-0 text-white" style="">Rp. {{number_format($cashback['amount'])}}</p>
                    {{-- <h2 class="text-white text-center">Rp {{number_format(isset($saldoProses)?$saldoProses:0)}}
                    </h2> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-2">
            <div class="card br-1" style="background-color: #005CFF">
                <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                    <label for="" class="text-white">Saldo</label>
                    <h2 class="text-white text-center">Rp {{number_format(isset($saldo)?$saldo:0)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-2">
            <div class="card br-1" style="background-color: #005CFF">
                <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                    <label for="" class="text-white">Total Penarikan</label>
                    <h2 class="text-white text-center">Rp {{number_format(isset($saldoPenarikan)?$saldoPenarikan:0)}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
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
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referralku as $k => $r)
                                    <tr>
                                        <td>{{$k +1}}</td>
                                        <td>{{$r->name}}</td>
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