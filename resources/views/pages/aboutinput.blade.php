@extends('backend.beranda')
@section('content')
<div class="col-lg-12">
	<div class="widget">
		<div class="widget-heading">
			<h3>About</h3>
		</div>
		<div class="widget-content">
			<form action="/admin/pages/setabout" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Title:</label>
							<input type="text" class="form-control" name="txtTitle" id="txtTitle" value="{{isset($about->title)?$about->title:null}}" required>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Thumbnail:</label>
							<input type="file" class="form-control" name="txtThumbnail" id="txtThumbnail" accept="image/*">
							<img src="{{isset($about->thumbnail)?$about->thumbnail:'/Backend/assets/img/90x90.jpg'}}" alt="Image Preview" id="prvImage" class="previewImage" style="max-width: 100%;max-height:97px;">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Content:</label>
							<textarea name="txaPageAbout" id="txaPageAbout" class="form-control" required>{{isset($about->content)?$about->content:null}}</textarea>
						</div>
					</div>
					<div class="col-lg-12">
						<button class="btn btn-block btn-primary">SAVE</button>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    var newClassCKEditor = CKEDITOR.replace("txaPageAbout");
	$('#txtThumbnail').change(function (e) { 
		getImgData(this,'#prvImage');
	});
</script>
@endsection