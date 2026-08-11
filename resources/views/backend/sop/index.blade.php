@extends('layouts.compact')

@section('content')
@php
    $isEdit = $sop !== null;
    $formAction = $isEdit ? route('admin.sop.update', $sop->id) : route('admin.sop.store');
@endphp

<div class="col-12">
    <div class="widget widget-content-area br-4 mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">{{ $isEdit ? 'Edit SOP' : 'SOP Bank' }}</h4>
                <p class="text-muted mb-0">Simpan judul SOP dan dokumen pendukung dalam satu tempat.</p>
            </div>
            @if ($isEdit)
                <a href="{{ route('admin.sop.index') }}" class="btn btn-light">Batal edit</a>
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="sop-judul">Judul SOP <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="sop-judul" class="form-control"
                        value="{{ old('judul', $sop->judul ?? '') }}" maxlength="255" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="sop-status">Status <span class="text-danger">*</span></label>
                    <select name="status" id="sop-status" class="form-control" required>
                        <option value="upcoming" @selected(old('status', $sop->status ?? '') === 'upcoming')>Upcoming</option>
                        <option value="non_upcoming" @selected(old('status', $sop->status ?? 'non_upcoming') === 'non_upcoming')>Non upcoming</option>
                    </select>
                </div>
                <div class="col-12 form-group">
                    <label for="sop-deskripsi">Deskripsi singkat</label>
                    <textarea name="deskripsi" id="sop-deskripsi" class="form-control" rows="3" maxlength="1000"
                        placeholder="Tuliskan ringkasan singkat tentang SOP ini">{{ old('deskripsi', $sop->deskripsi ?? '') }}</textarea>
                    <small class="form-text text-muted">Maksimal 1.000 karakter.</small>
                </div>
                <div class="col-12 form-group">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                        <label class="mb-0">Dokumen SOP</label>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-sop-document">
                            <i class="bx bx-plus mr-1"></i> Tambah dokumen
                        </button>
                    </div>
                    @if ($isEdit && $sop->dokumenFiles->isNotEmpty())
                        <div class="alert alert-light border mb-3">
                            <strong class="d-block mb-2">Dokumen tersimpan</strong>
                            @foreach ($sop->dokumenFiles as $document)
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-1">
                                    <span>
                                        <i class="bx {{ $document->link_google_drive ? 'bx-link-external' : 'bx-file' }} mr-1"></i>
                                        {{ $document->nama_file }}
                                    </span>
                                    @if ($document->link_google_drive)
                                        <a href="{{ $document->link_google_drive }}" target="_blank" rel="noopener noreferrer"
                                            class="small">Buka Google Drive</a>
                                    @else
                                        <a href="{{ route('admin.sop.documents.download', $document->id) }}" class="small">
                                            Download file
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                            <small class="text-muted d-block mt-2">Gunakan tombol "Tambah dokumen" untuk menambahkan dokumen baru.</small>
                        </div>
                    @endif
                    <div id="sop-documents">
                        <div class="row align-items-end sop-document-row mb-2" data-document-row>
                            <div class="col-md-2 form-group mb-md-0">
                                <label class="small">Jenis</label>
                                <select name="documents[0][type]" class="form-control" data-document-type>
                                    <option value="link">Google Drive</option>
                                    <option value="file">File lokal</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-md-0">
                                <label class="small">Nama dokumen</label>
                                <input type="text" name="documents[0][nama_file]" class="form-control"
                                    placeholder="Contoh: SOP Kredit">
                            </div>
                            <div class="col-md-5 form-group mb-md-0" data-document-link>
                                <label class="small">Link Google Drive</label>
                                <input type="url" name="documents[0][link_google_drive]" class="form-control"
                                    placeholder="https://drive.google.com/...">
                            </div>
                            <div class="col-md-5 form-group mb-md-0 d-none" data-document-file>
                                <label class="small">File dokumen</label>
                                <input type="file" name="documents[0][file]" class="form-control"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            </div>
                            <div class="col-md-2 form-group mb-md-0">
                                <button type="button" class="btn btn-outline-danger btn-block" data-remove-document>
                                    <i class="bx bx-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    <template id="sop-document-template">
                        <div class="row align-items-end sop-document-row mb-2" data-document-row>
                            <div class="col-md-2 form-group mb-md-0">
                                <label class="small">Jenis</label>
                                <select name="documents[__INDEX__][type]" class="form-control" data-document-type>
                                    <option value="link">Google Drive</option>
                                    <option value="file">File lokal</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-md-0">
                                <label class="small">Nama dokumen</label>
                                <input type="text" name="documents[__INDEX__][nama_file]" class="form-control"
                                    placeholder="Contoh: SOP Kredit">
                            </div>
                            <div class="col-md-5 form-group mb-md-0" data-document-link>
                                <label class="small">Link Google Drive</label>
                                <input type="url" name="documents[__INDEX__][link_google_drive]" class="form-control"
                                    placeholder="https://drive.google.com/...">
                            </div>
                            <div class="col-md-5 form-group mb-md-0 d-none" data-document-file>
                                <label class="small">File dokumen</label>
                                <input type="file" name="documents[__INDEX__][file]" class="form-control"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            </div>
                            <div class="col-md-2 form-group mb-md-0">
                                <button type="button" class="btn btn-outline-danger btn-block" data-remove-document>
                                    <i class="bx bx-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                    <small class="form-text text-muted">
                        Tambahkan beberapa baris untuk beberapa dokumen. Link wajib berasal dari Google Drive.
                        File lokal maksimal 100 MB per file.
                    </small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save mr-1"></i> {{ $isEdit ? 'Perbarui SOP' : 'Simpan SOP' }}
            </button>
        </form>
    </div>

    <div class="widget widget-content-area br-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
                <h5 class="mb-1">Daftar SOP</h5>
                <p class="text-muted small mb-0">Data berasal dari database dan dapat dicari melalui DataTables.</p>
            </div>
            <span class="text-muted small">{{ $sops->count() }} SOP</span>
        </div>

        <div class="table-responsive">
            <table id="sop-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul SOP</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th>Diperbarui</th>
                        <th class="dt-no-sorting">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sops as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->judul }}</strong></td>
                            <td class="text-truncate" style="max-width: 280px;" title="{{ $item->deskripsi }}">
                                {{ $item->deskripsi ?: '-' }}
                            </td>
                            <td>
                                <span class="badge {{ $item->status === 'upcoming' ? 'badge-warning' : 'badge-success' }}">
                                    {{ $item->status === 'upcoming' ? 'Upcoming' : 'Non upcoming' }}
                                </span>
                            </td>
                            <td style="min-width: 260px">
                                @forelse ($item->dokumenFiles as $document)
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        @if ($document->link_google_drive)
                                            <a href="{{ $document->link_google_drive }}" target="_blank" rel="noopener noreferrer"
                                                title="Buka {{ $document->nama_file }}">
                                                <i class="bx bx-link-external mr-1"></i>{{ $document->nama_file }}
                                            </a>
                                        @else
                                            <a href="{{ route('admin.sop.documents.download', $document->id) }}"
                                                title="Download {{ $document->nama_file }}">
                                                <i class="bx bx-file mr-1"></i>{{ $document->nama_file }}
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.sop.documents.destroy', $document->id) }}" method="POST"
                                            class="d-inline ml-2" data-delete-document-form>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-link text-danger p-0" data-delete-document
                                                title="Hapus dokumen" aria-label="Hapus dokumen">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <small class="d-block text-muted mb-2">
                                        {{ $document->link_google_drive ? 'Google Drive' : number_format($document->ukuran / 1048576, 2) . ' MB' }}
                                    </small>
                                @empty
                                    <span class="text-muted">Belum ada dokumen</span>
                                @endforelse
                            </td>
                            <td>{{ $item->updated_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.sop.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit SOP">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ route('admin.sop.destroy', $item->id) }}" method="POST" class="d-inline"
                                    data-delete-sop-form>
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" data-delete-sop title="Hapus SOP">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    $(function () {
        createDataTable('#sop-table', {
            order: [[0, 'asc']]
        });

        var documentIndex = 1;

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

        $('[data-document-row]').each(function () {
            toggleDocumentInput($(this));
        });

        $('#sop-documents').on('change', '[data-document-type]', function () {
            toggleDocumentInput($(this).closest('[data-document-row]'));
        });

        $('#add-sop-document').on('click', function () {
            var template = $('#sop-document-template').html().replace(/__INDEX__/g, documentIndex++);
            var row = $(template).appendTo('#sop-documents');
            toggleDocumentInput(row);
        });

        $('#sop-documents').on('click', '[data-remove-document]', function () {
            var rows = $('[data-document-row]');

            if (rows.length === 1) {
                rows.find('input').val('');
                rows.find('[data-document-type]').val('link').trigger('change');
                return;
            }

            $(this).closest('[data-document-row]').remove();
        });

        $(document).on('click', '[data-delete-sop], [data-delete-document]', function () {
            var button = $(this);
            var form = button.closest('form');
            var isDocument = button.is('[data-delete-document]');

            swal({
                title: isDocument ? 'Hapus dokumen ini?' : 'Hapus SOP ini?',
                text: isDocument ? 'File akan dihapus dari server.' : 'Seluruh dokumen dalam SOP ini juga akan dihapus.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                padding: '2em'
            }).then(function (result) {
                if (result.value) {
                    form[0].submit();
                }
            });
        });
    });
</script>
@endsection
