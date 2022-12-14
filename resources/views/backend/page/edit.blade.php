@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-heading">
            <h3>Page</h3>
        </div>
        <div class="widget-content">
            <form action="/admin/pages/update" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" class="form-control" name="id" id="id" value="{{isset($page->id)?$page->id:null}}"
                    hidden>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Type:</label>
                            <select name="type" id="type" class="form-control">
                                <option value="0" {{isset($page->title)==0?'selected':''}}>Blog</option>
                                <option value="1" {{isset($page->title)==1?'selected':''}}>About</option>
                                <option value="2" {{isset($page->title)==2?'selected':''}}>Contact</option>
                                <option value="3" {{isset($page->title)==3?'selected':''}}>Syarat dan Ketentuan</option>
                                <option value="4" {{isset($page->title)==4?'selected':''}}>Calon Bankir</option>
                                <option value="5" {{isset($page->title)==5?'selected':''}}>Bankir</option>
                                <option value="6" {{isset($page->title)==6?'selected':''}}>Bootcamp Bankir</option>
                                {{-- <option value="7" {{isset($page->title)==7?'selected':''}}>Bantuan</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" class="form-control" name="txtTitle" id="txtTitle"
                                value="{{isset($page->title)?$page->title:null}}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Thumbnail:</label>
                            <input type="file" class="form-control" name="txtThumbnail" id="txtThumbnail"
                                accept="image/*">
                            <img src="{{isset($page->thumbnail)?$page->thumbnail:'/Backend/assets/img/90x90.jpg'}}"
                                alt="Image Preview" id="prvImage" class="previewImage"
                                style="max-width: 100%;max-height:97px;">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Content:</label>
                            <textarea name="txaPageAbout" id="txaPageAbout" class="form-control"
                                required>{{isset($page->content)?$page->content:null}}</textarea>
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