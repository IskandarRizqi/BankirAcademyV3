@extends('backend.template')
@section('content')
<div class="widget">
    <form action="/admin/pages/update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="widget-heading d-flex">
                    <a href="/admin/pages">
                        <span class="btn btn-secondary btn-sm">
                            Back
                        </span>
                    </a>
                    <h3 class="ml-auto">Page</h3>
                </div>
                <input type="text" class="form-control" name="id" id="id"
                    value="{{ isset($page->id) ? $page->id : null }}" hidden>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Type:</label>
                            <select name="type" id="type" class="form-control">
                                <option value="0" @if (isset($page->type)) {{ $page->type == 0 ? 'selected' : ''
                                    }}
                                    @endif>
                                    Blog</option>
                                <option value="1" @if (isset($page->type)) {{ $page->type == 1 ? 'selected' : ''
                                    }}
                                    @endif>
                                    About</option>
                                <option value="2" @if (isset($page->type)) {{ $page->type == 2 ? 'selected' : ''
                                    }}
                                    @endif>
                                    Contact</option>
                                <option value="3" @if (isset($page->type)) {{ $page->type == 3 ? 'selected' : ''
                                    }}
                                    @endif>
                                    Syarat dan
                                    Ketentuan
                                </option>
                                {{-- <option value="4" @if (isset($page->type)) {{ $page->type == 4 ? 'selected'
                                    :
                                    '' }}
                                    @endif>
                                    Calon Bankir
                                </option>
                                <option value="5" @if (isset($page->type)) {{ $page->type == 5 ? 'selected' : ''
                                    }}
                                    @endif>
                                    Bankir</option>
                                <option value="6" @if (isset($page->type)) {{ $page->type == 6 ? 'selected' : ''
                                    }}
                                    @endif>
                                    Bootcamp Bankir
                                </option> --}}
                                {{-- <option value="7" {{isset($page->title)==7?'selected':''}}>Bantuan</option>
                                --}}
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
                </div>
            </div>
            <div class="col-lg-4">
                <div class="widget">
                    <div class="widget-heading">
                        <h4>Meta</h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group">
                            <label for="">Title <b class="text-danger">*</b></label>
                            <input type="text" name="meta_title" id="meta_title"
                                value="{{isset($page->meta_title)?$page->meta_title:''}}" class="form-control">
                            @error('meta_title')
                            <small class="text-danger">Harus Diisi</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Description <b class="text-danger">*</b></label>
                            <input type="text" name="meta_description" id="meta_description"
                                value="{{isset($page->meta_description)?$page->meta_description:''}}"
                                class="form-control">
                            @error('meta_description')
                            <small class="text-danger">Harus Diisi</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" name="oldmetaimage"
                                value="{{isset($page->meta_image)?$page->meta_image:''}}" hidden>
                            <input type="text" name="oldsizemetaimage"
                                value="{{isset($page->meta_size_image)?$page->meta_size_image:''}}" hidden>
                            <label>Image: <b class="text-danger">*</b></label>
                            <input type="file" class="form-control" name="meta_image" id="image" accept="image/*">
                            <img src="{{isset($page->meta_image)?'/Image/laman/meta_image/'.$page->meta_image:'/Backend/assets/img/90x90.jpg'}}"
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
                        @isset($page)
                        @if ($page->meta_name || $page->meta_content)
                        @for ($i=0; $i < count($page->meta_name); $i++) <div class="form-group">
                                <div class="d-flex">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="meta_name[]" id="meta_name"
                                            value="{{$page->meta_name[$i]}}" class="form-control">
                                    </div>
                                    <div class="form-group ml-auto">
                                        <label for="">Content</label>
                                        <input type="text" name="meta_content[]" id="meta_content"
                                            value="{{$page->meta_content[$i]}}" class="form-control">
                                        <span class="btn btn-danger btn-sm del_form" id="del_meta">-</span>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            @endif
                            @endisset
                    </div>
                    <div class="d-flex">
                        <span class="btn btn-primary btn-sm" id="add_meta">+</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <button class="btn btn-primary btn-sm">SAVE</button><a href="/admin/pages">
                <span class="btn btn-secondary btn-sm">
                    Back
                </span>
            </a>
        </div>
    </form>
</div>
@endsection
@section('custom-js')
<script>
    $(document).ready(function () {
        // $('#add_meta').click();
        $("body").on("click", ".del_form", function () {
        $(this).closest(".d-flex").remove();
         });
    });
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
    var newClassCKEditor = CKEDITOR.replace("txaPageAbout");
        $('#txtThumbnail').change(function(e) {
            getImgData(this, '#prvImage');
        });
        $('#image').change(function (e) { 
		getImgData(this,'#prvImageMeta');
	});
</script>
@endsection