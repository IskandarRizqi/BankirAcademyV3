@extends('backend.template')
@section('content')
<div class="col-lg-12">
	<div class="widget">
		<div class="widget-heading">
			<a class="btn" data-dismiss="modal" href="/admin/classes"><i class="flaticon-cancel-12"></i> Back</a>
		</div>
		<div class="widget-content">
			<form action="/admin/classes" id="newClassesForm" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
				<input type="hidden" name="hdnClassesId" value="0" id="hdnClassesId">

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="txtClassesTitle">Title</label>
							<small class="inputerrormessage text-danger" input-target="txtClassesTitle"
								style="display: none;"></small>
							<input type="text" name="txtClassesTitle" id="txtClassesTitle" class="form-control"
								required>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="slcClassesCategory">Category</label>
							<small class="inputerrormessage text-danger" input-target="slcClassesCategory"
								style="display: none;"></small>
							<select class="form-control tagging slc2tag" name="slcClassesCategory"
								id="slcClassesCategory" required>
								<option value=""></option>
								@foreach ($category as $ctg)
								<option value="{{$ctg}}">{{$ctg}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label for="datClassesDateStart">Class Date</label>
							<small class="inputerrormessage text-danger" input-target="datClassesDateStart"
								style="display: none;"></small>
							<small class="inputerrormessage text-danger" input-target="datClassesDateEnd"
								style="display: none;"></small>
							<div class="input-group mb-4">
								<input type="date" class="form-control" name="datClassesDateStart"
									id="datClassesDateStart" placeholder="Date Start" aria-label="Date Start" required>
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon5">s/d</span>
								</div>
								<input type="date" class="form-control" name="datClassesDateEnd" id="datClassesDateEnd"
									placeholder="Date End" aria-label="Date End" required>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="txtClassesInstructor">Instruktor</label>
							<small class="inputerrormessage text-danger" input-target="txtClassesInstructor"
								style="display: none;"></small>
							<select class="form-control slc2" multiple name="txtClassesInstructor[]"
								id="txtClassesInstructor" required>
								@foreach ($instructor as $ins)
								<option value="{{($ins->id)}}">{{$ins->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="slcClassesTags">Tag</label>
							<small class="inputerrormessage text-danger" input-target="slcClassesTags"
								style="display: none;"></small>
							<select class="form-control tagging slc2tag" multiple name="slcClassesTags[]"
								id="slcClassesTags" required>
								{{-- @foreach ($category as $ctg)
								<option value="{{$ctg}}">{{$ctg}}</option>
								@endforeach --}}
							</select>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label for="filClassesImage">Image</label>
									<small class="inputerrormessage text-danger" input-target="filClassesImage"
										style="display: none;"></small>
									<input type="file" name="filClassesImage" id="filClassesImage" class="form-control"
										accept="image/*" maxfilesize="1048576" required>
									<img src="#" alt="Image Preview" id="prvClassesImage" class="previewImage"
										style="max-width: 100%;max-height:97px;">
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label for="filClassesImageMobile">Image ( detail/mobile)</label>
									<small class="inputerrormessage text-danger" input-target="filClassesImageMobile"
										style="display: none;"></small>
									<input type="file" name="filClassesImageMobile" id="filClassesImageMobile"
										class="form-control" accept="image/*" maxfilesize="1048576" required>
									<img src="#" alt="Image Preview" id="prvClassesImageMobile" class="previewImage"
										style="max-width: 100%;max-height:97px;">
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="numClassesLimit">Participant Limit</label>
							<small class="inputerrormessage text-danger" input-target="numClassesLimit"
								style="display: none;"></small>
							<input type="number" min="1" max="999" value="13" name="numClassesLimit"
								id="numClassesLimit" class="form-control" required>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label for="txaClassesContent">Description</label>
							<small class="inputerrormessage text-danger" input-target="txaClassesContent"
								style="display: none;"></small>
							<textarea name="txaClassesContent" id="txaClassesContent" class="form-control"
								required></textarea>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-block btn-primary" onclick="submitClassesForm()">Save</button>
			</form>
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
	$('#filClassesImageMobile').change(function (e) { 
		getImgData(this,'#prvClassesImageMobile');
	});

	$('#newClassesForm').submit(function (e) { 
		e.preventDefault();
		submitClassesForm($(this));
	});
	function submitClassesForm(formelm) {
		$('.inputerrormessage').hide();
		$('#txaClassesContent').val(newClassCKEditor.getData());
		var saveable=true;
		var req = ['txtClassesTitle','slcClassesCategory','datClassesDateStart','datClassesDateEnd','txtClassesInstructor','slcClassesTags','filClassesImage','numClassesLimit','txaClassesContent','filClassesImageMobile'];
		$('#newClassesForm').find('input,select,textarea').each(function () {
			var nm = $(this).attr('id');
			if(req.includes(nm)){
				console.log(nm,$(this).val().length);
				if ($(this).attr('type')=='file') {
					if (this.files.length == 0 && $(this).siblings('.previewImage').attr('src')=='#') {
						$('.inputerrormessage[input-target="'+nm+'"]').text('*This Field Is Required');
						$('.inputerrormessage[input-target="'+nm+'"]').show();
						saveable=false;
					}else if (this.files[0].size > $(this).attr('maxfilesize')) {
						$('.inputerrormessage[input-target="'+nm+'"]').text('*Maximum File Size Is '+($(this).attr('maxfilesize')/1048576)+'MB');
						$('.inputerrormessage[input-target="'+nm+'"]').show();
						saveable=false;
					}
				}else{
					if (!$(this).val() || $(this).val() == '' || $(this).val().length == 0) {
						$('.inputerrormessage[input-target="'+nm+'"]').text('*This Field Is Required');
						$('.inputerrormessage[input-target="'+nm+'"]').show();
						saveable=false;
					}
				}
			}
		});
		if (saveable) {
			formelm[0].submit();
		}
	}
</script>
@endsection