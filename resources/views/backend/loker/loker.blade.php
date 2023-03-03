@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <!-- Button trigger modal -->
            <a href="/admin/pages/edit/null">
                <button type="button" class="btn btn-primary btn-sm">
                    Tambah
                </button>
            </a>
        </div>
        <div class="card-body">
            <form action="loker" method="POST" enctype="multipart/form-data">
                <fieldset class="border p-2">
            @csrf
            <input type="text" name="loker_id" id="loker_id" hidden>
                <legend class="w-auto">Form Loker</legend>
            <div class="row border-2">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="loker_title" id="loker_title" class="form-control">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Minimal Gaji</label>
                        <input type="number" name="loker_gaji_min" id="loker_gaji_min" class="form-control">
                        <small id="labelgajimin"></small>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Maksimal Gaji</label>
                        <input type="number" name="loker_gaji_max" id="loker_gaji_max" class="form-control">
                        <small id="labelgajimax"></small>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="loker_deskripsi" id="loker_deskripsi" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Jobdesk</label>
                        <textarea name="loker_jobdesk" id="loker_jobdesk" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-lg-12 d-flex">
                    <div class="form-group">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="loker_tanggal_awal" id="loker_tanggal_awal" class="form-control">
                    </div>
                    <div class="form-group ml-2">
                        <label for="">Tanggal Akhir</label>
                        <input type="date" name="loker_tanggal_akhir" id="loker_tanggal_akhir" class="form-control">
                    </div>
                    <div class="form-group ml-2">
                        <label for="">Skill</label><br>
                        <select name="loker_skill[]" id="loker_skill" class="form-control" multiple>
                            <option value="">Pilih Skill</option>
                            @if($lokerskill)
                            @foreach(json_decode($lokerskill[0]) as $key => $va)
                            <option value="{{$va}}">{{$va}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <label for="">type</label><br>
                        <select name="loker_type[]" id="loker_type" class="form-control" multiple>
                            <option value="">Pilih Type</option>
                            @if($lokertype)
                            @foreach(json_decode($lokertype[0]) as $key => $val)
                            <option value="{{$val}}">{{$val}}</option>
                            @endforeach
                            @endif
                        </select>
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
    // var firstUpload = new FileUploadWithPreview('myFirstImage')
    createDataTable('#banner')
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
        $('#status').val(data.status)
        $('#loker_id').val(data.id)
        $('#loker_title').val(data.title)
        $('#loker_gaji_min').val(data.gaji_min)
        $('#loker_gaji_max').val(data.gaji_max)
        $('#loker_gaji_min').change()
        $('#loker_gaji_max').change()
        $('#loker_deskripsi').val(data.deskripsi)
        $('#loker_jobdesk').val(data.jobdesk)
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