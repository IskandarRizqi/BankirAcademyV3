@extends('layouts.compact')

@section('content')
    <div class="col-12">
        <!-- Header Section -->
        <div class="card border-0 shadow-sm mb-4 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">SOP Bank</h4>
                        <p class="text-muted small mb-0">Kelola judul SOP dan dokumen pendukung dalam satu tempat.</p>
                    </div>
                    <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2"
                        id="btn-create-sop">
                        <i class="bx bx-plus fs-5"></i>
                        <span class="fw-medium">Tambah SOP</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Alert Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-error-circle fs-4 me-2"></i>
                    <strong class="me-auto">Terdapat kesalahan pengisian:</strong>
                </div>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Data Table Card -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                    <h5 class="fw-bold text-dark mb-0">Daftar SOP</h5>
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fs-7">{{ $sops->count() }} SOP
                        Tersedia</span>
                </div>

                <div class="table-responsive">
                    <table id="sop-table" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Judul SOP</th>
                                <th width="25%">Deskripsi</th>
                                <th width="10%">Status</th>
                                <th width="25%">Dokumen</th>
                                <th width="10%">Diperbarui</th>
                                <th width="5%" class="text-end dt-no-sorting">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sops as $item)
                                <tr>
                                    <td class="text-center fw-medium text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $item->judul }}</span>
                                    </td>
                                    <td>
                                        <div class="text-truncate text-muted small" style="max-width: 250px;"
                                            title="{{ $item->deskripsi }}">
                                            {{ $item->deskripsi ?: '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->status === 'upcoming')
                                            <span
                                                class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2 py-1">Upcoming</span>
                                        @else
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1">Non
                                                upcoming</span>
                                        @endif
                                    </td>
                                    <td>
                                        @forelse ($item->dokumenFiles as $document)
                                            <div
                                                class="d-flex align-items-center justify-content-between bg-light p-2 rounded mb-1 border">
                                                <div class="text-truncate me-2" style="max-width: 180px;">
                                                    @if ($document->link_google_drive)
                                                        <a href="{{ $document->link_google_drive }}" target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="text-decoration-none fw-medium text-primary small"
                                                            title="Buka {{ $document->nama_file }}">
                                                            <i
                                                                class="bx bx-link-external me-1"></i>{{ $document->nama_file }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.sop.documents.download', $document->id) }}"
                                                            class="text-decoration-none fw-medium text-dark small"
                                                            title="Download {{ $document->nama_file }}">
                                                            <i
                                                                class="bx bx-file me-1 text-secondary"></i>{{ $document->nama_file }}
                                                        </a>
                                                    @endif
                                                    <small class="d-block text-muted" style="font-size: 10px;">
                                                        {{ $document->link_google_drive ? 'Google Drive' : number_format($document->ukuran / 1048576, 2) . ' MB' }}
                                                    </small>
                                                </div>
                                                <form action="{{ route('admin.sop.documents.destroy', $document->id) }}"
                                                    method="POST" class="d-inline" data-delete-document-form>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon btn-light text-danger p-1 border-0"
                                                        data-delete-document title="Hapus dokumen">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @empty
                                            <span class="text-muted small italic">Belum ada dokumen</span>
                                        @endforelse
                                    </td>
                                    <td class="small text-muted">
                                        {{ $item->updated_at?->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <button type="button" class="btn btn-sm btn-outline-warning btn-edit-sop"
                                                data-id="{{ $item->id }}" data-judul="{{ $item->judul }}"
                                                data-status="{{ $item->status }}" data-deskripsi="{{ $item->deskripsi }}"
                                                data-action="{{ route('admin.sop.update', $item->id) }}"
                                                data-documents='@json($item->dokumenFiles)' title="Edit SOP">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.sop.destroy', $item->id) }}" method="POST"
                                                class="d-inline" data-delete-sop-form>
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-delete-sop
                                                    title="Hapus SOP">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
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

    <!-- Modal Form SOP (Create / Edit) -->
    <div class="modal fade" id="sopModal" tabindex="-1" aria-labelledby="sopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="sopModalLabel">Tambah SOP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sopForm" action="{{ route('admin.sop.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="method-container"></div>
                    <div class="modal-body py-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="sop-judul" class="form-label fw-medium small">Judul SOP <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="judul" id="sop-judul" class="form-control"
                                    placeholder="Masukkan judul SOP" maxlength="255" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sop-status" class="form-label fw-medium small">Status <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="sop-status" class="form-select" required>
                                    <option value="upcoming">Upcoming</option>
                                    <option value="non_upcoming" selected>Non upcoming</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="sop-deskripsi" class="form-label fw-medium small">Deskripsi singkat</label>
                                <textarea name="deskripsi" id="sop-deskripsi" class="form-control" rows="3" maxlength="1000"
                                    placeholder="Tuliskan ringkasan singkat tentang SOP ini"></textarea>
                                <div class="form-text text-muted" style="font-size: 11px;">Maksimal 1.000 karakter.</div>
                            </div>

                            <!-- Saved documents section (Visible on edit mode) -->
                            <div class="col-12 d-none" id="existing-documents-wrapper">
                                <label class="form-label fw-medium small d-block">Dokumen Tersimpan</label>
                                <div class="p-3 bg-light rounded border" id="existing-documents-list"></div>
                            </div>

                            <!-- Dynamic Document Input -->
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-medium small mb-0">Tambah Dokumen Pendukung</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-2"
                                        id="add-sop-document">
                                        <i class="bx bx-plus me-1"></i> Tambah Baris
                                    </button>
                                </div>

                                <div id="sop-documents" class="d-flex flex-column gap-2">
                                    <div class="row g-2 align-items-end sop-document-row" data-document-row>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted" style="font-size: 11px;">Jenis</label>
                                            <select name="documents[0][type]" class="form-select form-select-sm"
                                                data-document-type>
                                                <option value="link">Google Drive</option>
                                                <option value="file">File Lokal</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted" style="font-size: 11px;">Nama
                                                Dokumen</label>
                                            <input type="text" name="documents[0][nama_file]"
                                                class="form-control form-control-sm" placeholder="Contoh: SOP Kredit">
                                        </div>
                                        <div class="col-md-5" data-document-link>
                                            <label class="form-label text-muted" style="font-size: 11px;">Link Google
                                                Drive</label>
                                            <input type="url" name="documents[0][link_google_drive]"
                                                class="form-control form-control-sm"
                                                placeholder="https://drive.google.com/...">
                                        </div>
                                        <div class="col-md-5 d-none" data-document-file>
                                            <label class="form-label text-muted" style="font-size: 11px;">File
                                                Dokumen</label>
                                            <input type="file" name="documents[0][file]"
                                                class="form-control form-control-sm"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm w-100"
                                                data-remove-document title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-text text-muted mt-2" style="font-size: 11px;">
                                    File lokal maks 100 MB per file (.pdf, .doc, .xlsx, .ppt). Link Google Drive wajib URL
                                    valid.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                            <i class="bx bx-save"></i> <span id="btn-submit-label">Simpan SOP</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Template Dynamic Row -->
    <template id="sop-document-template">
        <div class="row g-2 align-items-end sop-document-row" data-document-row>
            <div class="col-md-3">
                <select name="documents[__INDEX__][type]" class="form-select form-select-sm" data-document-type>
                    <option value="link">Google Drive</option>
                    <option value="file">File Lokal</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="documents[__INDEX__][nama_file]" class="form-control form-control-sm"
                    placeholder="Contoh: SOP Kredit">
            </div>
            <div class="col-md-5" data-document-link>
                <input type="url" name="documents[__INDEX__][link_google_drive]" class="form-control form-control-sm"
                    placeholder="https://drive.google.com/...">
            </div>
            <div class="col-md-5 d-none" data-document-file>
                <input type="file" name="documents[__INDEX__][file]" class="form-control form-control-sm"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm w-100" data-remove-document title="Hapus">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        </div>
    </template>
@endsection

@section('custom-js')
    <script>
        $(function() {
            createDataTable('#sop-table', {
                order: [
                    [0, 'asc']
                ]
            });

            var documentIndex = 1;
            var sopModal = new bootstrap.Modal(document.getElementById('sopModal'));

            function toggleDocumentInput(row) {
                var type = row.find('[data-document-type]').val();
                var isLink = type === 'link';
                var linkInput = row.find('[data-document-link]');
                var fileInput = row.find('[data-document-file]');

                linkInput.toggleClass('d-none', !isLink);
                fileInput.toggleClass('d-none', isLink);
                linkInput.find('input').prop('disabled', !isLink);
                fileInput.find('input').prop('disabled', isLink);
            }

            function resetForm() {
                $('#sopForm')[0].reset();
                $('#method-container').html('');
                $('#existing-documents-wrapper').addClass('d-none');
                $('#existing-documents-list').empty();

                // Reset dynamic document rows to single empty row
                $('#sop-documents').html(`
                <div class="row g-2 align-items-end sop-document-row" data-document-row>
                    <div class="col-md-3">
                        <label class="form-label text-muted" style="font-size: 11px;">Jenis</label>
                        <select name="documents[0][type]" class="form-select form-select-sm" data-document-type>
                            <option value="link">Google Drive</option>
                            <option value="file">File Lokal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted" style="font-size: 11px;">Nama Dokumen</label>
                        <input type="text" name="documents[0][nama_file]" class="form-control form-control-sm" placeholder="Contoh: SOP Kredit">
                    </div>
                    <div class="col-md-5" data-document-link>
                        <label class="form-label text-muted" style="font-size: 11px;">Link Google Drive</label>
                        <input type="url" name="documents[0][link_google_drive]" class="form-control form-control-sm" placeholder="https://drive.google.com/...">
                    </div>
                    <div class="col-md-5 d-none" data-document-file>
                        <label class="form-label text-muted" style="font-size: 11px;">File Dokumen</label>
                        <input type="file" name="documents[0][file]" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100" data-remove-document title="Hapus">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            `);
                documentIndex = 1;
            }

            // Open Modal - Create Mode
            $('#btn-create-sop').on('click', function() {
                resetForm();
                $('#sopModalLabel').text('Tambah SOP Baru');
                $('#btn-submit-label').text('Simpan SOP');
                $('#sopForm').attr('action', "{{ route('admin.sop.store') }}");
                sopModal.show();
            });

            // Open Modal - Edit Mode
            $(document).on('click', '.btn-edit-sop', function() {
                resetForm();
                var btn = $(this);
                var id = btn.data('id');
                var judul = btn.data('judul');
                var status = btn.data('status');
                var deskripsi = btn.data('deskripsi');
                var action = btn.data('action');
                var documents = btn.data('documents');

                $('#sopModalLabel').text('Edit SOP');
                $('#btn-submit-label').text('Perbarui SOP');
                $('#sopForm').attr('action', action);
                $('#method-container').html('@method('PUT')');

                $('#sop-judul').val(judul);
                $('#sop-status').val(status);
                $('#sop-deskripsi').val(deskripsi);

                if (documents && documents.length > 0) {
                    var docHtml = '';
                    $.each(documents, function(i, doc) {
                        var linkText = doc.link_google_drive ? 'Google Drive' : 'File lokal';
                        docHtml += `
                        <div class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
                            <span class="small fw-medium">
                                <i class="bx ${doc.link_google_drive ? 'bx-link-external' : 'bx-file'} me-1"></i> ${doc.nama_file}
                            </span>
                            <span class="badge bg-secondary-subtle text-secondary" style="font-size: 10px;">${linkText}</span>
                        </div>
                    `;
                    });
                    $('#existing-documents-list').html(docHtml);
                    $('#existing-documents-wrapper').removeClass('d-none');
                }

                sopModal.show();
            });

            // Dynamic File Link Toggle
            $('#sop-documents').on('change', '[data-document-type]', function() {
                toggleDocumentInput($(this).closest('[data-document-row]'));
            });

            // Add New Document Row
            $('#add-sop-document').on('click', function() {
                var template = $('#sop-document-template').html().replace(/__INDEX__/g, documentIndex++);
                var row = $(template).appendTo('#sop-documents');
                toggleDocumentInput(row);
            });

            // Remove Document Row
            $('#sop-documents').on('click', '[data-remove-document]', function() {
                var rows = $('#sop-documents [data-document-row]');
                if (rows.length === 1) {
                    rows.find('input').val('');
                    rows.find('[data-document-type]').val('link').trigger('change');
                    return;
                }
                $(this).closest('[data-document-row]').remove();
            });

            // SweetAlert Delete Confirmation
            $(document).on('click', '[data-delete-sop], [data-delete-document]', function() {
                var button = $(this);
                var form = button.closest('form');
                var isDocument = button.is('[data-delete-document]');

                swal({
                    title: isDocument ? 'Hapus dokumen ini?' : 'Hapus SOP ini?',
                    text: isDocument ? 'File akan dihapus permanen dari server.' :
                        'Seluruh dokumen dalam SOP ini juga akan dihapus.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    padding: '2em'
                }).then(function(result) {
                    if (result.value) {
                        form[0].submit();
                    }
                });
            });
        });
    </script>
@endsection
