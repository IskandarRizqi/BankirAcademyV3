@extends('backend.template')
@section('content')
	<div class="col-lg-12">
		<div class="widget">
			<div class="widget-heading">
				<form action="/admin/classes">
					@csrf
					<div class="row">
						<div class="col-lg-6">
							<div class="input-group mb-4">
								<input type="date" class="form-control" value="{{$param['date_start']}}" placeholder="Date Start" aria-label="Date Start" name="param_date_start">
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon5">s/d</span>
								</div>
								<input type="date" class="form-control" value="{{$param['date_end']}}" placeholder="Date End" aria-label="Date End" name="param_date_end">
							</div>
							<div class="row">
								<div class="col-lg-8">
									<button class="btn btn-primary btn-block" type="submit">Cari</button>
								</div>
								<div class="col-lg-4">
									<a href="/admin/classes" class="btn btn-warning btn-block" type="button">Reset</a>
								</div>
							</div>
						</div>
						<div class="col-lg-6 text-right">
							<button class="btn btn-primary btn-large" type="button" onclick="openmodal('#newClassesModal')">New</button>
						</div>
					</div>
				</form>
			</div>
			<div class="widget-content">
				<div class="table-responsive">
					<table id="tblClasses" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Class</th>
								<th>Category</th>
								<th>Instructor</th>
								<th>Data</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($classes as $k=>$v)
							<tr>
								<td>
									<span hidden>
										{{Carbon\Carbon::parse($v->date_start)->format('U')}}
									</span>
									{{Carbon\Carbon::parse($v->date_start)->format('d-m-Y')}}
									s/d
									{{Carbon\Carbon::parse($v->date_end)->format('d-m-Y')}}
								</td>
								<td>{{$v->title}}</td>
								<td>{{$v->category}}</td>
								<td>
									@foreach ($v->instructor_list as $i)
									<span class="badge badge-primary">{{$i->name}}</span>
									@endforeach
								</td>
								<td>
									<button class="btn btn-info"><i class="bx bx-dollar"></i></button>
									<button class="btn btn-success"><i class="bx bx-file"></i></button>
									<button class="btn btn-primary"><i class="bx bx-calendar"></i></button>
								</td>
								<td>
									<button class="btn btn-warning"><i class="bx bx-edit"></i></button>
									<button class="btn btn-danger"><i class="bx bx-trash"></i></button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('backend.classes.newclassesmodal')
@endsection
@section('custom-js')
<script>
	createDataTable('#tblClasses');
</script>
@endsection