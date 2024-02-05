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
                                <label for="">Perusahaan</label><br>
                                <select name="perusahaan_id" id="perusahaan_id" class="form-control">
                                    <option value="">Pilih Perusahaan</option>
                                    @if($perusahaan)
                                    @foreach($perusahaan as $key => $va)
                                    <option value="{{$va}}" @if(old('perusahaan_id')==$va) selected @endif>{{$va->nama}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('perusahaan_id')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Minimal Gaji</label>
                                <input type="text" name="loker_gaji_min" id="loker_gaji_min" class="form-control"
                                    value="{{old('loker_gaji_min')}}">
                                <small id="labelgajimin"></small>
                                @error('loker_gaji_min')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="loker_title" id="loker_title" class="form-control"
                                    value="{{old('loker_title')}}">
                                @error('loker_title')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3" hidden>
                            <div class="form-group">
                                <label for="">Maksimal Gaji</label>
                                <input type="number" name="loker_gaji_max" id="loker_gaji_max" class="form-control"
                                    value="{{old('loker_gaji_max')}}">
                                <small id="labelgajimax"></small>
                                @error('loker_gaji_max')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="loker_deskripsi" id="loker_deskripsi" cols="30" rows="5"
                                    class="form-control">{{old('loker_deskripsi')}}</textarea>
                                @error('loker_deskripsi')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Jobdesk</label>
                                <textarea name="loker_jobdesk" id="loker_jobdesk" cols="30" rows="5"
                                    class="form-control">{{old('loker_jobdesk')}}</textarea>
                                @error('loker_jobdesk')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex">
                            <div class="form-group">
                                <label for="">Tanggal Awal</label>
                                <input type="date" name="loker_tanggal_awal" id="loker_tanggal_awal"
                                    class="form-control" value="{{old('loker_tanggal_awal')}}">
                                @error('loker_tanggal_awal')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                            <div class="form-group ml-2">
                                <label for="">Tanggal Akhir</label>
                                <input type="date" name="loker_tanggal_akhir" id="loker_tanggal_akhir"
                                    class="form-control" value="{{old('loker_tanggal_akhir')}}">
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
                                    <option value="{{$va}}" @if(old('loker_skill')) {{-- @foreach(old('loker_skill') as
                                        $key=> $value)
                                        {{$value==$va?'selected':''}}
                                        @endforeach --}}
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
                                    <option value="{{$val}}" @if(old('loker_type')) @foreach(old('loker_type') as $key=>
                                        $value)
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
                        <td>
                            @if($l->perusahaan)
                            @php
                            $js = json_decode($l->perusahaan->image)
                            @endphp
                            <img src="{{$js?'/image/loker/'.$js->url:''}}" alt=""
                                style="max-width: 100%; max-height: 90px">
                            @else
                            <img src="{{$l->image?'/image/loker/'.json_decode($l->image)->url:''}}" alt=""
                                style="max-width: 100%; max-height: 90px">
                            @endif
                        </td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->title}}</td>
                        <td>{{$l->gaji_min?$l->gaji_min:'Gaji Competitive'}}</td>
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
    // function getkabupaten(){
    //     let v = $('#provinsi').val();
    //     $.ajax({
    //             type:'GET',
    //             url:'/admin/loker/getkabupaten/'+v,
    //             data:'_token = <?php echo csrf_token() ?>',
    //             success:function(data) {
    //                 let t = '';
    //                 if (data) {
    //                     t+='<option>Pilih</option>';
    //                     data.forEach(el => {
    //                         t+='<option value='+el.id+'>'+el.name+'</option>';
    //                     });
    //                 }
    //                 $('#kabupaten').html(t);
    //             }
    //         });
    // }
    // function getkecamatan(){
    //     let v = $('#kabupaten').val();
    //     $.ajax({
    //             type:'GET',
    //             url:'/admin/loker/getkecamatan/'+v,
    //             data:'_token = <?php echo csrf_token() ?>',
    //             success:function(data) {
    //                 let t = '';
    //                 if (data) {
    //                     t+='<option>Pilih</option>';
    //                     data.forEach(el => {
    //                         t+='<option value='+el.id+'>'+el.name+'</option>';
    //                     });
    //                 }
    //                 $('#kecamatan').html(t);
    //             }
    //         });
    // }
    // function getkelurahan(){
    //     let v = $('#kecamatan').val();
    //     $.ajax({
    //             type:'GET',
    //             url:'/admin/loker/getkelurahan/'+v,
    //             data:'_token = <?php echo csrf_token() ?>',
    //             success:function(data) {
    //                 let t = '';
    //                 if (data) {
    //                     t+='<option>Pilih</option>';
    //                     data.forEach(el => {
    //                         t+='<option value='+el.id+'>'+el.name+'</option>';
    //                     });
    //                 }
    //                 $('#kelurahan').html(t);
    //             }
    //         });
    // }
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
        $('#perusahaan_id').val(null)
        $('#loker_skill').trigger('change')
        $('#loker_type').trigger('change')
        $('#perusahaan_id').trigger('change')
        $('#status').val(null)
    }
    function editloker(data) {
        kosong();
        console.log(data);
        if (data.image) {
            let img = JSON.parse(data.image)
            $('#prvClassesImage').attr('src', '/image/loker/'+img.url)
        }
        // $('#loker_alamat').val(data.alamat)
        // $('#loker_email').val(data.email)
        // $('#loker_nama').val(data.nama)
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
        $('#loker_skill').trigger('change')
        $('#loker_type').val(JSON.parse(data.type))
        $('#loker_type').trigger('change')
        $.ajax({
            type:'GET',
            url:'/admin/perusahaan/'+data.perusahaan_id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {
                let t = '';
                if (data) {
                        $('#perusahaan_id').val(JSON.stringify(data))
                        $('#perusahaan_id').trigger('change')
                    }
                }
            });
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