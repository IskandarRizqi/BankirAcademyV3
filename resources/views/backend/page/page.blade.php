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
            <table id="banner" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Tanggal Tayang</th>
                        <th>Description</th>
                        <th>Banner</th>
                        <th class="dt-no-sorting text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $l)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td class="text-truncate" style="max-width: 350px;" title="{{$l->title}}">{{$l->title}}
                        </td>
                        <td>
                            @if (Carbon\Carbon::parse($l->date_start)->format('d-m-Y') ==
                            Carbon\Carbon::parse($l->date_end)->format('d-m-Y'))
                            {{Carbon\Carbon::parse($l->date_start)->format('d-m-Y')}}
                            @else
                            {{Carbon\Carbon::parse($l->date_start)->format('d-m-Y')}}
                            s/d
                            {{Carbon\Carbon::parse($l->date_end)->format('d-m-Y')}}
                            @endif</td>
                        <td class="d-inline-block text-truncate" style="max-width: 350px;">
                            {!!$l->description!!}</td>
                        <td>
                            <img src="{{$l->thumbnail}}" alt="" width="130px">
                        </td>
                        <td>
                            <a href="/admin/pages/edit/{{$l->id}}">
                                <button class="btn btn-warning" id="edit" title="Edit"><i
                                        class='bx bx-edit'></i></button>
                            </a>
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
				$('#formdelclasses').attr('action','/admin/pages/delete/'+id);
				$('#formdelclasses').submit();
			}else{
				$('#formdelclasses').attr('action','#');
			}
		})
	}
</script>
@endsection