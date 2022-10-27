@extends('backend.template')
@section('content')
@if (Session::get('success'))
<div class="alert alert-dismissible alert-success">
    <i class="icon-gift"></i><strong>Success!</strong>
    {{Session::get('success')}}
    {{-- <button type="button" class="btn btn-close btn-sm" data-bs-dismiss="alert" aria-hidden="true">x</button> --}}
</div>
@endif
@if (Session::get('error'))
<div class="alert alert-dismissible alert-danger">
    <i class="icon-gift"></i><strong>Failed!</strong>
    {{Session::get('error')}}
    {{-- <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-hidden="true"></button> --}}
</div>
@endif
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            <div class="table-responsive">
                <table id="tblPembayaran" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Status</th>
                            <th>No Invoice</th>
                            <th>Bukti</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayaran as $key=> $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><span class="badge badge-primary text-uppercase">
                                    {{$p->status==1?'lunas':'belum lunas'}}
                                </span>
                            </td>
                            <td>{{$p->no_invoice}}</td>
                            <td>
                                <a class="grid-item" href="/getBerkas?rf={{$p->file}}" data-lightbox="gallery-item"><img
                                        src="/getBerkas?rf={{$p->file}}" width="110px"></a>
                            </td>
                            <td>{{$p->price_final}}</td>
                            <td>
                                {{-- <span hidden>
                                    {{Carbon\Carbon::parse($p->date_start)->format('U')}}
                                </span> --}}
                                {{Carbon\Carbon::parse($p->date_start)->format('d-m-Y')}}
                                s/d
                                {{Carbon\Carbon::parse($p->date_end)->format('d-m-Y')}}
                            </td>
                            <td>{{$p->title}}</td>
                            <td>{{$p->category}}</td>
                            <td>{{$p->name}}</td>
                            <td>
                                <button class="btn bs-tooltip btn-warning" title="Publish Certificate"
                                    onclick="publichCertificate({{$p->id}},{{$p->certificate}})"><i
                                        class='bx bxs-file-doc'></i></button>
                                <button class="btn bs-tooltip btn-info" title="Approved"
                                    onclick="approved({{$p->id}},{{$p->status}})"><i class='bx bx-wallet'></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="#" method="post" id="formpembayaran">@csrf <input type="text" name="id" id="id" hidden>
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
    createDataTable('#tblPembayaran');
    function viewimage(image) {
        swal.fire({
            imageUrl: '/image/' + image,
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
            animation: false,
            padding: '2em'
        })
    }
    function approved(id,status) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Done',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formpembayaran').attr('action','/admin/pembayaran/approved');
                $('#id').val(id);
                $('#status').val(status);
				$('#formpembayaran').submit();
			}
		})
	}
    function publichCertificate(id,certificate) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Done',
			padding: '2em'
		}).then(function(result) {
            if (result.value) {
                $('#formpembayaran').attr('action','/admin/pembayaran/certificate');
                $('#id').val(id);
                $('#certificate').val(certificate);
				$('#formpembayaran').submit();
			}
		})
	}
</script>
@endsection