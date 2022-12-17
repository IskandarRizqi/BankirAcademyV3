@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-heading">
            <a href="/admin/pages">
                <button type="button" class="btn btn-secondary btn-sm">
                    Back
                </button>
            </a>
            <h3>Page</h3>
        </div>
        <div class="widget-content">
            <form action="/admin/pages/update" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" class="form-control" name="id" id="id"
                    value="{{ isset($page->id) ? $page->id : null }}" hidden>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Type:</label>
                            <select name="type" id="type" class="form-control">
                                <option value="0" @if (isset($page->type)) {{ $page->type == 0 ? 'selected' : '' }}
                                    @endif>
                                    Blog</option>
                                <option value="1" @if (isset($page->type)) {{ $page->type == 1 ? 'selected' : '' }}
                                    @endif>
                                    About</option>
                                <option value="2" @if (isset($page->type)) {{ $page->type == 2 ? 'selected' : '' }}
                                    @endif>
                                    Contact</option>
                                <option value="3" @if (isset($page->type)) {{ $page->type == 3 ? 'selected' : '' }}
                                    @endif>
                                    Syarat dan
                                    Ketentuan
                                </option>
                                {{-- <option value="4" @if (isset($page->type)) {{ $page->type == 4 ? 'selected' : '' }}
                                    @endif>
                                    Calon Bankir
                                </option>
                                <option value="5" @if (isset($page->type)) {{ $page->type == 5 ? 'selected' : '' }}
                                    @endif>
                                    Bankir</option>
                                <option value="6" @if (isset($page->type)) {{ $page->type == 6 ? 'selected' : '' }}
                                    @endif>
                                    Bootcamp Bankir
                                </option> --}}
                                {{-- <option value="7" {{isset($page->title)==7?'selected':''}}>Bantuan</option> --}}
                                <option value="8" @if (isset($page->type)) {{ $page->type == 8 ? 'selected' : '' }}
                                    @endif>
                                    Mitra
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" class="form-control" name="txtTitle" id="txtTitle" maxlength="70"
                                value="{{ isset($page->title) ? $page->title : null }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="date_start" id="date_start" class="form-control"
                                        value="{{ isset($page->date_start) ? $page->date_start : null }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="date_end" id="date_end" class="form-control"
                                        value="{{ isset($page->date_end) ? $page->date_end : null }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea type="text" class="form-control" name="description" id="description"
                                maxlength="300"
                                required>{{ isset($page->description) ? $page->description : null }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Thumbnail:</label>
                            <input type="file" class="form-control" name="txtThumbnail" id="txtThumbnail"
                                accept="image/*">
                            <img src="{{ isset($page->thumbnail) ? $page->thumbnail : '/Backend/assets/img/90x90.jpg' }}"
                                alt="Image Preview" id="prvImage" class="previewImage"
                                style="max-width: 100%;max-height:97px;">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Content:</label>
                            <textarea name="txaPageAbout" id="txaPageAbout" class="form-control"
                                required>{{ isset($page->content) ? $page->content : null }}</textarea>
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
        $('#txtThumbnail').change(function(e) {
            getImgData(this, '#prvImage');
        });
</script>
@endsection