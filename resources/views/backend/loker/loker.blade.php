@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <!-- Button trigger modal -->
            {{-- <a href="/admin/pages/edit/null">
                <button type="button" class="btn btn-primary btn-sm">
                    Tambah
                </button>
            </a> --}}
        </div>
        <div class="card-body">
            <form action="/loker" method="POST" enctype="multipart/form-data">
                <fieldset class="border p-2">
            @csrf
            <input type="text" name="loker_id" id="loker_id" hidden>
                <legend class="w-auto">Form Loker</legend>
                <div class="row border-2">
                    <div class="col-lg-3">
                    <div class="form-group">
                        <label for="filClassesImage">Image</label>
                        <small class="inputerrormessage text-danger" input-target="filClassesImage"
                            style="display: none;"></small>
                        <input type="file" name="filClassesImage" id="filClassesImage"
                            class="form-control" accept="image/*" maxfilesize="1048576">
                        <img src="#" alt="Image Preview" id="prvClassesImage" class="previewImage"
                            style="max-width: 100%;max-height:97px;">
                            @error('filClassesImage')
                                <small class="text-danger">Harus Diisi</small>
                            @enderror
                    </div>
                    </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Nama Perusahaan</label>
                        <input type="text" name="loker_nama" id="loker_nama" class="form-control" value="{{old('loker_nama')}}">
                        @error('loker_nama')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="loker_email" id="loker_email" class="form-control" value="{{old('loker_email')}}">
                        @error('loker_email')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Minimal Gaji</label>
                        <input type="text" name="loker_gaji_min" id="loker_gaji_min" class="form-control" value="{{old('loker_gaji_min')}}">
                        <small id="labelgajimin"></small>
                        @error('loker_gaji_min')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="loker_title" id="loker_title" class="form-control" value="{{old('loker_title')}}">
                        @error('loker_title')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" name="loker_alamat" id="loker_alamat" class="form-control" value="{{old('loker_alamat')}}">
                        @error('loker_alamat')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-3" hidden>
                    <div class="form-group">
                        <label for="">Maksimal Gaji</label>
                        <input type="number" name="loker_gaji_max" id="loker_gaji_max" class="form-control" value="{{old('loker_gaji_max')}}">
                        <small id="labelgajimax"></small>
                        @error('loker_gaji_max')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="loker_deskripsi" id="loker_deskripsi" cols="30" rows="5" class="form-control">{{old('loker_deskripsi')}}</textarea>
                        @error('loker_deskripsi')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Jobdesk</label>
                        <textarea name="loker_jobdesk" id="loker_jobdesk" cols="30" rows="5" class="form-control">{{old('loker_jobdesk')}}</textarea>
                        @error('loker_jobdesk')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 d-flex">
                    <div class="form-group">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="loker_tanggal_awal" id="loker_tanggal_awal" class="form-control" value="{{old('loker_tanggal_awal')}}">
                        @error('loker_tanggal_awal')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group ml-2">
                        <label for="">Tanggal Akhir</label>
                        <input type="date" name="loker_tanggal_akhir" id="loker_tanggal_akhir" class="form-control" value="{{old('loker_tanggal_akhir')}}">
                        @error('loker_tanggal_akhir')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group ml-2">
                        <label for="">Skill</label><br>
                        <select name="loker_skill[]" id="loker_skill" class="form-control" multiple>
                            <option value="">Pilih Skill</option>
                            @if($lokerskill)
                            @foreach(json_decode($lokerskill[0]) as $key => $va)
                            <option value="{{$va}}"
                                @if(old('loker_skill'))
                                    @foreach(old('loker_skill') as $key => $value)
                                        {{$value==$va?'selected':''}}
                                    @endforeach
                                @endif
                            >{{$va}}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('loker_skill')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group ml-2">
                        <label for="">type</label><br>
                        <select name="loker_type[]" id="loker_type" class="form-control" multiple>
                            <option value="">Pilih Type</option>
                            @if($lokertype)
                            @foreach(json_decode($lokertype[0]) as $key => $val)
                            <option value="{{$val}}"
                            @if(old('loker_type'))
                            @foreach(old('loker_type') as $key => $value)
                            {{$value==$val?'selected':''}}
                            @endforeach
                            @endif
                            >{{$val}}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('loker_type')
                            <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-3 ml-2">
                        <label for="">Status</label><br>
                        <select name="status" id="status" class="form-control">
                            <option value="">Pilih</option>
                            <option value="1">ACC</option>
                            <option value="0">Tidak ACC</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <span class="btn btn-secondary" id="loker_reset" onclick="kosong()">Reset</span>
                <button type="submit" class="btn btn-primary ml-2">Simpan</button>
            </div>
            </fieldset>
            </form>
            <table id="banner" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Nama</th>
                        <th>Title</th>
                        <th>Gaji</th>
                        <th>Status</th>
                        <th class="dt-no-sorting text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $l)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img src="{{$l->image?'/image/loker/'.json_decode($l->image)->url:''}}" alt="" style="max-width: 100%; max-height: 90px"></td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->title}}</td>
                        <td>Rp. {{number_format($l->gaji_min).'-'.number_format($l->gaji_max)}}</td>
                        <td>{{$l->status==1?'ACC':'Tidak ACC'}}</td>
                        <td>
                            <button class="btn btn-warning" onclick="editloker({{$l}})" title="Edit"> <i
                                    class='bx bx-pencil'></i></button>
                            <button class="btn btn-danger" onclick="deleteLoker({{$l->id}})" title="Delete"> <i
                                    class='bx bx-trash'></i></button>
                            <form action="#" method="post" id="formdelclasses">@csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<form action="#" method="get" id="activeform">@csrf
