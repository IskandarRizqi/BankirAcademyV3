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
							<button class="btn btn-primary btn-large" type="button" onclick="resetClassesForm();openmodal('#newClassesModal')">New</button>
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
									<button class="btn bs-tooltip btn-info" title="Pricing"><i class="bx bx-dollar"></i></button>
									<button class="btn bs-tooltip btn-success" title="File"><i class="bx bx-file"></i></button>
									<button class="btn bs-tooltip btn-primary" title="Event"><i class="bx bx-calendar"></i></button>
								</td>
								<td>
									<button class="btn bs-tooltip btn-warning" title="Edit" onclick="editClasses({{$v}});"><i class="bx bx-edit"></i></button>
									<button class="btn bs-tooltip btn-danger" title="Delete" onclick="deleteClasses({{$v->id}})"><i class="bx bx-trash"></i></button>
									<form action="#" method="post" id="formdelclasses">@csrf @method('DELETE')</form>
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
	var newClassCKEditor = CKEDITOR.replace("txaClassesContent");
	createDataTable('#tblClasses');
	$('#filClassesImage').change(function (e) { 
		getImgData(this,'#prvClassesImage');
	});
	function resetClassesForm() {
		$('#newClassesForm').attr('action','/admin/classes');
		$('#hdnClassesMethod').val('POST').trigger('change');
		$('#hdnClassesId').val('0').trigger('change');
		$('#txtClassesTitle').val('').trigger('change');
		$('#slcClassesCategory').val('').trigger('change');
		$('#datClassesDateStart').val('').trigger('change');
		$('#datClassesDateEnd').val('').trigger('change');
		$('#txtClassesInstructor').val('').trigger('change');
		$('#slcClassesTags').val('').trigger('change');
		$('#filClassesImage').val('').trigger('change');
		$('#numClassesLimit').val('').trigger('change');
		$('#txaClassesContent').val('').trigger('change');
		// newClassCKEditor.setData('');
	};
	function editClasses(c) {
		resetClassesForm();
		$('#newClassesForm').attr('action','/admin/classes/'+c.id);
		$('#hdnClassesMethod').val('PUT').trigger('change');
		$('#hdnClassesId').val(c.id).trigger('change');
		$('#txtClassesTitle').val(c.title).trigger('change');
		$('#slcClassesCategory').val(c.category).trigger('change');
		$('#datClassesDateStart').val(c.date_start).trigger('change');
		$('#datClassesDateEnd').val(c.date_end).trigger('change');
		$('#txtClassesInstructor').val(JSON.parse(c.instructor)).trigger('change');
		var tags = JSON.parse(c.tags);
		if (tags!=null && tags!='null') {
			var h = '';
			for (let i = 0; i < tags.length; i++) {
				const e = tags[i];
				h+='<option value="'+e+'">'+e+'</option>';
			}
			$('#slcClassesTags').html(h);
			$('#slcClassesTags').val(JSON.parse(c.tags)).trigger('change');
		}
		// $('#filClassesImage').val(c.image).trigger('change');
		$('#numClassesLimit').val(c.participant_limit).trigger('change');
		$('#txaClassesContent').val(c.content).trigger('change');
		newClassCKEditor.setData(c.content);
		openmodal('#newClassesModal');
	}
	function submitClassesForm() {
		$('#newClassesForm').submit()
	}
	function deleteClasses(id) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formdelclasses').attr('action','/admin/classes/'+id);
				$('#formdelclasses').submit();
			}else{
				$('#formdelclasses').attr('action','#');
			}
		})
	}
</script>
@endsection