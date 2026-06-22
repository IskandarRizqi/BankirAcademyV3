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

            {{-- Modal Create / Update --}}
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
        <select id="role" name="role" class="form-control" required onchange="handleRoleChange()">
    <option value="" disabled selected>-- Pilih Role --</option>
    
    @php
        $authRole = (int) auth()->user()->role;
        $authEmail = auth()->user()->email;
    @endphp

    @for ($i = 0; $i <= 6; $i++)
        @if ($authEmail === 'cb@bankir.academy')
            @if ($i == 4 || $i == 5 || $i == 6)
                <option value="{{ $i }}">
                    @if($i == 4) Bank
                    @elseif($i == 5) Sekolah
                    @elseif($i == 6) Siswa
                    @endif
                </option>
            @endif
        @else
            @if ($i > $authRole)
                <option value="{{ $i }}">
                    @if($i == 4) Bank
                    @elseif($i == 5) Sekolah
                    @elseif($i == 6) Siswa
                    @endif
                </option>
            @endif
        @endif
    @endfor
</select>
    </div>

    <div class="form-group mb-3 d-none" id="membership-group">
        <label for="membership_id" style="font-weight: 600;">Membership (Opsional)</label>
        <select id="membership_id" name="membership_id" class="form-control">
            <option value="">-- Tanpa Membership --</option>
            @foreach($memberships as $membership)
                <option value="{{ $membership->id }}">{{ $membership->nama }} (Rp {{ number_format($membership->harga_final, 0, ',', '.') }})</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3 d-none" id="bank-group">
        <label for="bank_id" style="font-weight: 600;">Pilih Bank <span class="text-danger">*</span></label>
        <select id="bank_id" name="bank_id" class="form-control" onchange="filterSekolahByBank()">
            <option value="" selected disabled>-- Pilih Bank --</option>
            @foreach($listBank as $bank)
                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3 d-none" id="sekolah-group">
        <label for="sekolah_id" style="font-weight: 600;">Pilih Sekolah <span class="text-danger">*</span></label>
        <select id="sekolah_id" name="sekolah_id" class="form-control">
            <option value="" selected disabled>-- Pilih Sekolah --</option>
            @foreach($listSekolah as $sekolah)
                <option value="{{ $sekolah->id }}" data-bank="{{ $sekolah->bank_id }}">{{ $sekolah->name }}</option>
            @endforeach
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


<script>
    // Ambil info data login pelaksana dari php ke javascript variable
    const AUTH_ROLE = parseInt("{{ $authRole }}");
    const AUTH_EMAIL = "{{ $authEmail }}";

    // Fungsi memunculkan form spesifik berdasarkan role yang dipilih dan hak login saat ini
    function handleRoleChange() {
        let role = document.getElementById('role').value;
        
        let membershipGroup = document.getElementById('membership-group');
        let bankGroup = document.getElementById('bank-group');
        let sekolahGroup = document.getElementById('sekolah-group');

        // Reset display & required attribute
        membershipGroup.classList.add('d-none');
        bankGroup.classList.add('d-none');
        sekolahGroup.classList.add('d-none');
        
        document.getElementById('bank_id').required = false;
        document.getElementById('sekolah_id').required = false;

        // LOGIKA BARU BERDASARKAN FILTER LOGIN:
        if (role == "4") { 
            // Jika memilih membuat Bank
            membershipGroup.classList.remove('d-none');
        } 
        else if (role == "5") { 
            // Jika memilih membuat Sekolah
            if (AUTH_EMAIL === 'cb@bankir.academy') {
                // Hanya root utama yang wajib memilih Bank pembina
                bankGroup.classList.remove('d-none');
                document.getElementById('bank_id').required = true;
            }
            // Jika yang login adalah Bank biasa, Bank group disembunyikan (Otomatis mengikat di backend)
        } 
        else if (role == "6") { 
            // Jika memilih membuat Siswa
            if (AUTH_EMAIL === 'cb@bankir.academy') {
                // Root wajib pilih bank dan pilih sekolah
                bankGroup.classList.remove('d-none');
                sekolahGroup.classList.remove('d-none');
                document.getElementById('bank_id').required = true;
                document.getElementById('sekolah_id').required = true;
            } else if (AUTH_ROLE === 4) {
                // Jika Bank yang login: tidak perlu pilih Bank, tapi WAJIB pilih Sekolah
                sekolahGroup.classList.remove('d-none');
                document.getElementById('sekolah_id').required = true;
            }
            // Jika Sekolah yang login: tidak perlu pilih Bank maupun Sekolah (Otomatis mengikat di backend)
        }
    }

    // Fungsi menyaring daftar sekolah berdasarkan Bank yang dipilih (untuk pendaftaran Siswa oleh root)
    function filterSekolahByBank() {
        let selectedBankId = document.getElementById('bank_id').value;
        let sekolahSelect = document.getElementById('sekolah_id');
        let options = sekolahSelect.options;

        // Reset pilihan sekolah ke default awal
        sekolahSelect.value = "";

        for (let i = 0; i < options.length; i++) {
            let option = options[i];
            let bankRelation = option.getAttribute('data-bank');

            if (option.value === "") continue; 

            if (bankRelation == selectedBankId) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    // Fungsi ketika tombol 'Tambah Pengguna' diklik
    function resetForm() {
        document.getElementById('userModalLabel').innerText = 'Tambah Pengguna';
        document.getElementById('userForm').action = "{{ route('users.store') }}";
        document.getElementById('method-container').innerHTML = ''; 
        
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('role').value = ''; 
        document.getElementById('membership_id').value = ''; 
        document.getElementById('bank_id').value = ''; 
        document.getElementById('sekolah_id').value = ''; 
        
        document.getElementById('password').value = '';
        document.getElementById('password').required = true;
        document.getElementById('password-help').classList.add('d-none');

        handleRoleChange();
    }

    // Fungsi ketika tombol 'Edit' diklik
    function editUser(user) {
        document.getElementById('userModalLabel').innerText = 'Edit Pengguna';
        
        let url = "{{ route('users.update', ':id') }}";
        url = url.replace(':id', user.id);
        document.getElementById('userForm').action = url;

        document.getElementById('method-container').innerHTML = `@method('PUT')`;

        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
        
        // Panggil handler agar form input relasi disesuaikan tipenya terlebih dahulu
        handleRoleChange();

        // Masukkan data relasi jika tersedia saat edit data dilakukan
        if(user.role == 4) {
            document.getElementById('membership_id').value = user.membership_id ?? '';
        } else if(user.role == 5) {
            if(document.getElementById('bank_id')) {
                document.getElementById('bank_id').value = user.bank_id ?? '';
            }
        } else if(user.role == 6) {
            if(document.getElementById('bank_id')) {
                document.getElementById('bank_id').value = user.bank_id ?? '';
                filterSekolahByBank();
            }
            if(document.getElementById('sekolah_id')) {
                document.getElementById('sekolah_id').value = user.sekolah_id ?? '';
            }
        }
        
        document.getElementById('password').value = '';
        document.getElementById('password').required = false;
        document.getElementById('password-help').classList.remove('d-none');

        $('#userModal').modal('show');
    }
</script>
@endsection