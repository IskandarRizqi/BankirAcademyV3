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
                   <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-2">
    <div>
        <h5 class="mb-1" style="font-weight: 700; color: #3b3f5c;">Daftar Pengguna</h5>
        <p class="text-muted small mb-0">Kelola data pengguna, hak akses, dan pengiriman akun siswa.</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        @if(auth()->user()->email === 'cb@bankir.academy' || in_array(auth()->user()->role, [4, 5]))
            <a href="{{ route('users.download-template') }}" class="btn btn-outline-info d-flex align-items-center rounded-pill px-3 shadow-sm mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Template Excel
            </a>
            <button type="button" class="btn btn-outline-success d-flex align-items-center rounded-pill px-3 shadow-sm mr-2" data-toggle="modal" data-target="#importModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus mr-2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                Import Siswa
            </button>
        @endif
        <button type="button" class="btn btn-primary d-flex align-items-center rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#userModal" onclick="resetForm()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Pengguna
        </button>
    </div>
</div>

<hr class="mx-4 my-2" style="border-top: 1px solid #e0e6ed;">

<div class="table-responsive px-4 py-2">
    <table id="user-list" class="table table-hover custom-table align-middle" style="width:100%">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">
                    <div class="custom-control custom-checkbox d-inline-block">
                        <input type="checkbox" class="custom-control-input" id="check-all-users">
                        <label class="custom-control-label" for="check-all-users"></label>
                    </div>
                </th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $key => $user)
            <tr class="user-row">
                <td class="text-center">
                    @if($user->role == 6 && isset($user->siswa->nisn))
                        <div class="custom-control custom-checkbox d-inline-block">
                            <input type="checkbox" class="custom-control-input user-checkbox" id="check-user-{{ $user->id }}" value="{{ $user->id }}">
                            <label class="custom-control-label" for="check-user-{{ $user->id }}"></label>
                        </div>
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-wrapper mr-3">
                            <img alt="avatar" class="rounded-circle shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=40" width="40" height="40">
                        </div>
                        <div>
                            <p class="mb-0 font-weight-bold text-dark user-name-text">{{ $user->name }}</p>
                            @if($user->role == 6 && isset($user->siswa->nisn))
                                <span class="badge badge-light-secondary text-muted small px-2 py-0">NISN: {{ $user->siswa->nisn }}</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center text-muted small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail mr-2 text-primary"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        {{ $user->email }}
                    </div>
                </td>
                <td>
                    @if($user->role == 4)
                        <span class="badge badge-pill text-success bg-light-success px-3 py-1 font-weight-bold">Bank</span>
                    @elseif($user->role == 5)
                        <span class="badge badge-pill text-warning bg-light-warning px-3 py-1 font-weight-bold">Sekolah</span>
                    @elseif($user->role == 6)
                        <span class="badge badge-pill text-secondary bg-light-secondary px-3 py-1 font-weight-bold">Siswa</span>
                    @else
                        <span class="badge badge-pill text-dark bg-light px-3 py-1">Role {{ $user->role }}</span>
                    @endif
                </td>
                <td class="text-right">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-link text-muted p-0 dropdown-toggle no-caret" type="button" id="dropdownMenuLink{{ $user->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </button>
                        
                        <div class="dropdown-menu dropdown-menu-right shadow border-0 py-2 animated font-small" aria-labelledby="dropdownMenuLink{{ $user->id }}">
                            @if($user->role == 6 && isset($user->siswa->nisn))
                                <a class="dropdown-item py-2 text-warning font-weight-500 btn-single-wa" href="javascript:void(0);" data-id="{{ $user->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle mr-2 text-warning"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg> 
                                    Kirim Akun ke WA
                                </a>
                                <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item py-2" href="javascript:void(0);" onclick="viewUser({{ json_encode($user->load(['siswa', 'membership', 'bank', 'sekolah'])) }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye mr-2 text-info"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Lihat Profile
                            </a>
                            <a class="dropdown-item py-2" href="javascript:void(0);" onclick="editUser({{ json_encode($user->load('siswa')) }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit mr-2 text-primary"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> Edit
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="dropdown-item py-2 text-danger btn-delete-user" data-name="{{ $user->name }}" style="border: none; background: none; width: 100%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash mr-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Hapus Pengguna
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="mb-3 opacity-50" alt="empty">
                    <p class="mb-0 font-weight-bold">Tidak ada data pengguna ditemukan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODERN UI: Floating Action Bar untuk Bulk Mode --}}
<div id="floating-bulk-bar" class="floating-bulk-bar d-none">
    <div class="d-flex align-items-center justify-content-between w-100 container-fluid">
        <div class="text-white">
            <span class="badge badge-dark mr-2 id-count-badge" id="selected-count-floating">0</span> 
            Siswa terpilih untuk pengiriman WhatsApp.
        </div>
        <div class="d-flex gap-2">
            <button type="button" id="btn-cancel-bulk" class="btn btn-sm btn-outline-light rounded-pill px-3 mr-2">Batal</button>
            <button type="button" id="btn-bulk-whatsapp-floating" class="btn btn-sm btn-warning rounded-pill px-4 font-weight-bold text-dark d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send mr-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                Kirim Massal Ke WA
            </button>
        </div>
    </div>
</div>
                        </div>
                    </div>

                </div>
                <div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">Detail Profil Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img id="view-avatar" src="" alt="avatar" class="rounded-circle img-fluid" style="width: 100px; height: 100px;">
                    <h4 class="mt-2 mb-0" id="view-name">-</h4>
                    <span class="badge" id="view-role-badge">-</span>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Email</th>
                        <td id="view-email">-</td>
                    </tr>
                    <tr>
                        <th>Membership</th>
                        <td id="view-membership">-</td>
                    </tr>
                    <tr class="siswa-field">
                        <th>NISN</th>
                        <td id="view-nisn">-</td>
                    </tr>
                    <tr class="siswa-field">
                        <th>Kelas</th>
                        <td id="view-kelas">-</td>
                    </tr>
                    <tr class="siswa-field">
                        <th>Jenis Kelamin</th>
                        <td id="view-jk">-</td>
                    </tr>
                    <tr class="siswa-field">
                        <th>No. Telepon</th>
                        <td id="view-telp">-</td>
                    </tr>
                    <tr class="siswa-field">
                        <th>Tahun Angkatan</th>
                        <td id="view-angkatan">-</td>
                    </tr>
                    <tr class="siswa-field">
                        <th>Status Beasiswa</th>
                        <td id="view-beasiswa">-</td>
                    </tr>
                    <tr id="row-sekolah">
                        <th>Asal Sekolah</th>
                        <td id="view-sekolah-induk">-</td>
                    </tr>
                    <tr id="row-bank">
                        <th>Bank Pengampu</th>
                        <td id="view-bank-induk">-</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

            {{-- Modal Create / Update --}}
{{-- Modal Create / Update --}}
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"> {{-- Menggunakan modal-lg agar saat grid aktif tidak terasa sesak --}}
        <div class="modal-content" style="background: #fff; border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            
            {{-- Header Modal --}}
            <div class="modal-header d-flex align-items-center" style="border-bottom: 1px solid #f1f2f3; padding: 20px 24px;">
                <h5 class="modal-title" id="userModalLabel" style="font-weight: 700; color: #3b3f5c; font-size: 1.15rem; margin: 0;">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 0; margin: 0; color: #888ea8; opacity: 0.8;">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <form id="userForm" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div id="method-container"></div>

                <div class="modal-body" style="padding: 24px; max-height: calc(100vh - 200px); overflow-y: auto;">
                     <div class="alert alert-light-info d-none mb-4 p-3 d-flex align-items-start" id="siswa-account-info" style="background-color: #f0f8ff; border: 1px dashed #b8daff; border-radius: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 mt-1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        <div style="font-size: 13px; color: #004085;">
                            <strong style="display:block; margin-bottom: 4px;">Informasi Pembuatan Akun Siswa:</strong>
                            <div class="row mt-2">
                                <div class="col-sm-6">Email Login: <code id="info-email" style="font-weight: 600; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid #d6e9c6;">[nisn]@gmail.com</code></div>
                                <div class="col-sm-6">Password Login: <code id="info-password" style="font-weight: 600; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid #d6e9c6;">[nisn]Bankir!</code></div>
                            </div>
                        </div>
                    </div>
                    {{-- SECTION 1: INFORMASI UTAMA / UTAMA AKUN --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="name" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control style-input" required placeholder="Masukkan nama lengkap" style="border-radius: 6px;">
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="role" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Role / Hak Akses <span class="text-danger">*</span></label>
                            <select id="role" name="role" class="form-control style-input" required onchange="handleRoleChange()" style="border-radius: 6px;">
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
                    </div>

                    {{-- FIELD EMAIL & PASSWORD (UNTUK NON-SISWA) --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3" id="email-group">
                            <label for="email" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control style-input" required placeholder="name@example.com" style="border-radius: 6px;">
                        </div>

                        <div class="col-md-6 form-group mb-3" id="password-group">
                            <label for="password" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control style-input" placeholder="Minimal 8 karakter" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" type="button" id="togglePassword" onclick="togglePasswordVisibility()" style="border: 1px solid #ced4da; border-left: none; border-top-right-radius: 6px; border-bottom-right-radius: 6px; background: #f8f9fa; px: 12px;">
                                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#515365" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>
                                </div>
                            </div>
                            <small id="password-help" class="form-text text-muted d-none mt-1">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                    </div>

                    {{-- BOX INFO OTOMATIS GENERATE (KHUSUS SISWA) --}}
                   

                    {{-- FIELD DINAMIS ROLE: BANK & SEKOLAH --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3 d-none" id="membership-group">
                            <label for="membership_id" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Membership (Opsional)</label>
                            <select id="membership_id" name="membership_id" class="form-control style-input" style="border-radius: 6px;">
                                <option value="">-- Tanpa Membership --</option>
                                @foreach($memberships as $membership)
                                    <option value="{{ $membership->id }}">{{ $membership->nama }} (Rp {{ number_format($membership->harga_final, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3 d-none" id="masa-aktif-group">
                            <label for="masa_aktif_member" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Masa Aktif Member <span class="text-danger">*</span></label>
                            <input type="date" id="masa_aktif_member" name="masa_aktif_member" class="form-control style-input" style="border-radius: 6px;">
                        </div>

                        <div class="col-md-6 form-group mb-3 d-none" id="bank-group">
                            <label for="bank_id" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Pilih Bank <span class="text-danger">*</span></label>
                            <select id="bank_id" name="bank_id" class="form-control style-input" onchange="filterSekolahByBank()" style="border-radius: 6px;">
                                <option value="" selected disabled>-- Pilih Bank --</option>
                                @foreach($listBank as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3 d-none" id="sekolah-group">
                            <label for="sekolah_id" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Pilih Sekolah <span class="text-danger">*</span></label>
                            <select id="sekolah_id" name="sekolah_id" class="form-control style-input" style="border-radius: 6px;">
                                <option value="" selected disabled>-- Pilih Sekolah --</option>
                                @foreach($listSekolah as $sekolah)
                                    <option value="{{ $sekolah->id }}" data-bank="{{ $sekolah->bank_id }}">{{ $sekolah->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- SECTION 2: FIELD TAMBAHAN KHUSUS PROFILE SISWA --}}
                    <div id="siswa-profile-group" class="d-none mt-3 pt-3" style="border-top: 1px dashed #e0e6ed;">
                        <p class="mb-3" style="font-weight: 700; font-size: 14px; color: #1b55e2; text-transform: uppercase; letter-spacing: 0.5px;">Data Profil Siswa</p>
                        
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="email_pribadi" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Email Pribadi Siswa</label>
                                <input type="email" id="email_pribadi" name="email_pribadi" class="form-control style-input" placeholder="siswa@example.com" style="border-radius: 6px;">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="nisn" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">NISN <span class="text-danger">*</span></label>
                                <input type="text" id="nisn" name="nisn" class="form-control style-input" placeholder="Masukkan NISN" oninput="updateSiswaInfoPreview()" style="border-radius: 6px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="kelas" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Kelas</label>
                                <input type="text" id="kelas" name="kelas" class="form-control style-input" placeholder="Contoh: XII RPL 1" style="border-radius: 6px;">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="jenis_kelamin" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control style-input" style="border-radius: 6px;">
                                    <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="no_telp" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">No. Telepon / WhatsApp</label>
                                <input type="text" id="no_telp" name="no_telp" class="form-control style-input" placeholder="08xxxxxxxxxx" style="border-radius: 6px;">
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="beasiswa" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Status Beasiswa</label>
                                <select id="beasiswa" name="beasiswa" class="form-control style-input" style="border-radius: 6px;">
                                    <option value="0">Tidak (Siswa Reguler)</option>
                                    <option value="1">Ya (Penerima Beasiswa)</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="angkatan" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Tahun Angkatan</label>
                                <input type="number" id="angkatan" name="angkatan" class="form-control style-input" placeholder="2023" style="border-radius: 6px;">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat" style="font-weight: 600; color: #3b3f5c; font-size: 13px;">Alamat Rumah</label>
                            <textarea id="alamat" name="alamat" class="form-control style-input" rows="2" placeholder="Masukkan alamat lengkap tempat tinggal" style="border-radius: 6px; resize: none;"></textarea>
                        </div>
                    </div>

                </div>

                {{-- Footer Modal --}}
                <div class="modal-footer" style="border-top: 1px solid #f1f2f3; padding: 16px 24px;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="font-weight: 600; padding: 8px 20px; border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="font-weight: 600; padding: 8px 24px; border-radius: 6px; background-color: #1b55e2; border-color: #1b55e2;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Import Excel Dinamis --}}
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #fff; border-radius: 8px;">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel" style="font-weight: bold;">Import Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <p class="mb-1"><strong>Informasi Sistem:</strong></p>
                        <ul class="pl-3 mb-0" style="font-size: 13px;">
                            <li>Gunakan file template yang telah disediakan.</li>
                        <li>Email siswa otomatis: <code>[NISN]@gmail.com</code></li>
                            <li>Password siswa otomatis: <code>[NISN]Bankir!</code></li>
                        </ul>
                    </div>

                    @php
                        $authRole = (int) auth()->user()->role;
                        $authEmail = auth()->user()->email;
                    @endphp

                    {{-- Jika yang login ROOT utama, tampilkan opsi pilih Bank --}}
                    @if ($authEmail === 'cb@bankir.academy')
                        <div class="form-group mb-3">
                            <label for="import_bank_id" style="font-weight: 600;">Pilih Bank Tujuan <span class="text-danger">*</span></label>
                            <select id="import_bank_id" name="import_bank_id" class="form-control" required onchange="filterSekolahImport()">
                                <option value="" selected disabled>-- Pilih Bank --</option>
                                @foreach($listBank as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Jika yang login ROOT atau BANK, wajib memilih Sekolah --}}
                    @if ($authEmail === 'cb@bankir.academy' || $authRole === 4)
                        <div class="form-group mb-3">
                            <label for="import_sekolah_id" style="font-weight: 600;">Pilih Sekolah Tujuan <span class="text-danger">*</span></label>
                            <select id="import_sekolah_id" name="import_sekolah_id" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Sekolah --</option>
                                @foreach($listSekolah as $sekolah)
                                    <option value="{{ $sekolah->id }}" data-bank="{{ $sekolah->bank_id }}">{{ $sekolah->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="file_excel" style="font-weight: 600;">Pilih File Excel (.xlsx / .xls)</label>
                        <input type="file" id="file_excel" name="file_excel" class="form-control" required accept=".xlsx, .xls">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Proses Import</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Ambil info data login pelaksana dari php ke javascript variable
    const AUTH_ROLE = parseInt("{{ $authRole }}");
    const AUTH_EMAIL = "{{ $authEmail }}";

    $(document).ready(function() {
        createtable('user-list')
        const deleteButtons = document.querySelectorAll('.btn-delete-user');
        const checkAll = document.getElementById('check-all-users');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    const floatingBar = document.getElementById('floating-bulk-bar');
    const floatingCount = document.getElementById('selected-count-floating');
    const btnCancelBulk = document.getElementById('btn-cancel-bulk');
    const btnBulkWaFloating = document.getElementById('btn-bulk-whatsapp-floating');

    function updateFloatingBar() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        if (checkedCount > 0) {
            floatingCount.textContent = checkedCount;
            floatingBar.classList.remove('d-none');
        } else {
            floatingBar.classList.add('d-none');
            if (checkAll) checkAll.checked = false;
        }
    }

    // Toggle Semua Checkbox
    if(checkAll) {
        checkAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateFloatingBar();
        });
    }

    // Toggle Satuan Checkbox
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            if (!this.checked && checkAll) checkAll.checked = false;
            if (document.querySelectorAll('.user-checkbox:checked').length === checkboxes.length && checkAll) {
                checkAll.checked = true;
            }
            updateFloatingBar();
        });
    });

    // Tombol Batal Massal
    if(btnCancelBulk) {
        btnCancelBulk.addEventListener('click', function() {
            checkboxes.forEach(cb => cb.checked = false);
            updateFloatingBar();
        });
    }

    // Eksekusi Massal via Floating Bar
    if(btnBulkWaFloating) {
        btnBulkWaFloating.addEventListener('click', function () {
            const selectedIds = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
            sendWhatsappRequest(selectedIds);
        });
    }

    // Eksekusi Satuan via Dropdown Menu
    document.querySelectorAll('.btn-single-wa').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            sendWhatsappRequest([userId]);
        });
    });

    // Template Engine SweetAlert dengan Tema Lebih Elegan
    function sendWhatsappRequest(ids) {
        Swal.fire({
            title: 'Kirim Informasi Akun?',
            text: `Sistem akan mengirim detail login otomatis WhatsApp untuk ${ids.length} siswa terpilih.`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#e7515a',
            confirmButtonText: 'Ya, Kirim Sekarang',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-primary rounded-pill px-4',
                cancelButton: 'btn btn-danger rounded-pill px-4 ml-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Sedang Memproses Api...',
                    text: 'Mengirim notifikasi via Fonnte.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch("{{ route('users.send-bulk-wa') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ user_ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            title: 'Terkirim!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#4361ee'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', data.message || 'Error antrean Fonnte API.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Koneksi Gagal!', 'Terjadi kendala jaringan dengan server.', 'error');
                });
            }
        });
    }
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const form = this.closest('.form-delete');
            const userName = this.getAttribute('data-name');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan menghapus pengguna "${userName}". Tindakan ini juga akan menghapus seluruh data profil siswa yang terkait secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e7515a', // Warna merah bootstrap / menyesuaikan tema
                cancelButtonColor: '#9097a7',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Jalankan submit form jika user klik Ya
                }
            });
        });
    });

    // Opsional: Tampilkan SweetAlert sukses jika proses berhasil (mengambil dari session flash Laravel)
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    });

    // Fungsi memunculkan form spesifik berdasarkan role yang dipilih dan hak login saat ini
    function viewUser(user) {
    // 1. Isi Data Dasar
    document.getElementById('view-avatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random`;
    document.getElementById('view-name').innerText = user.name;
    document.getElementById('view-email').innerText = user.email;
    document.getElementById('view-membership').innerText = user.membership ? user.membership.nama : 'Tidak Ada';

    // 2. Set Badge & Atur Tampilan Berdasarkan Role
    const roleBadge = document.getElementById('view-role-badge');
    const siswaFields = document.querySelectorAll('.siswa-field');
    const rowSekolah = document.getElementById('row-sekolah');
    const rowBank = document.getElementById('row-bank');

    // Reset default display
    roleBadge.className = 'badge ';
    siswaFields.forEach(f => f.style.display = 'none');
    rowSekolah.style.display = 'none';
    rowBank.style.display = 'none';

    if (user.role == 4) {
        roleBadge.innerText = 'Bank';
        roleBadge.classList.add('badge-success');
    } else if (user.role == 5) {
        roleBadge.innerText = 'Sekolah';
        roleBadge.classList.add('badge-warning');
        // Tampilkan Bank yang mengampu sekolah ini (jika ada)
        if (user.bank) {
            rowBank.style.display = '';
            document.getElementById('view-bank-induk').innerText = user.bank.name;
        }
    } else if (user.role == 6) {
        roleBadge.innerText = 'Siswa';
        roleBadge.classList.add('badge-secondary');
        
        // Tampilkan field khusus siswa
        siswaFields.forEach(f => f.style.display = '');
        
        // Isi data profil siswa
        if (user.siswa) {
            document.getElementById('view-nisn').innerText = user.siswa.nisn || '-';
            document.getElementById('view-kelas').innerText = user.siswa.kelas || '-';
            document.getElementById('view-jk').innerText = user.siswa.jenis_kelamin === 'L' ? 'Laki-laki' : (user.siswa.jenis_kelamin === 'P' ? 'Perempuan' : '-');
            document.getElementById('view-telp').innerText = user.siswa.no_telp || '-';
            document.getElementById('view-angkatan').innerText = user.siswa.angkatan || '-';
            document.getElementById('view-beasiswa').innerText = user.siswa.beasiswa ? 'Ya (Penerima Beasiswa)' : 'Tidak';
        } else {
            document.getElementById('view-nisn').innerText = 'Profil belum dilengkapi';
            // ... reset sisanya ke strip jika profile null
        }

        // Tampilkan Sekolah & Bank asal siswa tersebut
        if (user.sekolah) {
            rowSekolah.style.display = '';
            document.getElementById('view-sekolah-induk').innerText = user.sekolah.name;
        }
        if (user.bank) {
            rowBank.style.display = '';
            document.getElementById('view-bank-induk').innerText = user.bank.name;
        }
    } else {
        roleBadge.innerText = 'Role ' + user.role;
        roleBadge.classList.add('badge-light');
    }

    // 3. Tampilkan Modal
    $('#viewUserModal').modal('show');
}
   function handleRoleChange() {
    let role = document.getElementById('role').value;
    
    let membershipGroup = document.getElementById('membership-group');
    let bankGroup = document.getElementById('bank-group');
    let sekolahGroup = document.getElementById('sekolah-group');
    let masaAktifGroup = document.getElementById('masa-aktif-group');
    let siswaProfileGroup = document.getElementById('siswa-profile-group');
    
    // Element baru untuk kontrol visibilitas Akun & Info Siswa
    let emailGroup = document.getElementById('email-group');
    let passwordGroup = document.getElementById('password-group');
    let siswaAccountInfo = document.getElementById('siswa-account-info');

    let emailInput = document.getElementById('email');
    let passwordInput = document.getElementById('password');

    // Reset display & required attribute (Default semua muncul)
    membershipGroup.classList.add('d-none');
    bankGroup.classList.add('d-none');
    sekolahGroup.classList.add('d-none');
    masaAktifGroup.classList.add('d-none');
    siswaProfileGroup.classList.add('d-none');
    
    // Tampilkan kembali group email & password, sembunyikan info akun siswa
    emailGroup.classList.remove('d-none');
    passwordGroup.classList.remove('d-none');
    siswaAccountInfo.classList.add('d-none');
    
    // Kembalikan ke default enabled & required
    emailInput.disabled = false;
    emailInput.required = true;
    passwordInput.disabled = false;
    
    // Pastikan required password hanya aktif saat form Create/Tambah Pengguna
    if (document.getElementById('userModalLabel').innerText === "Tambah Pengguna") {
        passwordInput.required = true;
    }

    document.getElementById('bank_id').required = false;
    document.getElementById('sekolah_id').required = false;
    document.getElementById('masa_aktif_member').required = false;
    if(document.getElementById('nisn')) document.getElementById('nisn').required = false;

    if (role == "4") { 
        membershipGroup.classList.remove('d-none');
        masaAktifGroup.classList.remove('d-none'); 
        document.getElementById('masa_aktif_member').required = true;
    } 
    else if (role == "5") { 
        if (AUTH_EMAIL === 'cb@bankir.academy') {
            bankGroup.classList.remove('d-none');
            document.getElementById('bank_id').required = true;
        }
    } 
    else if (role == "6") { 
        siswaProfileGroup.classList.remove('d-none'); // Tampilkan profil siswa
        siswaAccountInfo.classList.remove('d-none');  // Tampilkan kotak info generate otomatis
        
        if(document.getElementById('nisn')) document.getElementById('nisn').required = true;

        // HIDDEN INPUT EMAIL DAN PASSWORD
        emailGroup.classList.add('d-none');
        passwordGroup.classList.add('d-none');

        // MATIKAN INPUT EMAIL DAN PASSWORD agar tidak ikut terkirim/tervalidasi browser secara mentah
        emailInput.disabled = true;
        emailInput.required = false;
        emailInput.value = ""; 
        
        passwordInput.disabled = true;
        passwordInput.required = false;
        passwordInput.value = "";
        
        // Panggil fungsi preview info akun biar langsung render format awal
        updateSiswaInfoPreview();

        if (AUTH_EMAIL === 'cb@bankir.academy') {
            bankGroup.classList.remove('d-none');
            sekolahGroup.classList.remove('d-none');
            document.getElementById('bank_id').required = true;
            document.getElementById('sekolah_id').required = true;
        } else if (AUTH_ROLE === 4) {
            sekolahGroup.classList.remove('d-none');
            document.getElementById('sekolah_id').required = true;
        }
    }
}

// Fungsi live-preview akun berdasarkan input NISN
function updateSiswaInfoPreview() {
    let nisnValue = document.getElementById('nisn').value;
    let infoEmail = document.getElementById('info-email');
    let infoPassword = document.getElementById('info-password');

    if(nisnValue.trim() !== "") {
        infoEmail.innerText = nisnValue + "@gmail.com";
        infoPassword.innerText = nisnValue + "Bankir!";
    } else {
        infoEmail.innerText = "[nisn]@gmail.com";
        infoPassword.innerText = "[nisn]Bankir!";
    }
}

// Fungsi Toggle Show/Hide Password dengan Icon Mata
function togglePasswordVisibility() {
    let passwordInput = document.getElementById('password');
    let eyeIcon = document.getElementById('eye-icon');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        // Ganti ke icon eye-off (mata dicoret)
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        passwordInput.type = "password";
        // Kembalikan ke icon eye biasa
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
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
    // Reset Form ke mode Tambah (Create)
    document.getElementById('userModalLabel').innerText = "Tambah Pengguna";
    document.getElementById('userForm').action = "{{ route('users.store') }}";
    document.getElementById('method-container').innerHTML = "";
    document.getElementById('userForm').reset();
    
    document.getElementById('password-help').classList.add('d-none');
    document.getElementById('password').required = true;
    
    // Pastikan type password di-reset kembali ke password tersembunyi
    document.getElementById('password').type = "password";
    document.getElementById('eye-icon').innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    
    handleRoleChange();
}
    // Fungsi menyaring daftar sekolah di dalam Modal Import khusus untuk Root login
function filterSekolahImport() {
    let selectedBankId = document.getElementById('import_bank_id').value;
    let sekolahSelect = document.getElementById('import_sekolah_id');
    let options = sekolahSelect.options;

    // Reset pilihan sekolah ke default
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

    // Fungsi ketika tombol 'Edit' diklik
   function editUser(user) {
    resetForm();

    // Ubah form menjadi mode EDIT
    document.getElementById('userModalLabel').innerText = "Edit Pengguna";
    document.getElementById('userForm').action = `/users/${user.id}`; // Sesuaikan pola URL Route Update Anda
    document.getElementById('method-container').innerHTML = `@csrf @method('PUT')`;

    // Isi data dasar user
    document.getElementById('name').value = user.name;
    document.getElementById('email').value = user.email;
    document.getElementById('role').value = user.role;
    
    document.getElementById('password-help').classList.remove('d-none');
    document.getElementById('password').required = false;

    // Trigger perolehan hak akses grup form (Bank/Sekolah/Profile Siswa)
    handleRoleChange();

    // Set value membership / instansi pengampu
    if (user.role == 4 && user.membership_id) {
        document.getElementById('membership_id').value = user.membership_id;
        document.getElementById('masa_aktif_member').value = user.masa_aktif_member;
    }
    if (document.getElementById('bank_id') && user.bank_id) {
        document.getElementById('bank_id').value = user.bank_id;
        if(typeof filterSekolahByBank === "function") filterSekolahByBank();
    }
    if (document.getElementById('sekolah_id') && user.sekolah_id) {
        document.getElementById('sekolah_id').value = user.sekolah_id;
    }

    // --- PENGISIAN PROFILE SISWA ---
    if (user.role == 6 && user.siswa) {
        document.getElementById('nisn').value = user.siswa.nisn || '';
        document.getElementById('kelas').value = user.siswa.kelas || '';
        document.getElementById('jenis_kelamin').value = user.siswa.jenis_kelamin || '';
        document.getElementById('no_telp').value = user.siswa.no_telp || '';
        document.getElementById('angkatan').value = user.siswa.angkatan || '';
        document.getElementById('beasiswa').value = user.siswa.beasiswa ? "1" : "0";
    }

    // Tampilkan modal
    $('#userModal').modal('show');
}
</script>
@endsection