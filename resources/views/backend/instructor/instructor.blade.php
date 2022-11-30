@extends('backend.beranda')
@section('content')
<div class="row layout-top-spacing">
    <!-- Button trigger modal -->
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <button type="button" class="btn btn-primary btn-sm m-2" data-toggle="modal" data-target="#instructorModal">
                Tambah
            </button>
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>Title</th>
                        <th>Deskripsi</th>
                        <th>Dokumen</th>
                        <th>Gambar</th>
                        <th class="no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr>
                        <td><span class="badge badge-{{ $d->status ? 'primary' : 'danger' }}"
                                onclick="aktifasi({{ $d }})">
                                {{ $d->status
                                ? 'Aktif'
                                : 'Tidak
                                Aktif' }}
                            </span></td>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->title }}</td>
                        <td>{{ $d->desc }}</td>
                        <td>
                            @if (json_decode($d->dokumen))
                            <a href="/getBerkas?rf={{ json_decode($d->dokumen)->url }}">Download</a>
                            @else
                            <a href="">Download</a>
                            @endif
                        </td>
                        <td>@if (json_decode($d->picture))
                            <img src="{{ asset('Image/instructor/' . $d->name . '/' . json_decode($d->picture)->url) }}"
                                alt="" width="130px">
                            @endif
                        </td>
                        <td><button class="btn btn-warning" id="edit" onclick="edit({{ $d }})" title="Edit"><i
                                    class='bx bx-edit'></i></button>
                            <button class="btn btn-danger" onclick="hapus('{{ $d->id }}')" title="Delete"> <i
                                    class='bx bx-trash'></i></button>
                            <button class="btn btn-info" onclick="login('{{ $d->id }}','{{ $d->user }}')" title="Login">
                                <i class='bx bx-log-in'></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="instructorModal" tabindex="-1" aria-labelledby="instructorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('instructor.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row m-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control" id="id" name="id" value="{{ old('id') }}"
                                        hidden>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama') }}" required>
                                    @error('nama')
                                    <span class="text-danger" role="alert">
                                        <strong>Harap Diisi</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Deskripsi</label>
                                    <textarea type="text" class="form-control" id="desc" name="desc"
                                        required>{{ old('desc') }}</textarea>
                                    @error('desc')
                                    <span class="text-danger" role="alert">
                                        <strong>Harap Diisi</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title') }}" required>
                                    @error('title')
                                    <span class="text-danger" role="alert">
                                        <strong>Harap Diisi</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Gambar (Avatar) <a href="javascript:void(0)"
                                                class="custom-file-container__image-clear"
                                                title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file">
                                            <input type="file"
                                                class="custom-file-container__custom-file__custom-file-input"
                                                accept="image/*" name="picture">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span
                                                class="custom-file-container__custom-file__custom-file-control"></span>
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
                <form id="form_delete" action="{{ route('instructor.destroy', 0) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="text" name="id_instructor" id="id_instructor" hidden>
                </form>
                <form id="form_aktif" action="{{ route('instructor.show', 0) }}">
                    @csrf
                    <input type="text" name="id_instructor_show" id="id_instructor_show" hidden>
                    <input type="text" name="id_instructor_status" id="id_instructor_status" hidden>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loginInstructorModal" tabindex="-1" aria-labelledby="loginInstructorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    Login Instructor
                </div>
                <form action="/admin/logininstructor" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <input type="text" id="idIntructor" name="idIntructor" class="form-control" hidden>
                            <input type="text" id="idUser" name="idUser" class="form-control" hidden>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        value="{{ old('password') }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    var firstUpload = new FileUploadWithPreview('myFirstImage')
        createDataTable('#zero-config')

        function login(data, user) {
            console.log(data);
            openmodal('#loginInstructorModal');
            $('#password').val(null);
            $('#idUser').val(null);
            $('#name').val(null);
            $('#email').val(null);
            $('#idIntructor').val(data);
            if (user) {
                let u = JSON.parse(user);
                $('#idUser').val(u.id);
                $('#name').val(u.name);
                $('#email').val(u.email);
            }
        }

        function edit(data) {
            openmodal('#instructorModal');
            $('#id').val(data.id)
            $('#nama').val(data.name)
            $('#title').val(data.title)
            $('#desc').val(data.desc)
            document.getElementById('img_preview').style.backgroundImage = "asset('Image/1666142736-1.png')"
        }

        function hapus(id) {
            $('#id_instructor').val(id)
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

        function aktifasi(data) {
            $('#id_instructor_show').val(data.id)
            $('#id_instructor_status').val(data.status)
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aktif',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $('#form_aktif').submit()
                }
            });
        }
</script>
@endsection