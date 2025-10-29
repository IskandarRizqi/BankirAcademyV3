@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="/admin/ipakses" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="">Nama</label>
                        <div class="input-group">
                            <input type="text" name="nama" id="nama" class="form-control" required>
                            @error('nama')
                            <span class="text-danger">Nama wajib terisi</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="">IP Address</label>
                        <div class="input-group">
                            <input type="text" name="ipaddress" id="ipaddress" class="form-control" required>
                            @error('ipaddress')
                            <span class="text-danger">ipaddress wajib terisi</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    Simpan
                </button>
                <span class="btn btn-secondary btn-sm" id="reset" onclick="reset()">
                    Reset
                </span>
            </form>
            <table id="banner" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="8%">No</th>
                        <th>Nama</th>
                        <th>Ip</th>
                        <th class="dt-no-sorting text-center" width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $f )
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$f->nama}}</td>
                        <td>{{$f->ip}}</td>
                        <td>
                            <button class="btn btn-warning" id="edit" onclick="edit({{ $f }})" title="Edit"><i
                                    class='bx bx-edit'></i></button>
                            <button class="btn btn-danger" onclick="hapus('{{ $f->id }}')" title="Delete"> <i
                                    class='bx bx-trash'></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<form id="form_delete" action="{{ route('ipakses.destroy', 0) }}" method="post">
    @csrf
    @method('DELETE')
    <input type="text" name="id_ip" id="id_ip" hidden>
</form>
@endsection
@section('custom-js')
<script>
    createDataTable('#banner')
    $('#kelas').select2({
		tags: true,
	});
    function reset() {
        $('#id').val(null)
        $('#nama').val(null)
        $('#ipaddress').val(null)
    }
    function edit(data) {
        $('#id').val(data.id)
        $('#nama').val(data.nama)
        $('#ipaddress').val(data.ip)
    }
    function hapus(id) {
        $('#id_ip').val(id)
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $('#form_delete').submit()
            }
        });
    }
</script>
@endsection