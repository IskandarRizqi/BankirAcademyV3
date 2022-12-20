@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            <form action="/admin/corporate" method="POST" enctype="multipart/form-data">
                @csrf
                <input name="id" id="id" value="{{old('id')}}" hidden>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{old('nama')}}" class="form-control">
                        @error('nama')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">No. Telp</label>
                        <input type="text" name="no_telp" id="no_telp" value="{{old('no_telp')}}" class="form-control">
                        @error('no_telp')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Alamat</label>
                        <textarea name="alamat" id="alamat" cols="30" rows="10"
                            class="form-control">{{old('alamat')}}</textarea>
                        @error('alamat')
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
                            <th>Nama</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key=> $p)
                        <tr>
                            <td>{{$p->nama}}</td>
                            <td>{{$p->no_telp}}</td>
                            <td>{{$p->alamat}}</td>
                            <td>
                                <button class="btn btn-warning" id="edit" title="Edit"
                                    onclick="editPromo('{{$p->id}}','{{$p->nama}}','{{$p->alamat}}','{{$p->no_telp}}')"><i
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
				$('#formdelpromo').attr('action','/admin/corporate/'+id);
				$('#formdelpromo').submit();
			}else{
				$('#formdelpromo').attr('action','#');
			}
		})
	}
    function editPromo(id,nama,alamat,telp) {
        $('#id').val(id);
        $('#nama').val(nama);
        $('#alamat').val(alamat);
        $('#no_telp').val(telp);
    }
    function reset() {
        $('#id').val(null);
        $('#nama').val(null);
        $('#alamat').val(null);
        $('#no_telp').val(null);
    }
</script>
@endsection