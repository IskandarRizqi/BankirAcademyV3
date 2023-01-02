<form action="/set-master-refferal" method="POST">
    @csrf
    <input type="text" name="id" id="id" class="form-control" value="{{$reff?$reff->id:''}}" hidden>
    <div class="row">
        <div class="col">
            <label for="form-control">Kode Referral</label>
            <input type="text" name="kode" id="kode" class="form-control" value="{{$reff?$reff->code:''}}">
            @error('kode')
            <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="col">
            <label for="form-control">URL <small>spesial karakter akan di rubah ke (-) atau (_)</small></label>
            <input type="text" name="url" id="url" class="form-control" value="{{$reff?$reff->url:''}}">
            @error('url')
            <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
    </div>
    <button class="button button-primary">Set</button>
</form>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                {{-- <a href="#prosesSaldo">
                </a> --}}
                <h4 style="margin: 0px">Proses Saldo</h4>
                <div class="product-price text-center">Rp. {{number_format(isset($saldoProses)?$saldoProses:0)}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 style="margin: 0px">Saldo</h4>
                <div class="product-price text-center">Rp. {{number_format(isset($saldo)?$saldo:0)}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 style="margin: 0px">Total Penarikan</h4>
                <div class="product-price text-center">Rp. {{number_format(isset($saldoPenarikan)?$saldoPenarikan:0)}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="affiliate" class="table table-hover mb-2" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Available</th>
                                {{-- <th class="dt-no-sorting text-center">Aksi</th> --}}
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
                            {{-- @foreach ($data as $key => $l)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$l->nominal}}</td>
                                <td>
                                    <button class="btn btn-warning" id="edit" title="Edit"><i
                                            class='bx bx-edit'></i></button>
                                    <button class="btn btn-danger" onclick="deleteLaman({{$l->id}})" title="Delete"> <i
                                            class='bx bx-trash'></i></button>
                                    <form action="#" method="post" id="formdelclasses">@csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="toggle toggle-border" id="prosesSaldo">
            <div class="toggle-header">
                <div class="toggle-icon">
                    <i class="toggle-closed icon-ok-circle"></i>
                    <i class="toggle-open icon-remove-circle"></i>
                </div>
                <div class="toggle-title">
                    Withdraw
                </div>
            </div>
            <div class="toggle-content" style="display: none;">
                {{-- <h4 class="text-center">Withdraw</h4> --}}
                <form action="/withdrawMember" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col">
                            <label for="">Nama Bank (Ulang)</label>
                            <input type="text" name="nama_bank" id="nama_bank" class="form-control"
                                value="@isset($user->rekening){{$user->rekening->nama_bank}}@endisset" required>
                        </div>
                        <div class="form-group col">
                            <label for="">No Rekening (Ulang)</label>
                            <input type="number" name="no_rekening" id="no_rekening" class="form-control"
                                value="@isset($user->rekening){{$user->rekening->no_rekening}}@endisset" required>
                        </div>
                        <div class="form-group col">
                            <label for="">Nominal Penarikan</label>
                            <input type="text" name="nominal_penarikan" id="nominal_penarikan" class="form-control"
                                required>
                            <div class="product-pricing" id="nominalval"></div>
                        </div>
                    </div>
                    <button class="btn btn-success btn-sm">Proses</button>
                </form>
                <div class="table-responsive">
                    <table id="withdraw1" class="table table-hover mb-2" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bank</th>
                                <th>No Rekening</th>
                                <th>Status</th>
                                {{-- <th class="dt-no-sorting text-center">Aksi</th> --}}
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
<script>
    $('#nominal_penarikan').on('input',function () {
        $('#nominalval').html(toRupiah($('#nominal_penarikan').val()))
    })
    function toRupiah(params) {
		return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(params);
	}
</script>
<img src="{{asset('ccara_affiliate_Cara_pakai_promo_copy.jpg')}}" alt="">