@extends('backend.template')
@section('content')
<div class="widget">
    <form action="/admin/laman/store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="widget-heading d-flex">
                    <a href="/admin/laman">
                        <button type="button" class="btn btn-secondary btn-sm">
                            Back
                        </button>
                    </a>
                    <h4 class="title ml-auto ">Tambah</h4>
                </div>
                <div class="widget-content">
                    <input type="text" class="form-control" name="id" id="id" value="{{old('id')}}" hidden>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Date: <b class="text-danger">*</b> </label>
                                        <input type="date" class="form-control" name="tgl_tayang" id="tgl_tayang"
                                            value="{{old('tgl_tayang')}}">
                                        @error('tgl_tayang')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Date Expired: <b class="text-danger">*</b></label>
                                        <input type="date" class="form-control" name="tgl_expired" id="tgl_expired"
                                            value="{{old('tgl_expired')}}">
                                        @error('tgl_expired')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Type: <b class="text-danger">*</b></label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="1" {{old('type')=='1' ?'selected':''}}>Head</option>
                                            <option value="2" {{old('type')=='2' ?'selected':''}}>Footer</option>
                                        </select>
                                        @error('type')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Status: <b class="text-danger">*</b></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="1" {{old('status')=='1' ?'selected':''}}>Aktif</option>
                                            <option value="2" {{old('status')=='2' ?'selected':''}}>Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>No Urut: <b class="text-danger">*</b></label>
                                        <input type="number" name="no_urut" id="no_urut" class="form-control"
                                            value="{{old('no_urut')}}">
                                        @error('no_urut')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Title: <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="{{old('title')}}">
                                @error('title')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="oldbanner" value="{{old('banner')}}" hidden>
                                <input type="text" name="oldsizebanner" value="{{old('size_banner')}}" hidden>
                                <label>Banner: <b class="text-danger">*</b></label>
                                <input type="file" class="form-control" name="banner" id="txtThumbnail"
                                    accept="image/*">
                                <img src="{{old('banner')?'/Image/laman/banner/'.old('banner'):'/Backend/assets/img/90x90.jpg'}}"
                                    alt="Image Preview" id="prvImage" class="previewImage"
                                    style="max-width: 100%;max-height:97px;">
                                @error('banner')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Content: <b class="text-danger">*</b></label>
                                <textarea name="content" id="txaPageAbout"
                                    class="form-control">{{old('content')}}</textarea>
                                @error('content')
                                <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
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
                            <input type="text" name="oldsizemetaimage" value="{{old('meta_size_image')}}" hidden>
                            <label>Image: <b class="text-danger">*</b></label>
                            <input type="file" class="form-control" name="meta_image" id="image" accept="image/*">
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
</div>

<div class="col-lg-12">
    <button class="btn btn-primary">SAVE</button>
    <a href="/admin/laman">
        <span type="button" class="btn btn-secondary">
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
    var newClassCKEditor = CKEDITOR.replace("txaPageAbout");
	$('#txtThumbnail').change(function (e) { 
		getImgData(this,'#prvImage');
	});
	$('#image').change(function (e) { 
		getImgData(this,'#prvImageMeta');
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
    $('#del_meta').on('click', function () {
        // $(this).closest(".d-flex").remove();
        console.log('aa');
    });
    function del(x) {
        x.closest(".d-flex").remove();
    }
</script>
@endsection