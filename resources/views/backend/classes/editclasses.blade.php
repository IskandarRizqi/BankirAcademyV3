@extends('backend.template')
@section('content')
<div class="col-lg-12">
	<div class="widget">
		<div class="widget-heading">
			<a class="btn" data-dismiss="modal"
				href="{{Auth::user()->role==3?'/instructor/classes':'/admin/classes'}}"><i
					class="flaticon-cancel-12"></i> Back</a>
		</div>
		<div class="widget-content">
			<form action="/admin/classes/{{$id}}" id="newClassesForm" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="_method" value="PUT" id="hdnClassesMethod">
				<input type="hidden" name="hdnClassesId" value="{{$id}}" id="hdnClassesId">
				<div class="row">
					<div class="col-md-8">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="txtClassesTitle">Title</label>
									<small class="inputerrormessage text-danger" input-target="txtClassesTitle"
										style="display: none;"></small>
									<input type="text" name="txtClassesTitle" id="txtClassesTitle" class="form-control"
										value="{{$classes->title}}" required>
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
												<option value="1" {{$classes->level==1?'selected':''}}>Pemula</option>
												<option value="2" {{$classes->level==2?'selected':''}}>Menengah</option>
												<option value="3" {{$classes->level==3?'selected':''}}>Lanjutan</option>
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
												@if ($ctg==$classes->category)
												<option value="{{$ctg}}" selected="selected">{{$ctg}}</option>
												@else
												<option value="{{$ctg}}">{{$ctg}}</option>
												@endif
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
											value="{{$classes->date_start}}" required>
										<div class="input-group-append">
											<span class="input-group-text" id="basic-addon5">s/d</span>
										</div>
										<input type="date" class="form-control" name="datClassesDateEnd"
											id="datClassesDateEnd" placeholder="Date End" aria-label="Date End"
											value="{{$classes->date_end}}" required>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<div class="col">
										<div class="form-group">
											<input type="text" name="" id="oldSlcClassesType" value="{{$classes->tipe}}"
												hidden>
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
											<input type="text" name="" id="oldSlcClassesJenis"
												value="{{$classes->jenis}}" hidden>
											<label for="slcClassesCategory">Jenis</label>
											<select class="form-control tagging" name="slcClassesJenis[]"
												id="slcClassesJenis" multiple>
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
										@if (in_array($ins->id,json_decode($classes->instructor)))
										<option value="{{($ins->id)}}" selected="selected">{{$ins->name}}</option>
										@else
										<option value="{{($ins->id)}}">{{$ins->name}}</option>
										@endif
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
										@foreach (json_decode($classes->tags) as $tag)
										<option value="{{$tag}}" selected>{{$tag}}</option>
										@endforeach
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
												class="form-control" accept="image/*" maxfilesize="1048576">
											<img src="{{$classes->image}}" alt="Image Preview" id="prvClassesImage"
												class="previewImage" style="max-width: 100%;max-height:97px;">
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label for="filClassesImageMobile">Image ( detail/mobile)</label>
											<small class="inputerrormessage text-danger"
												input-target="filClassesImageMobile" style="display: none;"></small>
											<input type="file" name="filClassesImageMobile" id="filClassesImageMobile"
												class="form-control" accept="image/*" maxfilesize="1048576">
											<img src="{{$classes->image_mobile}}" alt="Image Preview"
												id="prvClassesImageMobile" class="previewImage"
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
										id="numClassesLimit" class="form-control"
										value="{{$classes->participant_limit}}" required>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label for="txaClassesContent">Description</label>
									<small class="inputerrormessage text-danger" input-target="txaClassesContent"
										style="display: none;"></small>
									<textarea name="txaClassesContent" id="txaClassesContent" class="form-control"
										required>{{$classes->content}}</textarea>
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
									<input type="text" name="meta_title" id="meta_title"
										value="@isset(json_decode($classes->og)->title){{json_decode($classes->og)->title}}@endisset"
										class="form-control">
									@error('meta_title')
									<small class="text-danger">Harus Diisi</small>
									@enderror
								</div>
								<div class="form-group">
									<label for="">Description <b class="text-danger">*</b></label>
									<input type="text" name="meta_description" id="meta_description"
										value="@isset(json_decode($classes->og)->description){{json_decode($classes->og)->description}}@endisset"
										class="form-control">
									@error('meta_description')
									<small class="text-danger">Harus Diisi</small>
									@enderror
								</div>
								<div class="form-group">
									<input type="text" name="oldmetaimage"
										value="@isset(json_decode($classes->og)->image){{json_decode($classes->og)->image}}@endisset"
										hidden>
									<input type="text" name="oldsizemetaimage"
										value="@isset(json_decode($classes->og)->size){{json_decode($classes->og)->size}}@endisset"
										hidden>
									<label>Image: <b class="text-danger">*</b></label>
									<input type="file" class="form-control" name="meta_image" id="image"
										accept="image/*">
									<img src="/Image/laman/meta_image/@isset(json_decode($classes->og)->image){{json_decode($classes->og)->image}}@endisset"
										{{--
										{{$classes->og?'/Image/laman/meta_image/'.json_decode($classes->og)->image:'/Backend/assets/img/90x90.jpg'}}
									--}}
									alt="Image Preview" id="prvImageMeta" class="previewImage" style="max-width:
									100%;max-height:97px;">
									@error('meta_image')
									<small class="text-danger">Harus Diisi</small>
									@enderror
								</div>
							</div>
							<hr>
							<h4>Additional Meta <small>(optional)</small></h4>
							<div id="meta_form">
								{{-- @if ($classes->meta) --}}
								@if (json_decode($classes->meta))
								@for ($i=0; $i < count(json_decode($classes->meta)->name); $i++) <div
										class="form-group">
										<div class="d-flex">
											<div class="form-group">
												<label for="">Name</label>
												<input type="text" name="meta_name[]" id="meta_name"
													value="{{json_decode($classes->meta)->name[$i]}}"
													class="form-control">
											</div>
											<div class="form-group ml-auto">
												<label for="">Content</label>
												<input type="text" name="meta_content[]" id="meta_content"
													value="{{json_decode($classes->meta)->content[$i]}}"
													class="form-control">
												<span class="btn btn-danger btn-sm del_form" id="del_meta">-</span>
											</div>
										</div>
										@endfor
									</div>
									@endif
									{{-- @endif --}}
							</div>
							<div class="d-flex">
								<span class="btn btn-primary btn-sm" id="add_meta">+</span>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-block btn-primary" onclick="submitClassesForm()">Save</button>
			</form>
		</div>
	</div>
	@include('backend.classes.newclassesmodal')
	@endsection
	@section('custom-js')
	<script>
		$(document).ready(function () {
		let old_type = $('#oldSlcClassesType').val();
		$("#slcClassesType").val(JSON.parse(old_type)).trigger('change');
		let old_jenis = $('#oldSlcClassesJenis').val();
		$("#slcClassesJenis").val(JSON.parse(old_jenis)).trigger('change');
	})
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
		var req = ['txtClassesTitle','slcClassesCategory','datClassesDateStart','datClassesDateEnd','txtClassesInstructor','slcClassesTags','numClassesLimit','txaClassesContent',];
		$('#newClassesForm').find('input,select,textarea').each(function () {
			var nm = $(this).attr('id');
			if(req.includes(nm)){
				if ($(this).attr('type')=='file') {
					if (this.files.length == 0 && $(this).siblings('.previewImage').attr('src')=='#') {
						$('.inputerrormessage[input-target="'+nm+'"]').text('*This Field Is Required');
						$('.inputerrormessage[input-target="'+nm+'"]').show();
						saveable=false;
					}else if ($(this).siblings('.previewImage').attr('src')=='#' && this.files[0].size > $(this).attr('maxfilesize')) {
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
	$("body").on("click",".del_form",function(){ 
          $(this).parents(".d-flex").remove();
      });
	$('#image').change(function (e) { 
		getImgData(this,'#prvImageMeta');
	});
	</script>
	@endsection