</form>
@endsection
@section('custom-js')
<script>
    var loker_deskripsi = CKEDITOR.replace("loker_deskripsi");
    var loker_jobdesk = CKEDITOR.replace("loker_jobdesk");
    // var firstUpload = new FileUploadWithPreview('myFirstImage')
    createDataTable('#banner')
	$('#filClassesImage').change(function (e) { 
		getImgData(this,'#prvClassesImage');
	});
    $('#loker_skill').select2({
            placeholder: 'Input or Select',
            tags:true
        });
        $('#loker_type').select2({
            placeholder: 'Input or Select',
            tags:true
        });
    function kosong() {
        $('#loker_id').val(null)
        $('#loker_title').val(null)
        $('#loker_gaji_min').val(null)
        $('#loker_gaji_max').val(null)
        $('#loker_deskripsi').val(null)
        $('#loker_jobdesk').val(null)
        $('#loker_tanggal_awal').val(null)
        $('#loker_tanggal_akhir').val(null)
        $('#loker_skill').val(null)
        $('#loker_type').val(null)
        $('#loker_skill').trigger('change')
        $('#loker_type').trigger('change')
        $('#status').val(null)
    }
    function editloker(data) {
        kosong();
        console.log(data);
        if (data.image) {
            let img = JSON.parse(data.image)
            $('#prvClassesImage').attr('src', '/image/loker/'+img.url)
        }
        $('#loker_alamat').val(data.alamat)
        $('#loker_email').val(data.email)
        $('#loker_nama').val(data.nama)
        $('#status').val(data.status)
        $('#loker_id').val(data.id)
        $('#loker_title').val(data.title)
        $('#loker_gaji_min').val(data.gaji_min)
        $('#loker_gaji_max').val(data.gaji_max)
        $('#loker_gaji_min').change()
        $('#loker_gaji_max').change()
        // $('#loker_deskripsi').val(data.deskripsi)
        // $('#loker_jobdesk').val(data.jobdesk)
        loker_deskripsi.setData(data.deskripsi)
        loker_jobdesk.setData(data.jobdesk)
        $('#loker_tanggal_awal').val(data.tanggal_awal)
        $('#loker_tanggal_akhir').val(data.tanggal_akhir)
        $('#loker_skill').val(JSON.parse(data.skill))
        $('#loker_type').val(JSON.parse(data.type))
        $('#loker_skill').trigger('change')
        $('#loker_type').trigger('change')
    }
    function deleteLoker(id) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formdelclasses').attr('action','/loker/'+id);
				$('#formdelclasses').submit();
			}else{
				$('#formdelclasses').attr('action','#');
			}
		})
	}
</script>
@endsection