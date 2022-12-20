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
					<div class="col-md-8">
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
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label for="slcClassesCategory">Level</label>
											<small class="inputerrormessage text-danger" input-target="slcClassesLevel"
												style="display: none;"></small>
											<select class="form-control" name="slcClassesLevel" id="slcClassesLevel"
												required>
												<option value="1">Pemula</option>
												<option value="2">Menengah</option>
												<option value="3">Lanjutan</option>
											</select>
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label for="slcClassesCategory">Category</label>
											<small class="inputerrormessage text-danger"
												input-target="slcClassesCategory" style="display: none;"></small>
											<select class="form-control tagging slc2tag" name="slcClassesCategory"
												id="slcClassesCategory" required>
												<option value=""></option>
												@foreach ($category as $ctg)
												<option value="{{$ctg}}">{{$ctg}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="datClassesDateStart">Class Date</label>
									<small class="inputerrormessage text-danger" input-target="datClassesDateStart"
										style="display: none;"></small>
									<small class="inputerrormessage text-danger" input-target="datClassesDateEnd"
										style="display: none;"></small>
									<div class="input-group mb-4">
										<input type="date" class="form-control" name="datClassesDateStart"
											id="datClassesDateStart" placeholder="Date Start" aria-label="Date Start"
											required>
										<div class="input-group-append">
											<span class="input-group-text" id="basic-addon5">s/d</span>
										</div>
										<input type="date" class="form-control" name="datClassesDateEnd"
											id="datClassesDateEnd" placeholder="Date End" aria-label="Date End"
											required>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label for="slcClassesCategory">Type</label>
											<select class="form-control tagging" name="slcClassesType[]"
												id="slcClassesType" multiple required>
												<option value="BANK">BANK</option>
												<option value="BPR">BPR</option>
												<option value="KOPERASI">KOPERASI</option>
												<option value="LEMABAGA KEUANGAN MICRO (LKM)">LEMABAGA KEUANGAN MICRO
													(LKM)
												</option>
											</select>
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label for="slcClassesCategory">Jenis</label>
											<select class="form-control tagging" name="slcClassesJenis[]"
												id="slcClassesJenis" multiple required>
												<option value="CALON_BANKIR">CALON BANKIR</option>
												<option value="BANKIR">BANKIR</option>
												<option value="BOOTCAMP_BANKIR">BOOTCAMP BANKIR</option>
												<option value="MANAGEMENT_TRAINEE">MANAGEMENT TRAINEE</option>
												</option>
											</select>
										</div>
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
											<input type="file" name="filClassesImage" id="filClassesImage"
												class="form-control" accept="image/*" maxfilesize="1048576" required>
											<img src="#" alt="Image Preview" id="prvClassesImage" class="previewImage"
												style="max-width: 100%;max-height:97px;">
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label for="filClassesImageMobile">Image ( detail/mobile)</label>
											<small class="inputerrormessage text-danger"
												input-target="filClassesImageMobile" style="display: none;"></small>
											<input type="file" name="filClassesImageMobile" id="filClassesImageMobile"
												class="form-control" accept="image/*" maxfilesize="1048576" required>
											<img src="#" alt="Image Preview" id="prvClassesImageMobile"
												class="previewImage" style="max-width: 100%;max-height:97px;">
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
					</div>
					<div class="col-md-4">
						<div class="widget">
							<div class="widget-heading">
								<h4>Meta</h4>
							</div>
							<div class="widget-content">
								<div class="form-group">
									<label for="">Title <b class="text-danger">*</b></label>
									<input type="text" name="meta_title" id="meta_title" value="{{old('meta_title')}}"
										class="form-control">
									@error('meta_title')
									<small class="text-danger">Harus Diisi</small>
									@enderror
								</div>
								<div class="form-group">
									<label for="">Description <b class="text-danger">*</b></label>
									<input type="text" name="meta_description" id="meta_description"
										value="{{old('meta_description')}}" class="form-control">
									@error('meta_description')
									<small class="text-danger">Harus Diisi</small>
									@enderror
								</div>
								<div class="form-group">
									<input type="text" name="oldmetaimage" value="{{old('meta_image')}}" hidden>
									<input type="text" name="oldsizemetaimage" value="{{old('meta_size_image')}}"
										hidden>
									<label>Image: <b class="text-danger">*</b></label>
									<input type="file" class="form-control" name="meta_image" id="image"
										accept="image/*">
									<img src="{{old('meta_image')?'/Image/laman/meta_image/'.old('meta_image'):'/Backend/assets/img/90x90.jpg'}}"
										alt="Image Preview" id="prvImageMeta" class="previewImage"
										style="max-width: 100%;max-height:97px;">
									@error('meta_image')
									<small class="text-danger">Harus Diisi</small>
									@enderror
								</div>
							</div>
							<hr>
							<h4>Additional Meta <small>(optional)</small></h4>
							<div id="meta_form">
								@if (old('meta_name') || old('meta_content'))
								@for ($i=0; $i < count(old('meta_name')); $i++) <div class="form-group">
									<div class="d-flex">
										<div class="form-group">
											<label for="">Name</label>
											<input type="text" name="meta_name[]" id="meta_name"
												value="{{old('meta_name')[$i]}}" class="form-control">
										</div>
										<div class="form-group ml-auto">
											<label for="">Content</label>
											<input type="text" name="meta_content[]" id="meta_content"
												value="{{old('meta_content')[$i]}}" class="form-control">
											<span class="btn btn-danger btn-sm del_form" id="del_meta">-</span>
										</div>
									</div>
									@endfor
							</div>
							@endif
						</div>
						<div class="d-flex">
							<span class="btn btn-primary btn-sm" id="add_meta">+</span>
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
	$('#slcClassesType').select2({
		tagging:true,
	})
	$('#slcClassesJenis').select2({
		tagging:true,
	})
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
	$('#add_meta').on('click',function () {
        let html = '';
        html += '<div class="d-flex">';
        html += '    <div class="form-group">';
        html += '        <label for="">Name</label>';
        html += '        <input type="text" name="meta_name[]" id="meta_name" value="" class="form-control">';
        html += '    </div>';
        html += '    <div class="form-group ml-auto">';
        html += '        <label for="Content">Content</label>';
        html += '        <input type="text" name="meta_content[]" id="meta_content" value=""';
        html += '            class="form-control">';
        html += '<span class="btn btn-danger btn-sm del_form" id="del_meta">-</span>';
        html += '    </div>';
        html += '</div>';
        $('#meta_form').append(html);
    })
    // $('#del_meta').on('click', function () {
    //     $(this).closest(".d-flex").remove();
    //     console.log('aa');
    // });
	$("body").on("click",".del_form",function(){ 
          $(this).parents(".d-flex").remove();
      });
	$('#image').change(function (e) { 
		getImgData(this,'#prvImageMeta');
	});
</script>
@endsection