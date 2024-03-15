@extends('backend.template')
<style>
    .caption {
        position: absolute;
        top: 25%;
        left: 10%;
        text-align: left;
        color: rgb(0, 0, 0);
        font-weight: 200;
    }
</style>
@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <button type="button" class="btn btn-primary btn-sm m-2" onclick="edit(null)">
            Tambah
        </button>
        <div class="table-responsive">
            <table id="zero-config" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Limit</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$value->nama}}</td>
                        <td>Rp. {{number_format($value->harga)}}</td>
                        <td>{{$value->limit}}</td>
                        <td><img src="{{asset($value->gambar)}}" alt="" height="200px">
                        </td>
                        <td>
                            <span class="btn btn-warning btn-sm" onclick="edit({{$value}})">Edit</span>
                            <span class="btn btn-danger btn-sm" onclick="hapus({{$value->id}})">Delete</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- @foreach($data as $key => $v)
            <div class="col-md-6">
                <div class="caption" style="font-size: 12px; width: 170px">{!!$v->keterangan!!}</div>
                <img src="{{asset($v->gambar)}}" alt="" onclick="edit({{$v}})" style="cursor: pointer">
                <div class="">
                </div>
                <button onclick="hapus({{$v->id}})" class="btn btn-danger btn-sm">Hapus</button>
            </div>
            @endforeach --}}
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="partnerModal" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="/admin/member" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="text" name="id" id="id" hidden>
                    <div class="row m-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Urutan</label>
                                <select name="urutan" id="urutan" class="form-control">
                                    <option value="1" {{old('urutan')==1 ? 'selected' :''}}>1</option>
                                    <option value="2" {{old('urutan')==2 ? 'selected' :''}}>2</option>
                                    <option value="3" {{old('urutan')==3 ? 'selected' :''}}>3</option>
                                    <option value="4" {{old('urutan')==4 ? 'selected' :''}}>4</option>
                                    <option value="5" {{old('urutan')==5 ? 'selected' :''}}>5</option>
                                    <option value="6" {{old('urutan')==6 ? 'selected' :''}}>6</option>
                                </select>
                                @error('urutan')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Aktif</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1" {{old('is_active')==1 ? 'selected' :''}}>Aktif</option>
                                    <option value="0" {{old('is_active')==0 ? 'selected' :''}}>Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Video Kursus</label>
                                <input type="number" name="video_kursus" id="video_kursus" class="form-control"
                                    value="{{old('video_kursus')}}">
                                @error('video_kursus')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input type="number" name="harga" id="harga" class="form-control"
                                    value="{{old('harga')}}">
                                <small id="smallharga"></small>
                                @error('harga')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{old('nama')}}">
                                <small id="smallnama"></small>
                                @error('nama')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Limit Loker</label>
                                <input type="number" name="limit" id="limit" class="form-control"
                                    value="{{old('limit')}}">
                                <small id="smalllimit"></small>
                                @error('limit')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Digital CV</label>
                                <div class="row">
                                    <div class="n-chk col-lg-6">
                                        <label
                                            class="new-control new-checkbox new-checkbox-rounded new-checkbox-text checkbox-primary">
                                            <input type="checkbox" class="new-control-input" name="cvats" value="1"
                                                id="cvats">
                                            <span class="new-control-indicator"></span><span class="new-chk-content">ATS
                                                Friendly</span>
                                        </label>
                                    </div>
                                    <div class="n-chk col-lg-6">
                                        <label
                                            class="new-control new-checkbox new-checkbox-rounded new-checkbox-text checkbox-primary">
                                            <input type="checkbox" class="new-control-input" name="cvbankir" value="1"
                                                id="cvbankir">
                                            <span class="new-control-indicator"></span><span
                                                class="new-chk-content">Bankir Friendly</span>
                                        </label>
                                    </div>
                                </div>
                                @error('limit')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Lamaran Online ( Atas Nama Bankir )</label>
                                <input type="number" name="lamaran_online" id="lamaran_online" class="form-control"
                                    value="{{old('lamaran_online')}}">
                                @error('lamaran_online')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Lamaran Offline ( Atas Nama Bankir )</label>
                                <input type="number" name="lamaran_offline" id="lamaran_offline" class="form-control"
                                    value="{{old('lamaran_offline')}}">
                                @error('lamaran_offline')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Pelatihan Gratis</label>
                                <input type="number" name="pelatihan_gratis" id="pelatihan_gratis" class="form-control"
                                    value="{{old('pelatihan_gratis')}}">
                                @error('pelatihan_gratis')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-file-container" data-upload-id="myFirstImage">
                                    <label>Upload (Single File) <a href="javascript:void(0)"
                                            class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                    <label class="custom-file-container__custom-file">
                                        <input type="file" class="custom-file-container__custom-file__custom-file-input"
                                            accept="image/*" name="picture">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div id="img_preview" class="custom-file-container__image-preview"></div>
                                </div>
                                @error('picture')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea type="text" class="form-control" id="keterangan"
                                    name="keterangan">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                <span class="text-danger" role="alert">
                                    <strong>Harap Diisi</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</span>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            <form id="form_delete" action="/admin/member/delete" method="post">
                @csrf
                <input type="text" name="idmember" id="idmember" hidden>
            </form>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    var firstUpload = new FileUploadWithPreview('myFirstImage')
    var newClassCKEditor = CKEDITOR.replace("keterangan");
    createDataTable('#zero-config')
    function hapus(id) {
        $('#idmember').val(id)
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $('#form_delete').submit()
            }
        });
    }
    function edit(data) {
        openmodal('#partnerModal')
        // let data = JSON.parse($(this).attr('data-data'))
        $('#id').val(null)
        $('#nama').val(null)
        $('#harga').val(null)
        $('#limit').val(null)
        $('#cvats').attr('checked',false)
        $('#cvbankir').attr('checked',false)
        $('#lamaran_online').val(null)
        $('#lamaran_offline').val(null)
        $('#pelatihan_gratis').val(null)
        newClassCKEditor.setData(null)
        document.getElementById('img_preview').style.backgroundImage="url('/')";
        if (data) {
            $('#id').val(data['id'])
            $('#nama').val(data['nama'])
            $('#harga').val(data['harga'])
            $('#limit').val(data['limit'])
            $('#urutan').val(data['urutan'])
            $('#is_active').val(data['is_active'])
            $('#video_kursus').val(data['video_kursus'])
            if (data.cvats == 1) {
                $('#cvats').attr('checked',true)
            }
            if (data.cvbankir == 1) {
                $('#cvbankir').attr('checked',true)
            }
            $('#lamaran_online').val(data['lamaran_online'])
            $('#lamaran_offline').val(data['lamara_offline'])
            $('#pelatihan_gratis').val(data['pelatihan_gratis'])
            setTimeout(() => {
                newClassCKEditor.setData(data['keterangan'])
            }, 1000);
            document.getElementById('img_preview').style.backgroundImage="url('/"+data['gambar']+"')";
        }
    }

</script>
@endsection