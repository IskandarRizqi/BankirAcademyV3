@extends('backend.beranda')
@section('content')
<div class="layout-px-spacing mt-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="/admin/fee" method="POST">
                        @csrf
                        <input type="text" name="id" id="id" hidden>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Kelas</label>
                                    <select name="kelas[]" id="kelas" class="form-control tagging" multiple>
                                        @foreach ($kelas as $k)
                                        <option value="{{$k->title}}">{{$k->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="">Nominal</label>
                                <div class="input-group">
                                    <input type="number" name="nominal" id="nominal" step="any" class="form-control"
                                        required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
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
                                <th>Kelas</th>
                                <th>Nominal</th>
                                <th class="dt-no-sorting text-center" width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fee as $key => $f )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    @if (json_decode($f->class_id))
                                    @foreach (json_decode($f->class_id) as $fe)
                                    <span class="badge badge-info">{{$fe}}</span>
                                    @endforeach
                                    @else
                                    All
                                    @endif
                                </td>
                                <td>{{$f->nominal}} %</td>
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
    </div>
</div>
<form id="form_delete" action="{{ route('fee.destroy', 0) }}" method="post">
    @csrf
    @method('DELETE')
    <input type="text" name="id_fee" id="id_fee" hidden>
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
        $('#nominal').val(null)
        $("#kelas").val(null).trigger('change');
    }
    function edit(data) {
        $('#id').val(data.id)
        $('#nominal').val(data.nominal)
        $("#kelas").val(JSON.parse(data.class_id)).trigger('change');
    }
    function hapus(id) {
        $('#id_fee').val(id)
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