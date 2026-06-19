@extends('layouts.compact')

@section('content')
                
                <div class="row" id="cancel-row">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="widget-content widget-content-area br-6">
                            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                                <h5 style="font-weight: bold;">Daftar Pengguna</h5>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal" onclick="resetForm()">
                                    Tambah Pengguna
                                </button>
                            </div>
                            <hr>

                            <table id="invoice-list" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="checkbox-column"> No. </th>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $key => $user)
                                    <tr>
                                        <td class="checkbox-column"> {{ $users->firstItem() + $key }} </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="usr-img-frame mr-2 rounded-circle">
                                                    <img alt="avatar" class="img-fluid rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random">
                                                </div>
                                                <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $user->name }} </p>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="inv-email">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail mr-1"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> 
                                                {{ $user->email }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->role == 4)
                                                <span class="badge badge-success inv-status">Bank</span>
                                            @elseif($user->role == 5)
                                                <span class="badge badge-warning inv-status">Sekolah</span>
                                            @elseif($user->role == 6)
                                                <span class="badge badge-secondary inv-status">Siswa</span>
                                            @else
                                                <span class="badge badge-light inv-status">Role {{ $user->role }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $user->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $user->id }}">
                                                    <a class="dropdown-item action-edit" href="javascript:void(0);" 
                                                       onclick="editUser({{ json_encode($user) }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Edit
                                                    </a>
                                                    
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item action-delete text-danger" style="border: none; background: none; width: 100%;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Delete
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
                            
                            <div class="p-3">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="background: #fff; border-radius: 8px;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userModalLabel" style="font-weight: bold;">Tambah Pengguna</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <form id="userForm" action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div id="method-container"></div>

                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="name" style="font-weight: 600;">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control" required placeholder="Masukkan nama">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email" style="font-weight: 600;">Alamat Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required placeholder="name@example.com">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="role" style="font-weight: 600;">Role / Hak Akses</label>
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        
                                        @php
                                            $authRole = (int) auth()->user()->role;
                                            $authEmail = auth()->user()->email;
                                        @endphp

                                        @for ($i = 0; $i <= 6; $i++)
                                            {{-- Kondisi Spesifik: User Role 3 dengan Email Spesifik dapat mendaftarkan sesama Role 3 --}}
                                            @if ($authRole === 4 && $authEmail === 'cb@bankir.academy' && $i === 3)
                                                <option value="4">Bank</option>
                                            @endif

                                            {{-- Aturan Umum: Hanya menampilkan role yang bernilai angka lebih besar dari role pengakses --}}
                                            @if ($i > $authRole)
                                                <option value="{{ $i }}">
                                                    
                                                    @if($i == 4) Bank
                                                    @elseif($i == 5) Sekolah
                                                    @elseif($i == 6) Siswa
                                                    @endif
                                                </option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" style="font-weight: 600;">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                                    <small id="password-help" class="form-text text-muted d-none">Kosongkan jika tidak ingin mengubah password.</small>
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

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2026 <a target="_blank" href="https://designreset.com">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>

        <script>
            // Fungsi ketika tombol 'Tambah Pengguna' diklik
            function resetForm() {
                document.getElementById('userModalLabel').innerText = 'Tambah Pengguna';
                document.getElementById('userForm').action = "{{ route('users.store') }}";
                document.getElementById('method-container').innerHTML = ''; // Hapus @method('PUT')
                
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
                document.getElementById('role').value = ''; // Mengubah default value menjadi kosong agar kembali ke '-- Pilih Role --'
                document.getElementById('password').value = '';
                document.getElementById('password').required = true;
                document.getElementById('password-help').classList.add('d-none');
            }

            // Fungsi ketika tombol 'Edit' diklik
            function editUser(user) {
                document.getElementById('userModalLabel').innerText = 'Edit Pengguna';
                
                // Ubah Action Form menjadi route update Laravel
                let url = "{{ route('users.update', ':id') }}";
                url = url.replace(':id', user.id);
                document.getElementById('userForm').action = url;

                // Tambahkan input spoofing method PUT untuk Laravel
                document.getElementById('method-container').innerHTML = `@method('PUT')`;

                // Isi data pengguna ke dalam Form input
                document.getElementById('name').value = user.name;
                document.getElementById('email').value = user.email;
                document.getElementById('role').value = user.role;
                
                // Set password menjadi tidak wajib diisi saat edit
                document.getElementById('password').value = '';
                document.getElementById('password').required = false;
                document.getElementById('password-help').classList.remove('d-none');

                // Tampilkan Modal secara terprogram
                $('#userModal').modal('show');
            }
        </script>
@endsection