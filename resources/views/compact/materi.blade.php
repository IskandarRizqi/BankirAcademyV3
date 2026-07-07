@extends('layouts.compact')
@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                <h5 style="font-weight: bold;">Kompetensi</h5>
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
                        <th>Urutan</th>
                        <th>Nama Kompetensi</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $x)
                    <tr>
                        <td class="checkbox-column"> {{ $key+1 }} </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->kategori->nama
                                }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->urutan }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->nama }}
                            </p>
                        </td>
                        <td>
    <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> Rp {{ number_format($x->harga, 0, ',', '.') }}</p> 
</td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->keterangan }}
                            </p>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $x->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
  <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
  <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
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

                                    <form action="/materi/{{$x->id}}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item action-delete text-danger pl-3"
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
                <h5 class="modal-title" id="userModalLabel" style="font-weight: bold;">Tambah Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="userForm" action="/materi" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div id="method-container"></div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name" style="font-weight: 600;">Nama Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-control" required>
                            <option value="" disabled selected>-- Pilih --</option>
                            @foreach($kategori as $key => $v)
                            <option value="{{$v->id}}">{{$v->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="urutan" style="font-weight: 600;">Urutan</label>
                        <input type="number" min="0" name="urutan" id="urutan" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama" style="font-weight: 600;">Nama Materi</label>
                        <input type="text" min="0" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
    <label for="harga" style="font-weight: 600;">Harga</label>
    <input type="number" min="0" name="harga" id="harga" class="form-control" required>
</div>
                    <div class="form-group mb-3">
                        <label for="nama" style="font-weight: 600;">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
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
    $(document).ready(function () {
        createtable('invoice-list')

        $('#mySelect2').select2({
            dropdownParent: $('#userModal')
        });
    })
    // Fungsi ketika tombol 'Tambah Pengguna' diklik
    function resetForm() {
        document.getElementById('id').value = '';
        document.getElementById('urutan').value = 0;
        document.getElementById('nama').value = '';
        document.getElementById('harga').value = 0;
        document.getElementById('keterangan').value = '';
        document.getElementById('id_kategori').value = '';
    }

    // Fungsi ketika tombol 'Edit' diklik
    function editUser(user) {
        resetForm();

        if (user) {
            document.getElementById('id').value = user.id;
            document.getElementById('urutan').value = user.urutan;
            document.getElementById('nama').value = user.nama;
            document.getElementById('harga').value = user.harga;
            document.getElementById('keterangan').value = user.keterangan;
            document.getElementById('id_kategori').value = user.id_kategori;
        }
        // Tampilkan Modal secara terprogram
        $('#userModal').modal('show');
    }
</script>
@endsection