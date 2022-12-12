@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            {{-- <div class="row">
                <div class="col-lg-6">
                    <form action="/admin/promo" method="post">
                        @csrf
                        <div class="input-group mb-4">
                            <input type="date" class="form-control" value="" placeholder="Date Start"
                                aria-label="Date Start" name="param_date_start">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon5">s/d</span>
                            </div>
                            <input type="date" class="form-control" value="" placeholder="Date End"
                                aria-label="Date End" name="param_date_end">
                        </div>
                        <div class="form-group">
                            <label>Status : </label>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="param_checked_lunas[]"
                                        value="">
                                    Belum Lunas
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="param_checked_lunas[]"
                                        value="">
                                    Lunas
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <button class="btn btn-primary btn-block" type="submit">Cari</button>
                            </div>
                            <div class="col-lg-4">
                                <a href="/admin/promo" class="btn btn-warning btn-block" type="button">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
            <form action="/admin/kupon" method="POST" enctype="multipart/form-data">
                @csrf
                <input name="id" id="id" value="{{old('id')}}" hidden>
                <div class="row">
                    <div class="form-group col">
                        <label for="">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" id="tgl_mulai" value="{{old('tgl_mulai')}}"
                            class="form-control">
                        @error('tgl_mulai')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai" value="{{old('tgl_selesai')}}"
                            class="form-control">
                        @error('tgl_selesai')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Kode Promo</label>
                        <input type="text" name="kode" id="kode" value="{{old('kode')}}" class="form-control">
                        @error('kode')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Nominal (%)</label>
                        <input type="number" step="any" name="nominal" id="nominal" value="{{old('nominal')}}"
                            class="form-control">
                        @error('nominal')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Kelas</label>
                        {{-- <input type="text" name="kelas" id="kelas" value="{{old('kelas')}}" class="form-control">
                        --}}
                        <select name="kelas[]" id="kelas" class="form-control" multiple>
                            @foreach ($kelas as $k)
                            <option value="{{$k->title}}">{{$k->title}}</option>
                            @endforeach
                        </select>
                        @error('kelas')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label>Image: <b class="text-danger">*</b></label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <img src="/Backend/assets/img/90x90.jpg" alt="Image Preview" id="prvImage" class="previewImage"
                            style="max-width: 100%;max-height:97px;">
                        @error('image')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <span class="btn btn-danger" id="reset" onclick="reset()">Reset</span>
            </form>
            <div class="table-responsive">
                <table id="tblpromo" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Kelas</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promo as $key=> $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$p->kode}}</td>
                            <td>
                                @if ($p->tgl_mulai == $p->tgl_selesai)
                                {{\Carbon\Carbon::parse($p->tgl_mulai)->format('d-m-Y')}}
                                @else
                                {{\Carbon\Carbon::parse($p->tgl_mulai)->format('d-m-Y')}} -
                                {{\Carbon\Carbon::parse($p->tgl_selesai)->format('d-m-Y')}}</td>
                            @endif
                            <td>{{$p->nominal}} %</td>
                            <td>
                                @foreach (json_decode($p->class_title) as $cl)
                                <div class="badge badge-info">{{$cl}}</div>
                                @endforeach
                            </td>
                            <td> <img src="/image/promo/image/{{json_decode($p->image)->url}}" alt="" width="200px">
                            </td>
                            <td>
                                <button class="btn btn-warning" id="edit" title="Edit"
                                    onclick="editPromo('{{$p->id}}','{{$p->tgl_mulai}}','{{$p->tgl_selesai}}','{{$p->kode}}','{{$p->nominal}}','{{$p->class_title}}','{{$p->image}}')"><i
                                        class='bx bx-edit'></i></button>
                                <button class="btn btn-danger" onclick="deletePromo({{$p->id}})" title="Delete"> <i
                                        class='bx bx-trash'></i></button>
                                <form action="#" method="post" id="formdelpromo">@csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="#" method="post" id="formpromo">@csrf <input type="text" name="id" id="id" hidden>
                    <input type="text" name="certificate" id="certificate" hidden>
                    <input type="text" name="status" id="status" hidden>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    createDataTable('#tblpromo');
    $('#image').change(function (e) { 
		getImgData(this,'#prvImage');
	});
    $('#kelas').select2({
			tags: true,
		});
        function deletePromo(id) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formdelpromo').attr('action','/admin/kupon/'+id);
				$('#formdelpromo').submit();
			}else{
				$('#formdelpromo').attr('action','#');
			}
		})
	}
    function editPromo(id,tglm,tgls,kode,nominal,ct,img) {
        $('#prvImage').attr('src','/Backend/assets/img/90x90.jpg');
        $('#id').val(id);
        $('#tgl_mulai').val(tglm);
        $('#tgl_selesai').val(tgls);
        $('#kode').val(kode);
        $('#nominal').val(nominal);
        // $('#kelas').val(JSON.parse(ct));
        $("#kelas").val(JSON.parse(ct)).trigger('change');
        $('#prvImage').attr('src','/image/promo/image/'+JSON.parse(img).url);
        console.log(JSON.parse(img).url);
    }
    function reset() {
        $('#id').val(null);
        $('#tgl_mulai').val(null);
        $('#tgl_selesai').val(null);
        $('#kode').val(null);
        $('#nominal').val(null);
        $("#kelas").val(null).trigger('change');
        
    }
</script>
@endsection