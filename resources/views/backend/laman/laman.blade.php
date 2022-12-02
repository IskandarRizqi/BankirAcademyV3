@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <!-- Button trigger modal -->
            <a href="/admin/laman/create">
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
                        <th>Status</th>
                        <th>Title</th>
                        <th>Tanggal Tayang</th>
                        {{-- <th>Content</th> --}}
                        <th>Banner</th>
                        <th class="dt-no-sorting text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $l)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td onclick="accLaman('{{$l->id}}','{{$l->status}}')">{{$l->status?'Aktif':'Tidak
                            Aktif'}}</td>
                        <td class="text-truncate" style="max-width: 350px;" title="{{$l->title}}">{{$l->title}}
                        </td>
                        <td>
                            @if (Carbon\Carbon::parse($l->tgl_tayang)->format('d-m-Y') ==
                            Carbon\Carbon::parse($l->tgl_expired)->format('d-m-Y'))
                            {{Carbon\Carbon::parse($l->tgl_tayang)->format('d-m-Y')}}
                            @else
                            {{Carbon\Carbon::parse($l->tgl_tayang)->format('d-m-Y')}}
                            s/d
                            {{Carbon\Carbon::parse($l->tgl_expired)->format('d-m-Y')}}
                            @endif</td>
                        {{-- <td class="d-inline-block text-truncate" style="max-width: 350px;">
                            {!!$l->content!!}</td> --}}
                        <td>
                            <img src="{{asset('Image/laman/banner/'.json_decode($l->banner)->url)}}" alt=""
                                width="130px">
                        </td>
                        <td>
                            <a href="/admin/laman/edit/{{$l->id}}">
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
    function accLaman(id,status) {
        let s = 'Tidak Aktif';
        if (status==0) {
            s='Aktif';
        }
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: s,
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#activeform').attr('action','/admin/laman/activated/'+id+'/'+status);
				$('#activeform').submit();
			}else{
				$('#activeform').attr('action','#');
			}
		})
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
				$('#formdelclasses').attr('action','/admin/laman/destroy/'+id);
				$('#formdelclasses').submit();
			}else{
				$('#formdelclasses').attr('action','#');
			}
		})
	}

    // function viewimage(image) {
    //     console.log(image)
    //     swal.fire({
    //         imageUrl: '/image/' + image,
    //         imageWidth: 400,
    //         imageHeight: 200,
    //         imageAlt: 'Custom image',
    //         animation: false,
    //         padding: '2em'
    //     })
    // }

    // function rlsInp(id) {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     });
    //     jQuery.ajax({
    //         url: "/admin/banner/" + id,
    //         method: 'get',

    //         success: function(result) {
    //             // 
    //             $('#formbanner').attr('action', '{{url("/update-banner")}}');
    //             // console.log(result);
    //             $("#judul").val(result.nama)
    //             $("#idbanner").val(id)
    //             $("#aktif").val(result.mulai)
    //             $("#type").val(result.jenis)
    //             $("#selesai").val(result.selesai)
    //             $("#urlbanner").val(result.public_id)
    //             $(".custom-file-container__image-preview").css("background-image", "url(/image/" + result.image + ")")

    //             // $("#judul").val()
    //         }
    //     });
    // }
</script>
@endsection