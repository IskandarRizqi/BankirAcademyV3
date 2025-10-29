@extends('backend.template')
@section('content')
<div class="col-lg-12">
	<div class="widget">
		<div class="widget-heading">
			<form action="/admin/pages/getbloglist">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="input-group mb-4">
							<input type="date" class="form-control" value="{{$param['date_start']}}"
								placeholder="Date Start" aria-label="Date Start" name="param_date_start">
							<div class="input-group-append">
								<span class="input-group-text" id="basic-addon5">s/d</span>
							</div>
							<input type="date" class="form-control" value="{{$param['date_end']}}"
								placeholder="Date End" aria-label="Date End" name="param_date_end">
						</div>
						<div class="row">
							<div class="col-lg-8">
								<button class="btn btn-primary btn-block" type="submit">Cari</button>
							</div>
							<div class="col-lg-4">
								<a href="/admin/pages/getbloglist" class="btn btn-warning btn-block" type="button">Reset</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 text-right">
						<a class="btn btn-primary btn-large" type="button" href="/admin/pages/getblog/0">New</a>
					</div>
				</div>
			</form>
		</div>
		<div class="widget-content">
			<div class="table-responsive">
				<table id="tblBlogList" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Judul</th>
							<th>Link</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($blog as $k=>$v)
						<tr>
							<td>
								{{$v->title}}
							</td>
							<td>
								<a href="/pages/blog/{{$v->id}}/{{urlencode(str_ireplace( array( '\'', '/', '//', '"', ',' , ';', '<', '>' ), '', $v->title))}}" target="_blank" class="btn btn-success"><i class="bx bx-link-external"></i></a>
							</td>
							<td>
								<a class="btn btn-primary btn-large" type="button" href="/admin/pages/getblog/{{$v->id}}" title="Edit"><i class="bx bx-edit"></i></a>
								<button class="btn btn-danger btn-large" type="button" onclick="delBlog('/admin/pages/delblog/{{$v->id}}')" title="Delete"><i class="bx bx-trash"></i></button>
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
@endsection
@section('custom-js')
<script>
	createDataTable('#tblBlogList');

	function delBlog(url) {
		swal({
			title: 'This data will be deleted?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				window.location.href = url;
			}
		})
	}
</script>
@endsection