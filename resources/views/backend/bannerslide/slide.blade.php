@extends('backend.beranda')
@section('content')
<div class="layout-px-spacing mt-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId">
                        Tambah
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah banner</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{url('/admin/banner')}}" method="post" id="formbanner"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row mb-1">
                                            <div class="col-lg-6">
                                                <label for="form-control">Judul</label>
                                                <input type="text" class="form-control" name="judul" id="judul"
                                                    placeholder="Judul banner">
                                                <input type="hidden" class="form-control" name="id" id="idbanner">

                                                @if($errors->has('judul'))
                                                <div class="error" style="color: red; display:block;">{{
                                                    $errors->first('judul') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="form-control">Type banner</label>
                                                <select name="jenis" class="form-control" id="type">
                                                    <option value="0" selected>Banner Slide</option>
                                                    <option value="1">Banner Bawah</option>
                                                </select>
                                                @if($errors->has('jenis'))
                                                <div class="error" style="color: red; display:block;">{{
                                                    $errors->first('jenis') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-lg-6">
                                                <label for="form-control">Mulai aktif</label>
                                                <input type="date" class="form-control" name="mulai_aktif" id="aktif">
                                                @if($errors->has('mulai_aktif'))
                                                <div class="error" style="color: red; display:block;">{{
                                                    $errors->first('mulai_aktif') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="form-control">Selesai aktif</label>
                                                <input type="date" class="form-control" name="akhir_aktif" id="selesai">
                                                @if($errors->has('akhir_aktif'))
                                                <div class="error" style="color: red; display:block;">{{
                                                    $errors->first('akhir_aktif') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <!-- <label for="form-control">Image banner</label> -->
                                                <div class="custom-file-container" data-upload-id="myFirstImage">
                                                    <label>Upload Banner <a href="javascript:void(0)"
                                                            class="custom-file-container__image-clear"
                                                            title="Clear Image">x</a></label>
                                                    <label class="custom-file-container__custom-file">
                                                        <input type="file"
                                                            class="custom-file-container__custom-file__custom-file-input"
                                                            accept="image/*" name="banner">
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                        <span
                                                            class="custom-file-container__custom-file__custom-file-control"></span>
                                                    </label>
                                                    <div class="custom-file-container__image-preview"></div>
                                                </div>
                                                @if($errors->has('banner'))
                                                <div class="error" style="color: red; display:block;">{{
                                                    $errors->first('banner') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="banner" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Type</th>
                                <th>Durasi tayang</th>
                                <th>Banner</th>
                                <th class="dt-no-sorting text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banner as $key => $value)
                            <tr>
                                <td width="1%">{{$key + 1}}</td>
                                <td>{{$value->nama}}</td>
                                <td>
                                    @if($value->jenis == 0)
                                    <span class="badge badge-primary">Banner slide</span>
                                    @else
                                    <span class="badge badge-info">Banner promo</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($value->mulai)->format('Y-m-d') }} - {{
                                    \Carbon\Carbon::parse($value->selesai)->format('Y-m-d') }}</td>

                                <td>
                                    <button class="btn btn-info mb-1 mr-1 rounded-circle"
                                        onclick="viewimage('{{$value->image}}')" title="View banner">
                                        <i class='bx bx-image-alt'></i>
                                    </button>
                                </td>
                                <td class="text-center" style="display: flex; justify-content: center;">
                                    <!-- <a href="{{url('merchant/show', $value->id)}}" class="btn btn-warning mb-1 mr-1 rounded-circle" data-toggle="tooltip" title='Update'><i class="bx bx-edit bx-sm"></i></a> -->
                                    <button type="button" class="btn btn-warning mb-1 mr-1 rounded-circle"
                                        data-toggle="modal" data-target="#modelId" title="Edit"
                                        onclick="rlsInp('{{$value->id}}')">
                                        <i class="bx bx-edit bx-sm"></i>
                                    </button>
                                    <form action="{{url('admin/banner', $value->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger mb-1 mr-1 rounded-circle show_confirm"
                                            data-toggle="tooltip" title='Delete' type="submit"><i
                                                class="bx bx-trash bx-sm"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    var firstUpload = new FileUploadWithPreview('myFirstImage')
    createDataTable('#banner')


    function viewimage(image) {
        console.log(image)
        swal.fire({
            imageUrl: '/image/' + image,
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
            animation: false,
            padding: '2em'
        })
    }

    function rlsInp(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/admin/banner/" + id,
            method: 'get',

            success: function(result) {
                // 
                $('#formbanner').attr('action', '{{url("/update-banner")}}');
                // console.log(result);
                $("#judul").val(result.nama)
                $("#idbanner").val(id)
                $("#aktif").val(result.mulai)
                $("#type").val(result.jenis)
                $("#selesai").val(result.selesai)
                $("#urlbanner").val(result.public_id)
                $(".custom-file-container__image-preview").css("background-image", "url(/image/" + result.image + ")")

                // $("#judul").val()
            }
        });
    }
</script>
@endsection