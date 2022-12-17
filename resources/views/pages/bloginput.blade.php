@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-heading">
            <h3>Blog</h3>
        </div>
        <div class="widget-content">
            <form action="/admin/pages/setblog/{{ $id }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" class="form-control" name="txtTitle" id="txtTitle" maxlength="120"
                                value="{{ isset($blog->title) ? $blog->title : null }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Thumbnail:</label>
                            <input type="file" class="form-control" name="txtThumbnail" id="txtThumbnail"
                                accept="image/*">
                            <img src="{{ isset($blog->thumbnail) ? $blog->thumbnail : '/Backend/assets/img/90x90.jpg' }}"
                                alt="Image Preview" id="prvImage" class="previewImage"
                                style="max-width: 100%;max-height:97px;">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="datClassesDateStart">Date</label>
                            <small class="inputerrormessage text-danger" input-target="DateStart"
                                style="display: none;"></small>
                            <small class="inputerrormessage text-danger" input-target="DateEnd"
                                style="display: none;"></small>
                            <div class="input-group mb-4">
                                <input type="date" class="form-control" name="DateStart" id="DateStart"
                                    placeholder="Date Start" aria-label="Date Start"
                                    value="{{ isset($blog->date_start) ? $blog->date_start : '' }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon5">s/d</span>
                                </div>
                                <input type="date" class="form-control" name="DateEnd" id="DateEnd"
                                    placeholder="Date End" aria-label="Date End"
                                    value="{{ isset($blog->date_end) ? $blog->date_end : '' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea type="text" class="form-control" name="txtdescription" id="txtdescription"
                                maxlength="500"
                                required>{{ isset($blog->description) ? $blog->description : null }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Content:</label>
                            <textarea name="txaPageBlog" id="txaPageBlog" class="form-control"
                                required>{{ isset($blog->content) ? $blog->content : null }}</textarea>
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
    var newClassCKEditor = CKEDITOR.replace("txaPageBlog");
        $('#txtThumbnail').change(function(e) {
            getImgData(this, '#prvImage');
        });
</script>
@endsection