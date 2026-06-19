@extends('layouts.compact')
@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                <h5 style="font-weight: bold;">Kategori</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal"
                    onclick="resetForm()">
                    Tambah
                </button>
            </div>
            <hr>

            <table id="invoice-list" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="checkbox-column"> No. </th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $x)
                    <tr>
                        <td class="checkbox-column"> {{ $key+1 }} </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->nama }}
                            </p>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $x->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-more-horizontal">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $x->id }}">
                                    <a class="dropdown-item action-edit" href="javascript:void(0);"
                                        onclick="editUser({{ json_encode($x) }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-3">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg> Edit
                                    </a>

                                    <form action="/kategori-materi/{{$x->id}}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item action-delete text-danger"
                                            style="border: none; background: none; width: 100%;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-trash">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                            </svg> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #fff; border-radius: 8px;">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel" style="font-weight: bold;">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="userForm" action="/kategori-materi" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div id="method-container"></div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name" style="font-weight: 600;">Nama Kategori</label>
                        <input type="text" id="nama" name="nama" class="form-control" required
                            placeholder="Masukkan nama">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi ketika tombol 'Tambah Pengguna' diklik
            function resetForm() {
                document.getElementById('id').value = '';
                document.getElementById('nama').value = '';
            }
            
            // Fungsi ketika tombol 'Edit' diklik
            function editUser(user) {
                resetForm();
                
                if (user) {
                    document.getElementById('id').value = user.id;
                    document.getElementById('nama').value = user.nama;
                }

                // Tampilkan Modal secara terprogram
                $('#userModal').modal('show');
            }
</script>
@endsection