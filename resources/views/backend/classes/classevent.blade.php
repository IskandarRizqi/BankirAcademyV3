@extends('backend.template')
@section('content')
	<div class="col-lg-12">
		<div class="widget">
			<div class="widget-heading">
				<a class="btn" data-dismiss="modal" href="/admin/classes"><i class="flaticon-cancel-12"></i> Back</a>
			</div>
			<div class="widget-content">
				<form action="/admin/classes/setevent" id="newClassEventForm" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
					<input type="hidden" name="hdnClassesId" value="{{$id}}" id="hdnClassesId">

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="txtClassesTitle">Title</label>
								<small class="inputerrormessage text-danger" input-target="txtClassesTitle" style="display: none;"></small>
								<input type="text" name="txtClassesTitle" id="txtClassesTitle" class="form-control" value="{{$classes->title}}" required>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-block btn-primary">Save</button>
				</form>
			</div>
		</div>
	</div>
	@include('backend.classes.newclassesmodal')
@endsection
@section('custom-js')

@endsection