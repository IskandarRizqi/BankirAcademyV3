@extends('layouts.compact')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <form action="/admin/perusahaan" method="POST" enctype="multipart/form-data" id="formPerusahaan">
                    <fieldset class="border p-2">
                        @csrf
                        <input type="hidden" name="loker_id" id="loker_id" value="{{ old('loker_id') }}">
                        <legend class="w-auto">Form Loker</legend>
                        <div class="row border-2">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="filClassesImage">Image</label>
                                    <input type="file" name="filClassesImage" id="filClassesImage" class="form-control"
                                        accept="image/*">
                                    <img src="#" alt="Image Preview" id="prvClassesImage" class="previewImage"
                                        style="max-width: 100%; max-height:97px; display:none;">
                                    @error('filClassesImage')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="loker_nama">Nama Perusahaan</label>
                                    <input type="text" name="loker_nama" id="loker_nama" class="form-control"
                                        value="{{ old('loker_nama') }}">
                                    @error('loker_nama')
                                        <small class="text-danger">Harus Diisi</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="loker_email">Email</label>
                                    <input type="email" name="loker_email" id="loker_email" class="form-control"
                                        value="{{ old('loker_email') }}">
                                    @error('loker_email')
                                        <small class="text-danger">Harus Diisi</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <select name="provinsi" id="provinsi" class="form-control" onchange="getkabupaten()">
                                        <option value="">Pilih</option>
                                        @foreach ($provinsi as $key => $v)
                                            <option value="{{ $v->id }}"
                                                {{ old('provinsi') == $v->id ? 'selected' : '' }}>
                                                {{ $v->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('provinsi')
                                        <small class="text-danger">Harus Diisi</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="kabupaten">Kabupaten</label>
                                    <select name="kabupaten" id="kabupaten" class="form-control" onchange="getkecamatan()">
                                        <option value="">Pilih</option>
                                    </select>
                                    @error('kabupaten')
                                        <small class="text-danger">Harus Diisi</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <select name="kecamatan" id="kecamatan" class="form-control" onchange="getkelurahan()">
                                        <option value="">Pilih</option>
                                    </select>
                                    @error('kecamatan')
                                        <small class="text-danger">Harus Diisi</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="kelurahan">Kelurahan</label>
                                    <select name="kelurahan" id="kelurahan" class="form-control">
                                        <option value="">Pilih</option>
                                    </select>
                                    @error('kelurahan')
                                        <small class="text-danger">Harus Diisi</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="loker_alamat">Alamat</label>
                                    <input type="text" name="loker_alamat" id="loker_alamat" class="form-control"
                                        value="{{ old('loker_alamat') }}">
                                    @error('loker_alamat')
                                        <small class="text-danger">Harus Diisi</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <button type="button" class="btn btn-secondary" id="loker_reset"
                                onclick="kosong()">Reset</button>
                            <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                        </div>
                    </fieldset>
                </form>

                <table id="banner" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Provinsi</th>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th class="dt-no-sorting text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $l)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ $l->image ? asset('image/loker/' . json_decode($l->image)->url) : '' }}"
                                        alt="" style="max-width: 100%; max-height: 90px">
                                </td>
                                <td>{{ $l->nama }}</td>
                                <td>{{ $l->email }}</td>
                                <td>{{ $l->provinsi_name }}</td>
                                <td>{{ $l->kabupaten_name }}</td>
                                <td>{{ $l->kecamatan_name }}</td>
                                <td>{{ $l->kelurahan_name }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning" onclick="editloker({{ json_encode($l) }})"
                                        title="Edit">
                                        <i class='bx bx-pencil'></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="deleteLoker({{ $l->id }})"
                                        title="Delete">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="#" method="post" id="formdelclasses">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            createDataTable('#banner');

            $('#provinsi, #kabupaten, #kecamatan, #kelurahan').select2({
                placeholder: 'Pilih Option',
                allowClear: true
            });

            $('#filClassesImage').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#prvClassesImage').attr('src', event.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });
        });

        function getkabupaten(selectedId = null) {
            let v = $('#provinsi').val();
            return $.ajax({
                type: 'GET',
                url: '/admin/loker/getkabupaten/' + v,
                success: function(data) {
                    let t = '<option value="">Pilih</option>';
                    if (data) {
                        data.forEach(el => {
                            t += `<option value="${el.id}">${el.name}</option>`;
                        });
                    }
                    $('#kabupaten').html(t).val(selectedId).trigger('change.select2');
                }
            });
        }

        function getkecamatan(selectedId = null) {
            let v = $('#kabupaten').val();
            return $.ajax({
                type: 'GET',
                url: '/admin/loker/getkecamatan/' + v,
                success: function(data) {
                    let t = '<option value="">Pilih</option>';
                    if (data) {
                        data.forEach(el => {
                            t += `<option value="${el.id}">${el.name}</option>`;
                        });
                    }
                    $('#kecamatan').html(t).val(selectedId).trigger('change.select2');
                }
            });
        }

        function getkelurahan(selectedId = null) {
            let v = $('#kecamatan').val();
            return $.ajax({
                type: 'GET',
                url: '/admin/loker/getkelurahan/' + v,
                success: function(data) {
                    let t = '<option value="">Pilih</option>';
                    if (data) {
                        data.forEach(el => {
                            t += `<option value="${el.id}">${el.name}</option>`;
                        });
                    }
                    $('#kelurahan').html(t).val(selectedId).trigger('change.select2');
                }
            });
        }

        function kosong() {
            $('#loker_id').val('');
            $('#loker_alamat, #loker_email, #loker_nama, #filClassesImage').val('');
            $('#prvClassesImage').attr('src', '#').hide();
            $('#provinsi, #kabupaten, #kecamatan, #kelurahan').val('').trigger('change.select2');
        }

        function editloker(data) {
            kosong();
            if (data.image) {
                let img = JSON.parse(data.image);
                $('#prvClassesImage').attr('src', '/image/loker/' + img.url).show();
            }
            $('#loker_alamat').val(data.alamat);
            $('#loker_email').val(data.email);
            $('#loker_nama').val(data.nama);
            $('#loker_id').val(data.id);

            $('#provinsi').val(data.provinsi).trigger('change.select2');

            // Memakai Promise chain agar tidak async-clash
            getkabupaten(data.kabupaten).then(function() {
                getkecamatan(data.kecamatan).then(function() {
                    getkelurahan(data.kelurahan);
                });
            });
        }

        function deleteLoker(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    let form = $('#formdelclasses');
                    form.attr('action', '/admin/perusahaan/' + id);
                    form.submit();
                }
            });
        }
    </script>
@endsection
