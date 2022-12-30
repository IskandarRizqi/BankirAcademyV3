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
                <h4>Proses Saldo</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4>Saldo</h4>
            </div>
        </div>
        <h4 class="text-center">Withdraw</h4>
        <form action="">
            <div class="row">
                <div class="form-group col">
                    <label for="">Nama Bank (Ulang)</label>
                    <input type="text" name="nama_bank" id="nama_bank" class="form-control" required>
                </div>
                <div class="form-group col">
                    <label for="">No Rekening (Ulang)</label>
                    <input type="text" name="no_rekening" id="no_rekening" class="form-control" required>
                </div>
                <div class="form-group col">
                    <label for="">Nominal Penarikan</label>
                    <input type="text" name="nominal_penarikan" id="nominal_penarikan" class="form-control" required>
                </div>
            </div>
            <button class="btn btn-success btn-sm">Proses</button>
        </form>
        <table id="withdraw1" class="table table-hover mb-2" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Nominal</th>
                    <th>Available</th>
                    <th class="dt-no-sorting text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>name</td>
                    <td>rupiah</td>
                    <td>1. Permohonan, 2. Proses, 3. Selesai</td>
                    <td>Aksi</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4>Total Penarikan</h4>
            </div>
        </div>
    </div>
</div>
<table id="affiliate" class="table table-hover mb-2" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Available</th>
            <th class="dt-no-sorting text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($referralku as $k => $r)
        <tr>
            <td>{{$k +1}}</td>
            <td>{{$r->name}}</td>
            <td>{{$r->available?'Terpakai':'Belum Terpakai'}}</td>
            <td>Aksi</td>
        </tr>
        @endforeach
        {{-- @foreach ($data as $key => $l)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$l->nominal}}</td>
            <td>
                <button class="btn btn-warning" id="edit" title="Edit"><i class='bx bx-edit'></i></button>
                <button class="btn btn-danger" onclick="deleteLaman({{$l->id}})" title="Delete"> <i
                        class='bx bx-trash'></i></button>
                <form action="#" method="post" id="formdelclasses">@csrf @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach --}}
    </tbody>
</table>
<img src="{{asset('ccara_affiliate_Cara_pakai_promo_copy.jpg')}}" alt="">