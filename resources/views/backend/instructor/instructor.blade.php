@extends('layouts.compact')

@section('content')
    @php
        $totalInstructor = count($data ?? []);
        $activeInstructor = collect($data ?? [])
            ->where('status', 1)
            ->count();
        $inactiveInstructor = $totalInstructor - $activeInstructor;

        $statsCards = [
            [
                'title' => 'Total Instruktur',
                'value' => $totalInstructor,
                'description' => 'Keseluruhan data instruktur',
                'icon' => 'fas fa-users',
                'variant' => 'primary',
            ],
            [
                'title' => 'Instruktur Aktif',
                'value' => $activeInstructor,
                'description' => 'Status aktif di sistem',
                'icon' => 'fas fa-check-circle',
                'variant' => 'success',
            ],
            [
                'title' => 'Tidak Aktif',
                'value' => $inactiveInstructor,
                'description' => 'Status non-aktif',
                'icon' => 'fas fa-times-circle',
                'variant' => 'danger',
            ],
        ];
    @endphp

    @once
        <style>
            .instructor-summary-grid {
                row-gap: 24px;
                margin-bottom: 24px;
            }

            .instructor-summary-card {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                background: #ffffff;
                box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
                height: 100%;
            }

            .instructor-summary-card__info h4 {
                margin: 0;
                color: #6b7280;
                font-size: 13px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .instructor-summary-card__info strong {
                display: block;
                margin-top: 6px;
                color: #111827;
                font-size: 26px;
                font-weight: 900;
                line-height: 1.2;
            }

            .instructor-summary-card__info p {
                margin: 4px 0 0;
                color: #9ca3af;
                font-size: 12px;
            }

            .instructor-summary-card__icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 52px;
                height: 52px;
                border-radius: 14px;
                font-size: 20px;
                flex-shrink: 0;
            }

            .instructor-summary-card__icon--primary {
                background: #eef0fe;
                color: #4f46e5;
            }

            .instructor-summary-card__icon--success {
                background: #ecfdf5;
                color: #047857;
            }

            .instructor-summary-card__icon--danger {
                background: #fef2f2;
                color: #dc2626;
            }

            .instructor-section {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                padding: 20px;
                box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
            }

            .instructor-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 20px;
                flex-wrap: wrap;
            }

            .instructor-header h2 {
                margin: 0;
                color: #111827;
                font-size: 20px;
                font-weight: 900;
                letter-spacing: -0.03em;
            }

            .instructor-header p {
                margin: 4px 0 0;
                color: #6b7280;
                font-size: 13px;
            }

            .btn-modern-primary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 18px;
                background: #4f46e5;
                color: #ffffff;
                border: 0;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 850;
                cursor: pointer;
                transition: background 0.2s;
                text-decoration: none;
            }

            .btn-modern-primary:hover {
                background: #3d33d8;
                color: #ffffff;
            }

            .badge-status {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                border-radius: 999px;
                font-size: 12px;
                font-weight: 850;
                cursor: pointer;
                transition: opacity 0.2s;
            }

            .badge-status:hover {
                opacity: 0.85;
            }

            .badge-status--active {
                background: #ecfdf5;
                color: #047857;
            }

            .badge-status--inactive {
                background: #fef2f2;
                color: #dc2626;
            }

            .instructor-table img {
                border-radius: 10px;
                object-fit: cover;
                border: 1px solid #eef2f7;
            }

            .btn-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 34px;
                border-radius: 8px;
                border: 0;
                font-size: 15px;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-action--edit {
                background: #fef3c7;
                color: #b45309;
            }

            .btn-action--edit:hover {
                background: #fde68a;
            }

            .btn-action--delete {
                background: #fef2f2;
                color: #dc2626;
            }

            .btn-action--delete:hover {
                background: #fecaca;
            }

            .btn-action--login {
                background: #eef0fe;
                color: #4f46e5;
            }

            .btn-action--login:hover {
                background: #e0e7ff;
            }

            /* Custom DataTables Clean Styling */
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #4f46e5 !important;
                color: #ffffff !important;
                border: none !important;
                border-radius: 8px !important;
            }
        </style>
    @endonce

    <!-- Summary Cards Section -->
    <div class="row instructor-summary-grid">
        @foreach ($statsCards as $card)
            <div class="col-xl-4 col-md-6 col-12">
                <div class="instructor-summary-card">
                    <div class="instructor-summary-card__info">
                        <h4>{{ $card['title'] }}</h4>
                        <strong>{{ $card['value'] }}</strong>
                        <p>{{ $card['description'] }}</p>
                    </div>
                    <div class="instructor-summary-card__icon instructor-summary-card__icon--{{ $card['variant'] }}">
                        <i class="{{ $card['icon'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Table Section -->
    <section class="instructor-section">
        <div class="instructor-header">
            <div>
                <h2>Daftar Instruktur</h2>
                <p>Kelola profil, berkas, gambar, dan akses akun instruktur.</p>
            </div>
            <button type="button" class="btn-modern-primary" data-toggle="modal" data-target="#instructorModal">
                <i class="fas fa-plus"></i> Tambah Instruktur
            </button>
        </div>

        <div class="table-responsive">
            <table id="zero-config" class="table table-hover instructor-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>Title</th>
                        <th>Deskripsi</th>
                        <th>Dokumen</th>
                        <th>Gambar</th>
                        <th class="no-content text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                <span class="badge-status badge-status--{{ $d->status ? 'active' : 'inactive' }}"
                                    onclick="aktifasi({{ $d }})">
                                    <i class="fas fa-circle" style="font-size: 7px;"></i>
                                    {{ $d->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="font-weight-bold text-dark">{{ $d->name }}</td>
                            <td>{{ $d->title }}</td>
                            <td class="text-truncate" style="max-width: 200px" title="{{ $d->desc }}">
                                {{ $d->desc }}</td>
                            <td>
                                @if (json_decode($d->dokumen))
                                    <a href="/getBerkas?rf={{ json_decode($d->dokumen)->url }}"
                                        class="text-primary font-weight-bold">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if (json_decode($d->picture))
                                    <img src="{{ asset('Image/instructor/' . $d->name . '/' . json_decode($d->picture)->url) }}"
                                        alt="Avatar" width="50" height="50">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="d-inline-flex gap-1">
                                    <button class="btn-action btn-action--edit" id="edit"
                                        onclick="edit({{ $d }})" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </button>
                                    <button class="btn-action btn-action--delete" onclick="hapus('{{ $d->id }}')"
                                        title="Delete">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                    <button class="btn-action btn-action--login"
                                        onclick="login('{{ $d->id }}','{{ $d->user }}')" title="Login">
                                        <i class='bx bx-log-in'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal Form Instructor -->
    <div class="modal fade" id="instructorModal" tabindex="-1" aria-labelledby="instructorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 style-modal shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold text-dark" id="instructorModalLabel">Form Data Instruktur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('instructor.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Nama</label>
                                    <input type="text" class="form-control" id="id" name="id"
                                        value="{{ old('id') }}" hidden>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama') }}" required placeholder="Masukkan nama instruktur">
                                    @error('nama')
                                        <span class="text-danger small"><strong>Harap Diisi</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Deskripsi</label>
                                    <textarea class="form-control" id="desc" name="desc" required>{{ old('desc') }}</textarea>
                                    @error('desc')
                                        <span class="text-danger small"><strong>Harap Diisi</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title') }}" required
                                        placeholder="Contoh: Senior Technical Trainer">
                                    @error('title')
                                        <span class="text-danger small"><strong>Harap Diisi</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label class="font-weight-bold text-dark">Gambar (Avatar)
                                            <a href="javascript:void(0)"
                                                class="custom-file-container__image-clear text-danger"
                                                title="Clear Image">&times;</a>
                                        </label>
                                        <label class="custom-file-container__custom-file">
                                            <input type="file"
                                                class="custom-file-container__custom-file__custom-file-input"
                                                accept="image/*" name="picture">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div id="img_preview" class="custom-file-container__image-preview mt-2"></div>
                                    </div>
                                    @error('picture')
                                        <span class="text-danger small"><strong>Harap Diisi</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4">
                        <button type="button" class="btn btn-light rounded-lg px-4" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modern-primary">Simpan Data</button>
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

    <!-- Modal Login Instructor -->
    <div class="modal fade" id="loginInstructorModal" tabindex="-1" aria-labelledby="loginInstructorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold text-dark" id="loginInstructorModalLabel">Akses Login
                        Instruktur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/admin/logininstructor" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        @csrf
                        <input type="text" id="idIntructor" name="idIntructor" class="form-control" hidden>
                        <input type="text" id="idUser" name="idUser" class="form-control" hidden>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Nama</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Nama Lengkap">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email') }}" placeholder="email@domain.com">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        value="{{ old('password') }}" placeholder="******">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4">
                        <button type="button" class="btn btn-light rounded-lg px-4" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modern-primary">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var firstUpload = new FileUploadWithPreview('myFirstImage')
        var deskripsi = CKEDITOR.replace("desc");
        createDataTable('#zero-config')

        function login(data, user) {
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
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
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
                title: 'Ubah Status Instruktur?',
                text: "Status keaktifan instruktur akan diperbarui.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ubah Status',
                cancelButtonText: 'Batal',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $('#form_aktif').submit()
                }
            });
        }
    </script>
@endpush
