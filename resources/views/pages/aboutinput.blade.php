@extends('backend.template')
@section('content')
<div class="col-lg-12">
	<div class="widget">
		<div class="widget-heading">
			<h3>Syarat dan Ketentuan</h3>
		</div>
		<div class="widget-content">
			<form action="/admin/pages/setabout" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Title:</label>
							<input type="text" class="form-control" name="txtTitle" id="txtTitle"
								value="{{isset($about->title)?$about->title:null}}" required>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Thumbnail:</label>
							<input type="file" class="form-control" name="txtThumbnail" id="txtThumbnail"
								accept="image/*">
							<img src="{{isset($about->thumbnail)?$about->thumbnail:'/Backend/assets/img/90x90.jpg'}}"
								alt="Image Preview" id="prvImage" class="previewImage"
								style="max-width: 100%;max-height:97px;">
						</div>
					</div>
					{{-- <div class="col-lg-12">
						<div class="form-group">
							<label>Content:</label>
							<textarea name="txaPageAbout" id="txaPageAbout" class="form-control"
								required>{{isset($about->content)?$about->content:null}}</textarea>
						</div>
					</div> --}}
				</div>
				<div class="row" id="formnya">
					@isset($about->content)
					@for ($i=0; $i < count(json_decode($about->content)[0]);$i++)
						<div class="col-lg-3" id="form_judul{{$i}}">
							<div class="form-group">
								<label>Judul:</label>
								<input type="text" name="judul[]" id="judul" class="form-control"
									value="{{json_decode($about->content)[0][$i]}}">
								@error('judul')
								<small class="text-danger">Harus Diisi</small>
								@enderror
								<span class="btn btn-danger btn-sm del_forms" id="del" onclick="del({{$i}})">-</span>
							</div>
						</div>
						<div class="col-lg-9" id="form_content{{$i}}">
							<div class="form-group">
								<label>Content:</label>
								<textarea name="content[]" id="contentAbout{{$i}}"
									class="form-control">{{json_decode($about->content)[1][$i]}}</textarea>
								@error('judul')
								<small class="text-danger">Harus Diisi</small>
								@enderror
							</div>
						</div>
						@endfor
						@endisset
				</div>
				<span class="btn btn-success text-right" id="tambahform">+</span>
				<div class="col-lg-12 text-right">
					<button class="btn btn-primary">SAVE</button>
				</div>
			</form>
		</div>
	</div>
	<input type="text" name="" id="countData"
		value="{{isset($about->content)?count(json_decode($about->content)[0]):0}}" hidden>
</div>
@endsection
@section('custom-js')
<script>
	let noCKEDITOR = $('#countData').val();
	if (noCKEDITOR > 0) {
		for (let index = 0; index < noCKEDITOR; index++) {
			// const element = array[index];
			var newClassCKEditor = CKEDITOR.replace("contentAbout"+index);
		}
	}
	// var newClassCKEditor = CKEDITOR.replace("txaPageAbout");
	$('#txtThumbnail').change(function (e) { 
		getImgData(this,'#prvImage');
	});
	$('#tambahform').on('click',function () {
        let html = '';
		html += '<div class="col-lg-3" id="form_judul'+noCKEDITOR+'">';
		html += '	<div class="form-group">';
		html += '		<label>Judul:</label>';
		html += '		<input type="text" name="judul[]" id="judul" class="form-control">';
		// html += '		@error('judul')';
		// html += '		<small class="text-danger">Harus Diisi</small>';
		// html += '		@enderror';
		html += '		<span class="btn btn-danger btn-sm del_forms" id="del" onclick="del('+noCKEDITOR+')">-</span>';
		html += '	</div>';
		html += '</div>';
		html += '<div class="col-lg-9" id="form_content'+noCKEDITOR+'">';
		html += '	<div class="form-group">';
		html += '		<label>Content:</label>';
		html += '		<textarea name="content[]" id="contentAbout'+noCKEDITOR+'" class="form-control"></textarea>';
		// html += '		@error('judul')';
		// html += '		<small class="text-danger">Harus Diisi</small>';
		// html += '		@enderror';
		html += '	</div>';
		html += '</div>';
        $('#formnya').append(html);
		var newClassCKEditor2 = CKEDITOR.replace("contentAbout"+noCKEDITOR);
		noCKEDITOR++;
    })
    $('.del_form').on('click', function () {
        $(this).closest(".d-flex").remove();
    });
    function del(x) {
        $("#form_judul"+x).remove();
        $("#form_content"+x).remove();
    }
</script>
@endsection