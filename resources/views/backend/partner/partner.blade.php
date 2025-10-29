@extends('backend.template')
@section('content')
<!-- Button trigger modal -->
<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <button type="button" class="btn btn-primary btn-sm m-2" data-toggle="modal" data-target="#partnerModal">
            Tambah
        </button>
        <table id="zero-config" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Link</th>
                    <th>Image</th>
                    <th class="no-content">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $d->link }}</td>
                    <td><img src="{{ asset('Image/Partner/'.json_decode($d->image)->url) }}" alt="" width="130px">
                    </td>
                    <td><button class="btn btn-warning" id="edit" data-data="{{$d}}"><i class='bx bx-edit'></i></button>
                        <button class="btn btn-danger" onclick="hapus('{{$d->id}}')"> <i
                                class='bx bx-trash'></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="partnerModal" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="/admin/partner" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="text" name="id" id="id" hidden>
                    <div class="row m-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Link</label>
                                <textarea type="text" class="form-control" id="link"
                                    name="link">{{ old('link') }}</textarea>
                                @error('link')
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
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</span>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            <form id="form_delete" action="/admin/partner/delete" method="post">
                @csrf
                <input type="text" name="id_partner" id="id_partner" hidden>
            </form>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    var firstUpload = new FileUploadWithPreview('myFirstImage')
    createDataTable('#zero-config')
    $('#edit').click(function () {
        openmodal('#partnerModal')
        let data = JSON.parse($(this).attr('data-data'))
        $('#id').val(data['id'])
        $('#link').val(data['link'])
        document.getElementById('img_preview').style.backgroundImage="asset('Image/1666142736-1.png')"
    })
    function hapus(id) {
        $('#id_partner').val(id)
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

</script>
@endsection