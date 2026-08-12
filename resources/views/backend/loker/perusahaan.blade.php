@extends('layouts.compact')

@section('content')
    <div class="container-fluid px-4 py-3">
        <!-- Header & Action Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Kelola Perusahaan & Loker</h4>
                <p class="text-muted small mb-0">Manajemen data perusahaan, lokasi, dan informasi kontak.</p>
            </div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 shadow-sm"
                onclick="openCreateModal()">
                <i class='bx bx-plus fs-5'></i>
                <span class="fw-medium">Tambah Perusahaan</span>
            </button>
        </div>

        <!-- Tabel Data Perusahaan -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="banner" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th>Logo</th>
                                <th>Perusahaan</th>
                                <th>Email</th>
                                <th>Wilayah (Provinsi / Kab / Kec / Kel)</th>
                                <th class="text-center" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $l)
                                <tr>
                                    <td class="text-center text-muted fw-semibold">{{ $key + 1 }}</td>
                                    <td>
                                        @if ($l->image)
                                            <img src="{{ asset('image/loker/' . (json_decode($l->image)->url ?? '')) }}"
                                                alt="Logo" class="rounded-3 border object-fit-cover"
                                                style="width: 48px; height: 48px;">
                                        @else
                                            <div class="bg-light text-muted rounded-3 d-flex align-items-center justify-content-center border"
                                                style="width: 48px; height: 48px;">
                                                <i class='bx bx-building fs-4'></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $l->nama }}</div>
                                        <small class="text-muted">{{ $l->alamat ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <span class="text-secondary"><i
                                                class='bx bx-envelope me-1'></i>{{ $l->email }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge bg-light text-dark border">{{ $l->provinsi_name }}</span>
                                            <span class="badge bg-light text-dark border">{{ $l->kabupaten_name }}</span>
                                            <span class="badge bg-light text-dark border">{{ $l->kecamatan_name }}</span>
                                            <span class="badge bg-light text-dark border">{{ $l->kelurahan_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-outline-warning btn-sm border-0"
                                                onclick="editloker({{ json_encode($l) }})" title="Edit">
                                                <i class='bx bx-pencil fs-5'></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm border-0"
                                                onclick="deleteLoker({{ $l->id }})" title="Hapus">
                                                <i class='bx bx-trash fs-5'></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Perusahaan / Loker -->
    <div class="modal fade" id="modalLoker" tabindex="-1" aria-labelledby="modalLokerLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalLokerLabel">Form Perusahaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/admin/perusahaan" method="POST" enctype="multipart/form-data" id="formPerusahaan">
                    @csrf
                    <input type="hidden" name="loker_id" id="loker_id" value="{{ old('loker_id') }}">
                    <div class="modal-body pt-3">
                        <div class="row g-3">
                            <!-- Logo / Gambar -->
                            <div class="col-12">
                                <label for="filClassesImage" class="form-label fw-semibold">Logo / Gambar Perusahaan</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        <img src="#" alt="Preview" id="prvClassesImage"
                                            class="rounded-3 border object-fit-cover"
                                            style="width: 70px; height: 70px; display: none;">
                                        <div id="placeholderImage"
                                            class="bg-light text-muted rounded-3 d-flex align-items-center justify-content-center border"
                                            style="width: 70px; height: 70px;">
                                            <i class='bx bx-image-add fs-2'></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="filClassesImage" id="filClassesImage"
                                            class="form-control" accept="image/*">
                                        <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Max 2MB)</small>
                                    </div>
                                </div>
                                @error('filClassesImage')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Nama Perusahaan -->
                            <div class="col-md-6">
                                <label for="loker_nama" class="form-label fw-semibold">Nama Perusahaan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="loker_nama" id="loker_nama" class="form-control"
                                    value="{{ old('loker_nama') }}" placeholder="Masukkan nama perusahaan" required>
                                @error('loker_nama')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email Perusahaan -->
                            <div class="col-md-6">
                                <label for="loker_email" class="form-label fw-semibold">Email Perusahaan <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="loker_email" id="loker_email" class="form-control"
                                    value="{{ old('loker_email') }}" placeholder="contoh@domain.com" required>
                                @error('loker_email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Cascading Dropdown Wilayah -->
                            <div class="col-md-6">
                                <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                                <select name="provinsi" id="provinsi" class="form-select select2-modal">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinsi as $v)
                                        <option value="{{ $v->id }}"
                                            {{ old('provinsi') == $v->id ? 'selected' : '' }}>
                                            {{ $v->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('provinsi')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kabupaten" class="form-label fw-semibold">Kabupaten / Kota</label>
                                <select name="kabupaten" id="kabupaten" class="form-select select2-modal">
                                    <option value="">Pilih Kabupaten</option>
                                </select>
                                @error('kabupaten')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="form-select select2-modal">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kelurahan" class="form-label fw-semibold">Kelurahan / Desa</label>
                                <select name="kelurahan" id="kelurahan" class="form-select select2-modal">
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                                @error('kelurahan')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="col-12">
                                <label for="loker_alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea name="loker_alamat" id="loker_alamat" class="form-control" rows="2"
                                    placeholder="Jalan, RT/RW, nomor gedung, dsb.">{{ old('loker_alamat') }}</textarea>
                                @error('loker_alamat')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-secondary" onclick="kosong()">Reset Form</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Tersembunyi Hapus -->
    <form action="#" method="POST" id="formdelclasses">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            createDataTable('#banner');

            // Inisialisasi Select2 khusus di dalam Modal
            $('.select2-modal').select2({
                dropdownParent: $('#modalLoker'),
                placeholder: 'Pilih...',
                allowClear: true,
                width: '100%'
            });

            // Event Listeners Cascading Dropdown
            $('#provinsi').on('change', function() {
                if ($(this).val()) {
                    getkabupaten();
                } else {
                    resetDropdown('#kabupaten');
                    resetDropdown('#kecamatan');
                    resetDropdown('#kelurahan');
                }
            });

            $('#kabupaten').on('change', function() {
                if ($(this).val()) {
                    getkecamatan();
                } else {
                    resetDropdown('#kecamatan');
                    resetDropdown('#kelurahan');
                }
            });

            $('#kecamatan').on('change', function() {
                if ($(this).val()) {
                    getkelurahan();
                } else {
                    resetDropdown('#kelurahan');
                }
            });

            // Preview Gambar
            $('#filClassesImage').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#prvClassesImage').attr('src', event.target.result).show();
                        $('#placeholderImage').hide();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Restore state modal jika ada error validasi pengiriman form (old inputs)
            let hasErrors = {{ $errors->any() ? 'true' : 'false' }};
            if (hasErrors) {
                $('#modalLoker').modal('show');

                let oldProvinsi = "{{ old('provinsi') }}";
                let oldKabupaten = "{{ old('kabupaten') }}";
                let oldKecamatan = "{{ old('kecamatan') }}";
                let oldKelurahan = "{{ old('kelurahan') }}";

                if (oldProvinsi) {
                    getkabupaten(oldKabupaten).then(function() {
                        if (oldKabupaten) {
                            getkecamatan(oldKecamatan).then(function() {
                                if (oldKecamatan) {
                                    getkelurahan(oldKelurahan);
                                }
                            });
                        }
                    });
                }
            }
        });

        function openCreateModal() {
            kosong();
            $('#modalLokerLabel').text('Tambah Perusahaan');
            $('#modalLoker').modal('show');
        }

        function resetDropdown(selector) {
            $(selector).html('<option value="">Pilih...</option>').val('').trigger('change.select2');
        }

        function getkabupaten(selectedId = null) {
            let v = $('#provinsi').val();
            if (!v) return $.Deferred().resolve().promise();

            return $.ajax({
                type: 'GET',
                url: '/admin/loker/getkabupaten/' + v,
                success: function(data) {
                    let t = '<option value="">Pilih Kabupaten</option>';
                    if (data && data.length > 0) {
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
            if (!v) return $.Deferred().resolve().promise();

            return $.ajax({
                type: 'GET',
                url: '/admin/loker/getkecamatan/' + v,
                success: function(data) {
                    let t = '<option value="">Pilih Kecamatan</option>';
                    if (data && data.length > 0) {
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
            if (!v) return $.Deferred().resolve().promise();

            return $.ajax({
                type: 'GET',
                url: '/admin/loker/getkelurahan/' + v,
                success: function(data) {
                    let t = '<option value="">Pilih Kelurahan</option>';
                    if (data && data.length > 0) {
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
            $('#placeholderImage').show();

            $('#provinsi').val('').trigger('change.select2');
            resetDropdown('#kabupaten');
            resetDropdown('#kecamatan');
            resetDropdown('#kelurahan');
        }

        function editloker(data) {
            kosong();
            $('#modalLokerLabel').text('Edit Perusahaan');

            if (data.image) {
                try {
                    let img = typeof data.image === 'string' ? JSON.parse(data.image) : data.image;
                    if (img && img.url) {
                        $('#prvClassesImage').attr('src', '/image/loker/' + img.url).show();
                        $('#placeholderImage').hide();
                    }
                } catch (e) {
                    console.error("Error parsing image JSON", e);
                }
            }

            $('#loker_alamat').val(data.alamat);
            $('#loker_email').val(data.email);
            $('#loker_nama').val(data.nama);
            $('#loker_id').val(data.id);

            $('#modalLoker').modal('show');

            // Set provinsi tanpa trigger cascading ganda
            $('#provinsi').val(data.provinsi).trigger('change.select2');

            // Promise chain berurutan mengisi dropdown turunan
            getkabupaten(data.kabupaten).then(function() {
                return getkecamatan(data.kecamatan);
            }).then(function() {
                return getkelurahan(data.kelurahan);
            });
        }

        function deleteLoker(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed || result.value) {
                    let form = $('#formdelclasses');
                    form.attr('action', '/admin/perusahaan/' + id);
                    form.submit();
                }
            });
        }
    </script>
@endsection
