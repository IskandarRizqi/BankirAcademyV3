@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/admin/perusahaan" method="POST" enctype="multipart/form-data">
                <fieldset class="border p-2">
                    @csrf
                    <input type="text" name="loker_id" id="loker_id" hidden>
                    <legend class="w-auto">Form Loker</legend>
                    <div class="row border-2">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="filClassesImage">Image</label>
                                <small class="inputerrormessage text-danger" input-target="filClassesImage"
                                    style="display: none;"></small>
                                <input type="file" name="filClassesImage" id="filClassesImage" class="form-control"
                                    accept="image/*" maxfilesize="1048576">
                                <img src="#" alt="Image Preview" id="prvClassesImage" class="previewImage"
                                    style="max-width: 100%;max-height:97px;">
                                @error('filClassesImage')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Nama Perusahaan</label>
                                <input type="text" name="loker_nama" id="loker_nama" class="form-control"
                                    value="{{old('loker_nama')}}">
                                @error('loker_nama')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="loker_email" id="loker_email" class="form-control"
                                    value="{{old('loker_email')}}">
                                @error('loker_email')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Provinsi</label>
                                <select name="provinsi" id="provinsi" class="form-control" onchange="getkabupaten()"
                                    required>
                                    <option>Pilih</option>
                                    @foreach($provinsi as $key => $v)
                                    <option value="{{$v->id}}" {{old('provinsi')==$v->id?'selected':''}}>{{$v->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('provinsi')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Kabupaten</label>
                                <select name="kabupaten" id="kabupaten" class="form-control" onchange="getkecamatan()"
                                    required>
                                    <option>Pilih</option>
                                </select>
                                @error('kabupaten')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="form-control" onchange="getkelurahan()"
                                    required>
                                    <option>Pilih</option>
                                </select>
                                @error('kecamatan')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Kelurahan</label>
                                <select name="kelurahan" id="kelurahan" class="form-control" required>
                                    <option>Pilih</option>
                                </select>
                                @error('kelurahan')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <input type="text" name="loker_alamat" id="loker_alamat" class="form-control"
                                    value="{{old('loker_alamat')}}">
                                @error('loker_alamat')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
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
                        <th>Email</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th class="dt-no-sorting text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $l)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img src="{{$l->image?'/image/loker/'.json_decode($l->image)->url:''}}" alt=""
                                style="max-width: 100%; max-height: 90px"></td>
                        <td>{{$l->nama}}</td>
                        <td>{{$l->email}}</td>
                        <td>{{$l->provinsi_name}}</td>
                        <td>{{$l->kabupaten_name}}</td>
                        <td>{{$l->kecamatan_name}}</td>
                        <td>{{$l->kelurahan_name}}</td>
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
    $('#provinsi').select2({
            placeholder: 'Input or Select',
        });
    $('#kabupaten').select2({
            placeholder: 'Input or Select',
        });
    $('#kelurahan').select2({
            placeholder: 'Input or Select',
        });
    $('#kecamatan').select2({
            placeholder: 'Input or Select',
        });
    $('#loker_skill').select2({
            placeholder: 'Input or Select',
            tags:true
        });
    $('#loker_type').select2({
        placeholder: 'Input or Select',
        tags:true
    });
    function getkabupaten(){
        let v = $('#provinsi').val();
        $.ajax({
                type:'GET',
                url:'/admin/loker/getkabupaten/'+v,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    let t = '';
                    if (data) {
                        t+='<option>Pilih</option>';
                        data.forEach(el => {
                            t+='<option value='+el.id+'>'+el.name+'</option>';
                        });
                    }
                    $('#kabupaten').html(t);
                }
            });
    }
    function getkecamatan(){
        let v = $('#kabupaten').val();
        $.ajax({
                type:'GET',
                url:'/admin/loker/getkecamatan/'+v,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    let t = '';
                    if (data) {
                        t+='<option>Pilih</option>';
                        data.forEach(el => {
                            t+='<option value='+el.id+'>'+el.name+'</option>';
                        });
                    }
                    $('#kecamatan').html(t);
                }
            });
    }
    function getkelurahan(){
        let v = $('#kecamatan').val();
        $.ajax({
                type:'GET',
                url:'/admin/loker/getkelurahan/'+v,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    let t = '';
                    if (data) {
                        t+='<option>Pilih</option>';
                        data.forEach(el => {
                            t+='<option value='+el.id+'>'+el.name+'</option>';
                        });
                    }
                    $('#kelurahan').html(t);
                }
            });
    }
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
        $('#loker_id').val(data.id)
        $('#provinsi').val(data.provinsi)
        $('#provinsi').trigger('change')
        getkabupaten()
        setTimeout(() => {
            $('#kabupaten').val(data.kabupaten)
            $('#kabupaten').trigger('change')
            getkecamatan()
            setTimeout(() => {
                $('#kecamatan').val(data.kecamatan)
                $('#kecamatan').trigger('change')
                getkelurahan()
                setTimeout(() => {
                    $('#kelurahan').val(data.kelurahan)
                    $('#kelurahan').trigger('change')
                }, 1000);
            }, 1000);
        }, 1000);
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
				$('#formdelclasses').attr('action','/admin/perusahaan/'+id);
				$('#formdelclasses').submit();
			}else{
				$('#formdelclasses').attr('action','#');
			}
		})
	}
</script>
@endsection