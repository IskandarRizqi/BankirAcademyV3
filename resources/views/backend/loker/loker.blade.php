@extends('layouts.compact')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Manajemen Lowongan Kerja</h5>
                <button type="button" class="btn btn-primary" onclick="tambahLoker()">
                    <i class="fa fa-plus mr-1"></i> Tambah Loker
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="banner" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Expirasi</th>
                                <th>Image</th>
                                <th>Perusahaan</th>
                                <th>Title</th>
                                <th>Gaji</th>
                                <th>Status</th>
                                <th class="dt-no-sorting text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableloker"></tbody>
                    </table>
                </div>
            </div>

            <!-- Form Delete Tersembunyi -->
            <form action="#" method="POST" id="formdelclasses">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <!-- Modal Form Loker -->
    <div class="modal fade" id="modalLoker" tabindex="-1" role="dialog" aria-labelledby="modalLokerTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.loker.store') }}" method="POST" enctype="multipart/form-data" id="formLoker">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLokerTitle">Tambah Lowongan Kerja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="loker_id" id="loker_id">

                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="perusahaan_id">Perusahaan <span class="text-danger">*</span></label>
                                    <select name="perusahaan_id" id="perusahaan_id" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Pilih Perusahaan</option>
                                        @if ($perusahaan)
                                            @foreach ($perusahaan as $va)
                                                <option value="{{ $va->id }}">{{ $va->nama }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="loker_title">Judul Loker <span class="text-danger">*</span></label>
                                    <input type="text" name="loker_title" id="loker_title" class="form-control"
                                        placeholder="Contoh: Senior Laravel Developer" required>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="loker_gaji_min">Minimal Gaji</label>
                                    <input type="text" name="loker_gaji_min" id="loker_gaji_min" class="form-control"
                                        placeholder="Contoh: 5000000">
                                </div>
                            </div>

                            <input type="hidden" name="loker_gaji_max" id="loker_gaji_max">

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="loker_deskripsi">Deskripsi</label>
                                    <textarea name="loker_deskripsi" id="loker_deskripsi" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="loker_jobdesk">Jobdesk</label>
                                    <textarea name="loker_jobdesk" id="loker_jobdesk" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="loker_tanggal_awal">Tanggal Awal <span class="text-danger">*</span></label>
                                    <input type="date" name="loker_tanggal_awal" id="loker_tanggal_awal"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-3 mb-3">
                                <div class="form-group">
                                    <label for="loker_tanggal_akhir">Tanggal Akhir <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="loker_tanggal_akhir" id="loker_tanggal_akhir"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-2 mb-3">
                                <div class="form-group">
                                    <label for="loker_skill">Skill</label>
                                    <select name="loker_skill[]" id="loker_skill" class="form-control select2" multiple
                                        style="width: 100%;">
                                        @if ($lokerskill && isset($lokerskill[0]))
                                            @foreach (json_decode($lokerskill[0]) as $va)
                                                <option value="{{ $va }}">{{ $va }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 mb-3">
                                <div class="form-group">
                                    <label for="loker_type">Tipe Kerjaan</label>
                                    <select name="loker_type[]" id="loker_type" class="form-control select2" multiple
                                        style="width: 100%;">
                                        @if ($lokertype && isset($lokertype[0]))
                                            @foreach (json_decode($lokertype[0]) as $val)
                                                <option value="{{ $val }}">{{ $val }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 mb-3">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="1">ACC</option>
                                        <option value="0">Tidak ACC</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        var loker_deskripsi = CKEDITOR.replace("loker_deskripsi");
        var loker_jobdesk = CKEDITOR.replace("loker_jobdesk");

        $(document).ready(function() {
            gawetable();

            // Inisialisasi Select2 di dalam Modal agar tidak konflik dengan Z-Index Modal
            $('#perusahaan_id').select2({
                dropdownParent: $('#modalLoker'),
                placeholder: 'Pilih Perusahaan'
            });
            $('#loker_skill').select2({
                dropdownParent: $('#modalLoker'),
                placeholder: 'Pilih Skill',
                tags: true
            });
            $('#loker_type').select2({
                dropdownParent: $('#modalLoker'),
                placeholder: 'Pilih Tipe',
                tags: true
            });
        });

        function gawetable() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#banner').DataTable({
                processing: true,
                serverSide: false,
                destroy: true,
                ajax: "/admin/loker?tanggal_akhir=24",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'e_tanggal_akhir',
                        name: 'Tanggal'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var imgUrl = row.e_gambar ? '/image/loker/' + row.e_gambar :
                                '/image/default.png';
                            return '<img src="' + imgUrl +
                                '" style="max-width: 100px; max-height: 70px;" class="img-thumbnail">';
                        }
                    },
                    {
                        data: 'name',
                        name: 'Nama'
                    },
                    {
                        data: 'title',
                        name: 'Title'
                    },
                    {
                        data: 'e_gaji',
                        name: 'Gaji'
                    },
                    {
                        data: 'e_status',
                        name: 'Status'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                scrollX: true,
            });
        }

        function kosong() {
            $('#loker_id').val('');
            $('#loker_title').val('');
            $('#loker_gaji_min').val('');
            $('#loker_gaji_max').val('');
            $('#loker_tanggal_awal').val('');
            $('#loker_tanggal_akhir').val('');

            if (typeof loker_deskripsi !== 'undefined') loker_deskripsi.setData('');
            if (typeof loker_jobdesk !== 'undefined') loker_jobdesk.setData('');

            $('#loker_skill').val([]).trigger('change');
            $('#loker_type').val([]).trigger('change');
            $('#perusahaan_id').val('').trigger('change');
            $('#status').val('');
        }

        function tambahLoker() {
            kosong();
            $('#modalLokerTitle').text('Tambah Lowongan Kerja');
            $('#modalLoker').modal('show');
        }

        function editloker(id) {
            kosong();
            $('#modalLokerTitle').text('Edit Lowongan Kerja');

            $.ajax({
                type: 'GET',
                url: '{{ url('/admin/loker') }}/' + id,
                success: function(data) {
                    $('#status').val(data.status);
                    $('#loker_id').val(data.id);
                    $('#loker_title').val(data.title);
                    $('#loker_gaji_min').val(data.gaji_min);
                    $('#loker_gaji_max').val(data.gaji_max);

                    if (typeof loker_deskripsi !== 'undefined') {
                        loker_deskripsi.setData(data.deskripsi || '');
                    }
                    if (typeof loker_jobdesk !== 'undefined') {
                        loker_jobdesk.setData(data.jobdesk || '');
                    }

                    $('#loker_tanggal_awal').val(data.tanggal_awal);
                    $('#loker_tanggal_akhir').val(data.tanggal_akhir);

                    if (data.skill) {
                        try {
                            $('#loker_skill').val(JSON.parse(data.skill)).trigger('change');
                        } catch (e) {
                            $('#loker_skill').val(data.skill).trigger('change');
                        }
                    }
                    if (data.type) {
                        try {
                            $('#loker_type').val(JSON.parse(data.type)).trigger('change');
                        } catch (e) {
                            $('#loker_type').val(data.type).trigger('change');
                        }
                    }

                    if (data.perusahaan_id) {
                        $('#perusahaan_id').val(data.perusahaan_id).trigger('change');
                    }

                    $('#modalLoker').modal('show');
                }
            });
        }

        function deleteLoker(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                padding: '2em'
            }).then(function(result) {
                if (result.isConfirmed) {
                    var form = $('#formdelclasses');
                    form.attr('action', '{{ url('/admin/loker') }}/' + id);
                    form.submit();
                }
            });
        }
    </script>
@endsection
