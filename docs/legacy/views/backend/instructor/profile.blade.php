@extends('backend.template')
@section('content')
    <div class="row layout-top-spacing">
        <form action="/instructor/profile" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-card-one">
                    <h3>Update Profile Instructor</h3>
                    <div class="widget-content">
                        <div class="row">
                            <input type="text" id="id" name="id" value="{{ isset($data) ? $data->id : null }}"
                                hidden />
                            <div class="col-6 form-group">
                                <label class="font-body text-capitalize" for="login-form-modal-username">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control"
                                    value="{{ isset($data) ? $data->name : '' }}" />
                                @error('nama')
                                    <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-body text-capitalize" for="login-form-modal-username">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ isset($data) ? $data->user->email : '' }}" readonly />
                                @error('email')
                                    <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-body text-capitalize" for="login-form-modal-username">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ isset($data) ? $data->title : '' }}" />
                                {{-- <small>S. Pd, M. Pd, </small> --}}
                                @error('title')
                                    <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-body text-capitalize" for="login-form-modal-username">No.
                                    HP</label>
                                <input type="number" id="nohp" name="nohp" class="form-control"
                                    value="{{ isset($data) ? $data->nohp : '' }}" />
                                <small>628123456789</small>
                                @error('nohp')
                                    <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-body text-capitalize" for="login-form-modal-username">Alamat</label>
                                <textarea type="text" id="alamat" name="alamat" class="form-control">{{ isset($data) ? $data->alamat : '' }}</textarea>
                                @error('alamat')
                                    <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-body text-capitalize" for="login-form-modal-username">Deskripsi</label>
                                <textarea type="text" id="deskripsi" name="deskripsi" class="form-control"> {{ isset($data) ? $data->desc : '' }}</textarea>
                                @error('deskripsi')
                                    <small class="text-danger">Harus Diisi</small>
                                @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label class="font-body text-capitalize" for="login-form-modal-username">Upload
                                    Dokumen (zip)</label>
                                <input type="file" id="dokumen" name="dokumen" class="form-control"
                                    accept=".zip,.rar,.7zip,.7z,.tar.gz" />
                                @if (isset($data) && $data->dokumen)
                                    <a href="/getBerkas?rf={{ json_decode($data->dokumen)->url }}"><span
                                            class="btn btn-secondary">
                                            Download
                                        </span>
                                    </a>
                                @endif
                                @error('dokumen')
                                    <small class="text-danger">Harus Diisi</small>
                                @enderror
                                @if (Session::has('error'))
                                    <small class="text-danger">{{ Session::get('error') }}</small>
                                @endif
                            </div>
                            <div class="col-6 form-group">
                                <div class="form-group">
                                    <label for="image">Image ( detail/mobile)</label>
                                    <small class="inputerrormessage text-danger" input-target="image"
                                        style="display: none;"></small>
                                    <input type="file" name="image" id="image" class="form-control"
                                        accept="image/*" maxfilesize="1048576">
                                    @if (isset($data) && $data->picture)
                                        @if (json_decode($data->picture))
                                            <img src="{{ '/Image/' . json_decode($data->picture)->url }}"
                                                alt="Image Preview" id="previewImage" class="previewImage"
                                                style="max-width: 100%;max-height:97px;">
                                        @else
                                            <img src="{{ $data->picture }}" alt="Image Preview" id="previewImage"
                                                class="previewImage" style="max-width: 100%;max-height:97px;">
                                        @endif
                                    @endif
                                </div>
                                @error('picture')
                                    <span class="text-danger" role="alert">
                                        <strong>Harap Diisi</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('custom-js')
    <script>
        // var firstUpload = new FileUploadWithPreview('myFirstImage')
        var deskripsi = CKEDITOR.replace("deskripsi");
        $('#image').change(function(e) {
            getImgData(this, '#previewImage');
        });
    </script>
@endsection
