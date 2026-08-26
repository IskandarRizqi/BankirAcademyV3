@extends('layouts.compact')

@section('content')
    <style>
        .white-space-pre-line {
            white-space: pre-line;
        }

        .draft-modal-dialog {
            max-width: 1180px;
        }

        .draft-modal-content {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1rem 3rem rgba(15, 23, 42, .18);
        }

        .draft-modal-header {
            border: 0;
            padding: 1.25rem 1.5rem;
        }

        .draft-modal-header .close {
            color: inherit;
            opacity: .8;
            text-shadow: none;
        }

        .draft-modal-header .close:hover {
            opacity: 1;
        }

        .draft-modal-title {
            font-size: 1.05rem;
            letter-spacing: -.01em;
        }

        .draft-modal-subtitle {
            display: block;
            margin-top: .2rem;
            font-size: .78rem;
            opacity: .75;
        }

        .draft-modal-body {
            background: #f8fafc;
        }

        .draft-edit-form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            height: 100%;
            overflow: hidden;
        }

        .draft-edit-form .draft-modal-body {
            min-height: 0;
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        .draft-form-section {
            padding: 1.25rem;
            margin-bottom: 1rem;
            background: #fff;
            border: 1px solid #e8edf3;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .03);
        }

        .draft-form-section:last-child {
            margin-bottom: 0;
        }

        .draft-section-title {
            display: flex;
            align-items: center;
            padding-bottom: .75rem;
            margin-bottom: 1rem;
            color: #1e293b;
            font-size: .86rem;
            font-weight: 700;
            letter-spacing: .02em;
            text-transform: uppercase;
            border-bottom: 1px solid #edf1f5;
        }

        .draft-section-title i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            margin-right: .55rem;
            color: #4f46e5;
            background: #eef2ff;
            border-radius: 8px;
            font-size: 1rem;
        }

        .draft-form-section .form-group {
            margin-bottom: 1rem;
        }

        .draft-form-section .form-group:last-child {
            margin-bottom: 0;
        }

        .draft-form-section label {
            color: #334155;
            margin-bottom: .4rem;
        }

        .draft-form-section .form-control {
            min-height: 42px;
            border-color: #dbe3ec;
            border-radius: 9px;
            box-shadow: none;
        }

        .draft-form-section textarea.form-control {
            min-height: auto;
        }

        .draft-form-section .form-control:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 .2rem rgba(99, 102, 241, .12);
        }

        .draft-modal-footer {
            flex-shrink: 0;
            padding: 1rem 1.5rem;
            border: 0;
        }

        .draft-modal-footer .btn {
            min-width: 130px;
            border-radius: 9px;
            font-weight: 600;
        }

        .draft-detail-card {
            border: 1px solid #e8edf3;
            border-radius: 12px;
        }

        .draft-detail-card .card-body {
            padding: 1.1rem;
        }

        .draft-detail-label {
            display: block;
            margin-bottom: .2rem;
            color: #94a3b8;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        @media (max-width: 575.98px) {
            .draft-modal-dialog {
                margin: .5rem;
            }

            .draft-modal-header,
            .draft-modal-footer {
                padding: 1rem;
            }

            .draft-modal-footer {
                display: flex;
                flex-direction: column-reverse;
            }

            .draft-modal-footer .btn {
                width: 100%;
                margin: .2rem 0;
            }

            .draft-form-section {
                padding: 1rem;
            }
        }
    </style>

    @php
        $companyConflict = session('company_conflict');
    @endphp

    <div class="container-fluid py-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold text-dark mb-1">Review Draft Lowongan Kerja</h4>
                <p class="text-muted small mb-0">Kelola data hasil scraping dari sosial media dan job platform sebelum
                    dipublikasikan.</p>
            </div>
            <div class="d-flex flex-wrap align-items-center mt-3 mt-md-0">
                <form action="{{ route('lokerdraft.bulk-destroy') }}" method="POST" id="bulk-delete-form" class="d-none mr-2">
                    @csrf
                    <div id="bulk-delete-inputs"></div>
                    <button type="submit" class="btn btn-danger font-weight-bold">
                        <i class="bx bx-trash mr-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>
                </form>
                <button type="button" class="btn btn-outline-success font-weight-bold" data-toggle="modal"
                    data-target="#importDraftModal">
                    <i class="bx bx-upload mr-1"></i> Import Excel
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <strong>Data belum dapat disimpan:</strong>
                <ul class="mb-0 mt-2 pl-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-danger text-white p-3 mr-3"><i
                                class="bx bx-share-alt font-size-24"></i></div>
                        <div>
                            <div class="text-muted small">Social Media</div>
                            <div class="h4 font-weight-bold mb-0">{{ $sourceCounts->get('social_media', 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white p-3 mr-3"><i
                                class="bx bx-briefcase-alt-2 font-size-24"></i></div>
                        <div>
                            <div class="text-muted small">Job Platform</div>
                            <div class="h4 font-weight-bold mb-0">{{ $sourceCounts->get('job_platform', 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-warning text-white p-3 mr-3"><i
                                class="bx bx-time-five font-size-24"></i></div>
                        <div>
                            <div class="text-muted small">Total Draft Pending</div>
                            <div class="h4 font-weight-bold mb-0">{{ $sourceCounts->sum() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-end">
                    <div class="col-md-3 form-group mb-3 mb-md-0">
                        <label for="filter-source" class="font-weight-bold small text-dark">Sumber Data</label>
                        <select id="filter-source" class="form-control">
                            <option value="">Semua Sumber</option>
                            <option value="social_media">Social Media</option>
                            <option value="job_platform">Job Platform</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3 mb-md-0">
                        <label for="filter-platform" class="font-weight-bold small text-dark">Platform</label>
                        <select id="filter-platform" class="form-control">
                            <option value="">Semua Platform</option>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform }}">{{ $platform }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3 mb-md-0">
                        <label for="filter-gaji-min" class="font-weight-bold small text-dark">Minimal Gaji</label>
                        <input type="number" id="filter-gaji-min" class="form-control" placeholder="Contoh: 3000000"
                            min="0">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <button type="button" class="btn btn-primary font-weight-bold mr-1" id="apply-draft-filter">
                            <i class="bx bx-filter-alt mr-1"></i> Terapkan
                        </button>
                        <button type="button" class="btn btn-light font-weight-bold" id="reset-draft-filter">Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 p-4 d-flex flex-wrap align-items-center justify-content-between">
                <div>
                    <h5 class="font-weight-bold text-dark mb-1">Daftar Draft Loker</h5>
                    <p class="text-muted small mb-0">Gunakan pencarian DataTables untuk mencari posisi, perusahaan, lokasi,
                        atau platform.</p>
                </div>
                <span class="badge badge-light border px-3 py-2 mt-2 mt-md-0">Status: Pending</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="loker-draft-table" class="table table-hover align-middle mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width: 45px;"><input type="checkbox" id="select-all-drafts">
                                </th>
                                <th style="width: 45px;">No</th>
                                <th>Sumber</th>
                                <th>Posisi & Perusahaan</th>
                                <th>Lokasi</th>
                                <th>Gaji</th>
                                <th>Tipe</th>
                                {{-- <th>Posting</th> --}}
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importDraftModal" tabindex="-1" role="dialog" aria-labelledby="importDraftModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered draft-modal-dialog" role="document">
            <div class="modal-content draft-modal-content">
                <div class="modal-header bg-success text-white draft-modal-header">
                    <div>
                        <h5 class="modal-title draft-modal-title font-weight-bold" id="importDraftModalLabel"><i
                                class="bx bx-upload mr-1"></i> Import Data Draft Loker</h5>
                        <span class="draft-modal-subtitle">Pilih sumber data dan unggah file sesuai template.</span>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('loker-draft.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Tipe Sumber Data</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="source-social" name="source_type" value="social_media"
                                            class="custom-control-input" checked>
                                        <label class="custom-control-label" for="source-social">Social Media</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="source-job" name="source_type" value="job_platform"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="source-job">Job Platform</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-none" id="import-platform-wrapper">
                            <label for="import-platform" class="font-weight-bold">Platform</label>
                            <select name="platform" id="import-platform" class="form-control">
                                <option value="JobStreet">JobStreet</option>
                                <option value="Glints">Glints</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label for="file-excel" class="font-weight-bold">File Excel/CSV</label>
                            <input type="file" name="file_excel" id="file-excel" class="form-control-file"
                                accept=".xlsx,.xls,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light draft-modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success font-weight-bold">Upload & Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="draftDetailModal" tabindex="-1" role="dialog" aria-labelledby="draftDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable draft-modal-dialog"
            role="document">
            <div class="modal-content draft-modal-content">
                <div class="modal-header bg-primary text-white draft-modal-header">
                    <div>
                        <h5 class="modal-title draft-modal-title font-weight-bold mb-1" id="draft-detail-title">Detail
                            Draft Loker</h5>
                        <span class="draft-modal-subtitle" id="draft-detail-company"></span>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body draft-modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card draft-detail-card bg-light mb-3">
                                <div class="card-body">
                                    <div class="row small">
                                        <div class="col-md-4 mb-3"><span class="draft-detail-label">Platform</span><strong
                                                id="draft-detail-platform">-</strong></div>
                                        <div class="col-md-4 mb-3"><span class="draft-detail-label">Tipe
                                                Pekerjaan</span><strong id="draft-detail-type">-</strong></div>
                                        <div class="col-md-4 mb-3"><span class="draft-detail-label">Gaji</span><strong
                                                class="text-success" id="draft-detail-salary">-</strong></div>
                                        <div class="col-md-4"><span class="draft-detail-label">Lokasi</span><strong
                                                id="draft-detail-location">-</strong></div>
                                        <div class="col-md-4"><span class="draft-detail-label">Batas
                                                Pendaftaran</span><strong id="draft-detail-deadline">-</strong></div>
                                        <div class="col-md-4"><span class="draft-detail-label">Kategori</span><strong
                                                id="draft-detail-category">-</strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="font-weight-bold">Deskripsi</h6>
                                    <div id="draft-detail-description" class="small text-muted white-space-pre-line">-
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="font-weight-bold">Jobdesk</h6>
                                    <div id="draft-detail-jobdesk" class="small text-muted white-space-pre-line">-</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="font-weight-bold">Kualifikasi</h6>
                                    <div id="draft-detail-qualification" class="small text-muted white-space-pre-line">-
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="font-weight-bold">Skill</h6>
                                    <div id="draft-detail-skill" class="small text-muted white-space-pre-line">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card draft-detail-card mb-3">
                                <div class="card-body small">
                                    <h6 class="font-weight-bold">Kontak & Lamaran</h6>
                                    <p class="mb-2"><strong>Email:</strong> <span id="draft-detail-email">-</span></p>
                                    <p class="mb-2"><strong>Telepon:</strong> <span id="draft-detail-phone">-</span></p>
                                    <p class="mb-2"><strong>Instagram:</strong> <span
                                            id="draft-detail-instagram">-</span></p>
                                    <p class="mb-0"><strong>URL:</strong> <a id="draft-detail-url" href="#"
                                            target="_blank" rel="noopener">Buka sumber</a></p>
                                </div>
                            </div>
                            <div class="card draft-detail-card border-0 bg-light">
                                <div class="card-body small">
                                    <h6 class="font-weight-bold">Fasilitas</h6>
                                    <div id="draft-detail-benefit" class="white-space-pre-line text-muted">-</div>
                                    <h6 class="font-weight-bold mt-3">Cara Melamar</h6>
                                    <div id="draft-detail-apply" class="white-space-pre-line text-muted">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light draft-modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit & Normalisasi -->
    <div class="modal fade" id="draftEditModal" tabindex="-1" role="dialog" aria-labelledby="draftEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable draft-modal-dialog"
            role="document">
            <div class="modal-content draft-modal-content">
                <form method="POST" id="draft-edit-form" class="draft-edit-form">
                    <div class="modal-header bg-warning draft-modal-header">
                        <div>
                            <h5 class="modal-title draft-modal-title font-weight-bold" id="draftEditModalLabel"><i
                                    class="bx bx-edit-alt mr-1"></i> Edit & Normalisasi Draft</h5>
                            <span class="draft-modal-subtitle">Lengkapi data sebelum dipindahkan ke data loker dan
                                perusahaan.</span>
                        </div>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="publish_after_save" id="publish-after-save" value="0">
                    <div class="modal-body draft-modal-body">
                        <section class="draft-form-section">
                            <h6 class="draft-section-title"><i class="bx bx-buildings"></i>Data Perusahaan & Lokasi</h6>
                            <div class="row">
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Nama Perusahaan
                                        <span class="text-danger">*</span></label><input name="nama_perusahaan"
                                        id="edit-nama-perusahaan" class="form-control" required></div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Email
                                        Perusahaan</label><input type="email" name="email_perusahaan"
                                        id="edit-email-perusahaan" class="form-control"></div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Nomor HP /
                                        WhatsApp</label><input name="no_hp" id="edit-no-hp" class="form-control"></div>
                                {{-- <div class="col-md-6 form-group"><label class="font-weight-bold small">Instagram / Kontak
                                        DM</label><input name="instagram_dm" id="edit-instagram-dm" class="form-control">
                                </div> --}}
                                <div class="col-12 form-group"><label class="font-weight-bold small">Alamat
                                        Lengkap</label>
                                    <textarea name="alamat_raw" id="edit-alamat" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="col-md-3 form-group"><label class="font-weight-bold small">Provinsi <span
                                            class="text-danger">*</span></label><select name="provinsi_id"
                                        id="edit-provinsi" class="form-control" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select></div>
                                <div class="col-md-3 form-group"><label class="font-weight-bold small">Kabupaten / Kota
                                        <span class="text-danger">*</span></label><select name="kabupaten_id"
                                        id="edit-kabupaten" class="form-control" required>
                                        <option value="">Pilih Kabupaten</option>
                                    </select></div>
                                <div class="col-md-3 form-group"><label class="font-weight-bold small">Kecamatan <span
                                            class="text-danger">*</span></label><select name="kecamatan_id"
                                        id="edit-kecamatan" class="form-control" required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select></div>
                                <div class="col-md-3 form-group"><label class="font-weight-bold small">Kelurahan / Desa
                                        <span class="text-danger">*</span></label><select name="kelurahan_id"
                                        id="edit-kelurahan" class="form-control" required>
                                        <option value="">Pilih Kelurahan</option>
                                    </select></div>
                            </div>
                        </section>

                        <section class="draft-form-section">
                            <h6 class="draft-section-title"><i class="bx bx-briefcase"></i>Data Lowongan</h6>
                            <div class="row">
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Posisi <span
                                            class="text-danger">*</span></label><input name="posisi" id="edit-posisi"
                                        class="form-control" required></div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Kategori
                                        Bidang</label><input name="kategori_bidang" id="edit-kategori"
                                        class="form-control"></div>
                                <div class="col-md-4 form-group"><label class="font-weight-bold small">Tipe
                                        Pekerjaan</label><input name="tipe_pekerjaan" id="edit-tipe" class="form-control"
                                        placeholder="Fulltime"></div>
                                <div class="col-md-4 form-group"><label class="font-weight-bold small">Gaji
                                        Minimum</label><input type="number" min="0" name="gaji_min"
                                        id="edit-gaji-min" class="form-control"></div>
                                <div class="col-md-4 form-group"><label class="font-weight-bold small">Gaji
                                        Maksimum</label><input type="number" min="0" name="gaji_max"
                                        id="edit-gaji-max" class="form-control"></div>
                                <div class="col-md-4 form-group"><label class="font-weight-bold small">Tanggal
                                        Posting</label><input type="date" name="tanggal_posting"
                                        id="edit-tanggal-posting" class="form-control"></div>
                                <div class="col-md-4 form-group"><label class="font-weight-bold small">Batas Pendaftaran
                                        <span class="text-danger">*</span></label><input type="date"
                                        name="batas_pendaftaran" id="edit-batas-pendaftaran" class="form-control"
                                        required></div>
                                <div class="col-md-4 form-group"><label class="font-weight-bold small">Skill</label><input
                                        name="keahlian_skill" id="edit-skill" class="form-control"
                                        placeholder="Pisahkan dengan koma"></div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Deskripsi
                                        Pekerjaan</label>
                                    <textarea name="deskripsi_pekerjaan" id="edit-deskripsi" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Jobdesk</label>
                                    <textarea name="jobdesk" id="edit-jobdesk" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Kualifikasi</label>
                                    <textarea name="kualifikasi_jobspek" id="edit-kualifikasi" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Fasilitas /
                                        Benefit</label>
                                    <textarea name="fasilitas" id="edit-fasilitas" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">Cara
                                        Melamar</label>
                                    <textarea name="cara_melamar" id="edit-cara-melamar" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-md-6 form-group"><label class="font-weight-bold small">URL Form
                                        Lamaran</label><input type="url" name="website_form_url"
                                        id="edit-website-url" class="form-control"></div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer bg-light draft-modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary font-weight-bold" data-save-draft><i
                                class="bx bx-save mr-1"></i> Simpan Draft</button>
                        <button type="button" class="btn btn-success font-weight-bold" data-publish-draft><i
                                class="bx bx-check mr-1"></i> Simpan & Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($companyConflict)
        <!-- Modal Konflik Nama Perusahaan -->
        <div class="modal fade" id="companyConflictModal" tabindex="-1" role="dialog"
            aria-labelledby="companyConflictModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable draft-modal-dialog" role="document">
                <div class="modal-content draft-modal-content">
                    <div class="modal-header bg-warning draft-modal-header">
                        <div>
                            <h5 class="modal-title draft-modal-title font-weight-bold" id="companyConflictModalLabel"><i
                                    class="bx bx-error-circle mr-1"></i> Perusahaan dengan Nama Sama</h5>
                            <span class="draft-modal-subtitle">Konfirmasi cara menangani data perusahaan yang
                                terdeteksi.</span>
                        </div>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form action="{{ route('lokerdraft.publish', $companyConflict['draft_id']) }}" method="POST"
                        id="company-conflict-form">
                        @csrf
                        <input type="hidden" name="company_action" id="conflict-company-action" value="use_existing">
                        <div class="modal-body draft-modal-body">
                            <p class="small text-muted">Sudah ada perusahaan dengan nama
                                <strong>{{ $companyConflict['draft_name'] }}</strong>. Pilih tindakan berikut.
                            </p>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="use-existing-company" name="conflict_choice"
                                    value="use_existing" class="custom-control-input" checked>
                                <label class="custom-control-label font-weight-bold" for="use-existing-company">Gunakan
                                    perusahaan lama</label>
                                <small class="d-block text-muted ml-4">Data perusahaan lama akan diperbarui dengan hasil
                                    normalisasi draft.</small>
                            </div>
                            <div class="ml-4 mb-3">
                                @foreach ($companyConflict['companies'] as $company)
                                    <div class="custom-control custom-radio mb-2">
                                        <input type="radio" id="company-{{ $company['id'] }}" name="company_id"
                                            value="{{ $company['id'] }}" class="custom-control-input"
                                            {{ $loop->first ? 'checked' : '' }}>
                                        <label class="custom-control-label small" for="company-{{ $company['id'] }}">
                                            <strong>{{ $company['nama'] }}</strong><br><span
                                                class="text-muted">{{ $company['email'] ?: 'Email belum diisi' }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="create-new-company" name="conflict_choice" value="create_new"
                                    class="custom-control-input">
                                <label class="custom-control-label font-weight-bold" for="create-new-company">Buat
                                    perusahaan baru</label>
                            </div>
                            <input type="text" name="company_name" id="conflict-company-name"
                                class="form-control ml-4 w-75" placeholder="Nama perusahaan baru" disabled>
                        </div>
                        <div class="modal-footer bg-light draft-modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Konfirmasi & Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('custom-js')
    <script>
        (function() {
            const selectedDraftIds = new Set();
            const draftRows = new Map();
            const draftTable = createDataTable('#loker-draft-table', {
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    url: '{{ route('lokerdraft.index') }}',
                    data: function(data) {
                        data.source_type = document.getElementById('filter-source').value;
                        data.platform = document.getElementById('filter-platform').value;
                        data.gaji_min = document.getElementById('filter-gaji-min').value;
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
                            return '<input type="checkbox" data-draft-checkbox value="' + data + '">';
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        className: 'text-center'
                    },
                    {
                        data: 'source_badge',
                        name: 'source_type',
                        orderable: false
                    },
                    {
                        data: 'position_company',
                        name: 'posisi',
                        orderable: false
                    },
                    {
                        data: 'location_display',
                        name: 'provinsi_raw',
                        orderable: false
                    },
                    {
                        data: 'salary_display',
                        name: 'gaji_min',
                        orderable: false
                    },
                    {
                        data: 'type_display',
                        name: 'tipe_pekerjaan',
                        orderable: false
                    },
                    // { data: 'posting_display', name: 'tanggal_posting' },
                    {
                        data: 'actions',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                createdRow: function(row, data) {
                    draftRows.set(String(data.id), data);
                }
            });

            function syncSelection() {
                document.querySelectorAll('[data-draft-checkbox]').forEach(function(checkbox) {
                    checkbox.checked = selectedDraftIds.has(String(checkbox.value));
                });
                document.getElementById('selected-count').textContent = selectedDraftIds.size;
                document.getElementById('bulk-delete-form').classList.toggle('d-none', selectedDraftIds.size === 0);
                const pageCheckboxes = Array.from(document.querySelectorAll('[data-draft-checkbox]'));
                document.getElementById('select-all-drafts').checked = pageCheckboxes.length > 0 && pageCheckboxes
                    .every(function(checkbox) {
                        return checkbox.checked;
                    });
            }

            $('#loker-draft-table').on('draw.dt', syncSelection);
            document.addEventListener('change', function(event) {
                if (event.target.matches('[data-draft-checkbox]')) {
                    const id = String(event.target.value);
                    event.target.checked ? selectedDraftIds.add(id) : selectedDraftIds.delete(id);
                    syncSelection();
                }
            });

            document.getElementById('select-all-drafts').addEventListener('change', function() {
                document.querySelectorAll('[data-draft-checkbox]').forEach(function(checkbox) {
                    const id = String(checkbox.value);
                    if (document.getElementById('select-all-drafts').checked) selectedDraftIds.add(id);
                    else selectedDraftIds.delete(id);
                });
                syncSelection();
            });

            document.getElementById('apply-draft-filter').addEventListener('click', function() {
                draftTable.ajax.reload(null, true);
            });

            document.getElementById('reset-draft-filter').addEventListener('click', function() {
                document.getElementById('filter-source').value = '';
                document.getElementById('filter-platform').value = '';
                document.getElementById('filter-gaji-min').value = '';
                draftTable.ajax.reload(null, true);
            });

            document.getElementById('bulk-delete-form').addEventListener('submit', function(event) {
                event.preventDefault();
                const form = this;
                const inputs = document.getElementById('bulk-delete-inputs');
                inputs.innerHTML = '';
                selectedDraftIds.forEach(function(id) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    inputs.appendChild(input);
                });
                Swal.fire({
                    title: 'Hapus draft terpilih?',
                    text: selectedDraftIds.size + ' draft akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed) form.submit();
                });
            });

            document.addEventListener('click', function(event) {
                const actionButton = event.target.closest('[data-draft-action]');
                if (actionButton) {
                    const draft = draftRows.get(String(actionButton.dataset.draftId));
                    if (!draft) return;
                    actionButton.dataset.draftAction === 'edit' ? openEditModal(draft) : openDetailModal(draft);
                }

                const deleteButton = event.target.closest('[data-delete-draft]');
                if (deleteButton) {
                    const form = deleteButton.closest('form');
                    Swal.fire({
                        title: 'Hapus draft ini?',
                        text: 'Data yang dihapus tidak dapat dikembalikan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) form.submit();
                    });
                }
            });

            function setText(id, value) {
                document.getElementById(id).textContent = value || '-';
            }

            function setHref(id, value) {
                const link = document.getElementById(id);
                link.href = value || '#';
                link.classList.toggle('disabled', !value);
            }

            function openDetailModal(draft) {
                setText('draft-detail-title', draft.posisi);
                setText('draft-detail-company', draft.nama_perusahaan || 'Perusahaan belum diisi');
                setText('draft-detail-platform', draft.platform);
                setText('draft-detail-type', draft.tipe_pekerjaan || 'Fulltime');
                setText('draft-detail-salary', draft.gaji_raw || 'Kompetitif');
                setText('draft-detail-location', draft.provinsi_raw || draft.alamat_raw);
                setText('draft-detail-deadline', draft.batas_pendaftaran);
                setText('draft-detail-category', draft.kategori_bidang);
                setText('draft-detail-description', draft.deskripsi_pekerjaan || draft.ringkasan_ai);
                setText('draft-detail-jobdesk', draft.jobdesk);
                setText('draft-detail-qualification', draft.kualifikasi_jobspek);
                setText('draft-detail-skill', draft.keahlian_skill);
                setText('draft-detail-email', draft.email_perusahaan);
                setText('draft-detail-phone', draft.no_hp);
                setText('draft-detail-instagram', draft.instagram_dm);
                setText('draft-detail-benefit', draft.fasilitas);
                setText('draft-detail-apply', draft.cara_melamar);
                setHref('draft-detail-url', draft.sumber_url || draft.website_form_url);
                $('#draftDetailModal').modal('show');
            }

            function dateOnly(value) {
                const match = String(value || '').match(/^\d{4}-\d{2}-\d{2}/);
                return match ? match[0] : '';
            }

            function setValue(id, value) {
                document.getElementById(id).value = value || '';
            }

            async function loadLocationOptions(url, selectId, placeholder, selected) {
                const select = document.getElementById(selectId);
                select.innerHTML = '<option value="">' + placeholder + '</option>';
                if (!url) return;
                const response = await fetch(url);
                if (!response.ok) throw new Error('Gagal mengambil data wilayah.');
                const items = await response.json();
                items.forEach(function(item) {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    select.appendChild(option);
                });
                select.value = selected || '';
            }

            async function populateLocations(draft) {
                setValue('edit-provinsi', draft.provinsi_id);
                setValue('edit-kabupaten', '');
                setValue('edit-kecamatan', '');
                setValue('edit-kelurahan', '');
                await loadLocationOptions(draft.provinsi_id ? '{{ url('/admin/loker/getkabupaten') }}/' + draft
                    .provinsi_id : '', 'edit-kabupaten', 'Pilih Kabupaten', draft.kabupaten_id);
                await loadLocationOptions(draft.kabupaten_id ? '{{ url('/admin/loker/getkecamatan') }}/' + draft
                    .kabupaten_id : '', 'edit-kecamatan', 'Pilih Kecamatan', draft.kecamatan_id);
                await loadLocationOptions(draft.kecamatan_id ? '{{ url('/admin/loker/getkelurahan') }}/' + draft
                    .kecamatan_id : '', 'edit-kelurahan', 'Pilih Kelurahan', draft.kelurahan_id);
            }

            async function openEditModal(draft) {
                setValue('edit-nama-perusahaan', draft.nama_perusahaan);
                setValue('edit-email-perusahaan', draft.email_perusahaan);
                setValue('edit-no-hp', draft.no_hp);
                // setValue('edit-instagram-dm', draft.instagram_dm);
                setValue('edit-alamat', draft.alamat_raw);
                setValue('edit-posisi', draft.posisi);
                setValue('edit-kategori', draft.kategori_bidang);
                setValue('edit-tipe', draft.tipe_pekerjaan);
                setValue('edit-gaji-min', draft.gaji_min);
                setValue('edit-gaji-max', draft.gaji_max);
                setValue('edit-tanggal-posting', dateOnly(draft.tanggal_posting));
                setValue('edit-batas-pendaftaran', dateOnly(draft.batas_pendaftaran));
                setValue('edit-skill', draft.keahlian_skill);
                setValue('edit-deskripsi', draft.deskripsi_pekerjaan);
                setValue('edit-jobdesk', draft.jobdesk);
                setValue('edit-kualifikasi', draft.kualifikasi_jobspek);
                setValue('edit-fasilitas', draft.fasilitas);
                setValue('edit-cara-melamar', draft.cara_melamar);
                setValue('edit-website-url', draft.website_form_url);
                document.getElementById('draft-edit-form').action = '{{ url('/loker-drafts') }}/' + draft.id;
                document.getElementById('publish-after-save').value = '0';
                try {
                    await populateLocations(draft);
                    $('#draftEditModal').modal('show');
                } catch (error) {
                    Swal.fire('Gagal', error.message, 'error');
                }
            }

            document.getElementById('edit-provinsi').addEventListener('change', function() {
                loadLocationOptions(this.value ? '{{ url('/admin/loker/getkabupaten') }}/' + this.value : '',
                    'edit-kabupaten', 'Pilih Kabupaten', '');
                document.getElementById('edit-kecamatan').innerHTML =
                    '<option value="">Pilih Kecamatan</option>';
                document.getElementById('edit-kelurahan').innerHTML =
                    '<option value="">Pilih Kelurahan</option>';
            });
            document.getElementById('edit-kabupaten').addEventListener('change', function() {
                loadLocationOptions(this.value ? '{{ url('/admin/loker/getkecamatan') }}/' + this.value : '',
                    'edit-kecamatan', 'Pilih Kecamatan', '');
                document.getElementById('edit-kelurahan').innerHTML =
                    '<option value="">Pilih Kelurahan</option>';
            });
            document.getElementById('edit-kecamatan').addEventListener('change', function() {
                loadLocationOptions(this.value ? '{{ url('/admin/loker/getkelurahan') }}/' + this.value : '',
                    'edit-kelurahan', 'Pilih Kelurahan', '');
            });

            document.querySelector('[data-save-draft]').addEventListener('click', function() {
                document.getElementById('publish-after-save').value = '0';
                document.getElementById('draft-edit-form').submit();
            });
            document.querySelector('[data-publish-draft]').addEventListener('click', function() {
                document.getElementById('publish-after-save').value = '1';
                document.getElementById('draft-edit-form').submit();
            });

            document.querySelectorAll('input[name="source_type"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    document.getElementById('import-platform-wrapper').classList.toggle('d-none', this
                        .value !== 'job_platform');
                });
            });

            @if ($companyConflict)
                $('#companyConflictModal').modal('show');
                document.querySelectorAll('input[name="conflict_choice"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        const createNew = this.value === 'create_new';
                        document.getElementById('conflict-company-action').value = this.value;
                        document.getElementById('conflict-company-name').disabled = !createNew;
                        document.getElementById('conflict-company-name').required = createNew;
                    });
                });
            @endif
        })();
    </script>
@endsection
