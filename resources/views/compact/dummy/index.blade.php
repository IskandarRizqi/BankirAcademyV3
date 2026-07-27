@extends('layouts.compact') {{-- Sesuaikan nama master layout Anda --}}

@section('title', 'Manajemen Notifikasi Registrasi')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row pt-3 px-3 align-items-center">
                    <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                        <h4>Data Notifikasi Pendaftaran (Fake Customer)</h4>
                        <p class="text-muted">Kelola data pendaftar acak yang muncul pada popup notifikasi halaman utama.</p>
                    </div>
                    <div class="col-xl-4 col-md-4 col-sm-4 col-4 text-right">
                        <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                            <i class="fas fa-plus mr-1"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area p-3">
                <div class="table-responsive">
                    <table id="tableRegistrations" class="table table-hover style-3" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Avatar</th>
                                <th>Nama</th>
                                <th>Kota Origin</th>
                                <th>Program Pelatihan</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ $item->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($item->name).'&background=random' }}" 
                                         class="rounded-circle" width="40" height="40" alt="Avatar">
                                </td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>{{ $item->city }}</td>
                                <td><span class="badge badge-info">{{ $item->program }}</span></td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" onclick='openEditModal(@json($item))'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('recent-registrations.destroy', $item->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
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

<!-- MODAL FORM (CREATE & EDIT) -->
<div class="modal fade" id="modalRegistration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Data Pendaftar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRegistration" action="" method="POST">
                @csrf
                <div id="methodContainer"></div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="reg_name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kota Asal <span class="text-danger">*</span></label>
                        <input type="text" name="city" id="reg_city" class="form-control" placeholder="Contoh: Jakarta" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Program Pelatihan <span class="text-danger">*</span></label>
                        <input type="text" name="program" id="reg_program" class="form-control" placeholder="Contoh: Sertifikasi Manajemen Risiko" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>URL Avatar / Foto Profil (Opsional)</label>
                        <input type="url" name="avatar_url" id="reg_avatar_url" class="form-control" placeholder="https://i.pravatar.cc/100?img=12">
                        <small class="text-muted">Kosongkan jika ingin menggunakan avatar inisial otomatis.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status Tampil</label>
                        <select name="is_active" id="reg_is_active" class="form-control">
                            <option value="1">Aktif (Ditampilkan pada Popup)</option>
                            <option value="0">Non-Aktif (Sembunyikan)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="openloading()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable menggunakan helper bawaan template Anda
        createtable('tableRegistrations');

        // SweetAlert untuk notifikasi Flash Message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });

    // Buka Modal Tambah Data
    function openCreateModal() {
        $('#modalTitle').text('Tambah Data Pendaftar');
        $('#formRegistration').attr('action', "{{ route('recent-registrations.store') }}");
        $('#methodContainer').html('');
        $('#reg_name').val('');
        $('#reg_city').val('');
        $('#reg_program').val('');
        $('#reg_avatar_url').val('');
        $('#reg_is_active').val('1');
        $('#modalRegistration').modal('show');
    }

    // Buka Modal Edit Data
    function openEditModal(data) {
        $('#modalTitle').text('Edit Data Pendaftar');
        
        let updateUrl = "{{ route('recent-registrations.update', ':id') }}";
        updateUrl = updateUrl.replace(':id', data.id);
        
        $('#formRegistration').attr('action', updateUrl);
        $('#methodContainer').html('@method("PUT")');
        
        $('#reg_name').val(data.name);
        $('#reg_city').val(data.city);
        $('#reg_program').val(data.program);
        $('#reg_avatar_url').val(data.avatar_url);
        $('#reg_is_active').val(data.is_active ? '1' : '0');
        
        $('#modalRegistration').modal('show');
    }

    // Konfirmasi Hapus Data
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e7515a',
            cancelButtonColor: '#3b3f5c',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                openloading();
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush