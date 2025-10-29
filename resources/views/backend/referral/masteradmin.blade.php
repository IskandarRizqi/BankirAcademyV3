@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="/admin/master/store" method="POST">
                @csrf
                <input type="text" name="id" id="id" class="form-control" value="{{old('id')}}" hidden>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="">Nominal</label>
                        <input type="number" name="nominal" id="nominal" class="form-control" value="{{old('nominal')}}"
                            step="any" required>
                        @error('nominal')
                        <span class="text-center">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="">Potongan Harga</label>
                        <input type="number" name="potongan_harga" id="potongan_harga" class="form-control"
                            value="{{old('potongan_harga')}}" step="any" required>
                        @error('potongan_harga')
                        <span class="text-center">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary btn-sm">Simpan</button>
                <span class="btn btn-warning btn-sm" id="reset">Reset</span>
            </form>
            <table id="banner" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nominal</th>
                        <th>Potongan Harga</th>
                        <th class="dt-no-sorting text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $l)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$l->nominal}} %</td>
                        <td>{{$l->potongan_harga}} %</td>
                        <td>
                            <button class="btn btn-warning" id="edit" title="Edit" onclick="edit('{{$l}}')"><i
                                    class='bx bx-edit'></i></button>
                            <button class="btn btn-danger" onclick="deleteLaman({{$l->id}})" title="Delete"> <i
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
    $('#reset').click(function () {
        $('#id').val(null);
        $('#nominal').val(null);
        $('#potongan_harga').val(null);
    })
    function edit(p) {
        let js = JSON.parse(p)
        $('#id').val(js.id);
        $('#nominal').val(js.nominal);
        $('#potongan_harga').val(js.potongan_harga);
    }
    function deleteLaman(id) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formdelclasses').attr('action','/admin/master/del/'+id);
				$('#formdelclasses').submit();
			}else{
				$('#formdelclasses').attr('action','#');
			}
		})
	}
</script>
@endsection