@extends('backend.template')

@section('content')
@php
    $isEdit = $bonusAplikasi !== null;
    $formAction = $isEdit
        ? route('admin.bonus_aplikasi.update', $bonusAplikasi->id)
        : route('admin.bonus_aplikasi.store');
    $sourceType = old('tipe_sumber', $bonusAplikasi->tipe_sumber ?? 'url');
@endphp

<div class="col-12">
    <div class="widget widget-content-area br-4 mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">{{ $isEdit ? 'Edit Bonus Aplikasi' : 'Bonus Aplikasi' }}</h4>
                <p class="text-muted mb-0">Kelola aplikasi bonus melalui URL atau file ZIP.</p>
            </div>
            @if ($isEdit)
                <a href="{{ route('admin.bonus_aplikasi.index') }}" class="btn btn-light">Batal edit</a>
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
                    <label for="bonus-nama">Nama aplikasi <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="bonus-nama" class="form-control"
                        value="{{ old('nama', $bonusAplikasi->nama ?? '') }}" maxlength="255" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="bonus-status">Status <span class="text-danger">*</span></label>
                    <select name="status" id="bonus-status" class="form-control" required>
                        <option value="upcoming" @selected(old('status', $bonusAplikasi->status ?? 'non_upcoming') === 'upcoming')>Upcoming</option>
                        <option value="non_upcoming" @selected(old('status', $bonusAplikasi->status ?? 'non_upcoming') === 'non_upcoming')>Non upcoming</option>
                    </select>
                </div>
                <div class="col-12 form-group">
                    <label for="bonus-deskripsi">Deskripsi singkat</label>
                    <textarea name="deskripsi" id="bonus-deskripsi" class="form-control" rows="3" maxlength="1000"
                        placeholder="Tuliskan ringkasan singkat aplikasi">{{ old('deskripsi', $bonusAplikasi->deskripsi ?? '') }}</textarea>
                    <small class="form-text text-muted">Maksimal 1.000 karakter.</small>
                </div>
                <div class="col-md-6 form-group">
                    <label for="bonus-source">Sumber bonus <span class="text-danger">*</span></label>
                    <select name="tipe_sumber" id="bonus-source" class="form-control" required>
                        <option value="url" @selected($sourceType === 'url')>Link URL</option>
                        <option value="file" @selected($sourceType === 'file')>Upload file ZIP</option>
                    </select>
                </div>
                <div class="col-md-6 form-group d-none" id="bonus-url-group">
                    <label for="bonus-url">URL aplikasi <span class="text-danger">*</span></label>
                    <input type="url" name="url" id="bonus-url" class="form-control" maxlength="2048"
                        value="{{ old('url', $bonusAplikasi->url ?? '') }}" placeholder="https://contoh.com/aplikasi">
                </div>
                <div class="col-md-6 form-group d-none" id="bonus-file-group">
                    <label for="bonus-file">File aplikasi (.zip) <span class="text-danger">*</span></label>
                    <input type="file" name="file" id="bonus-file" class="form-control" accept=".zip">
                    <small class="form-text text-muted">
                        Maksimal 100 MB. Kosongkan saat edit jika tetap menggunakan file lama.
                    </small>
                    @if ($isEdit && $bonusAplikasi->file_path)
                        <a href="{{ route('admin.bonus_aplikasi.download', $bonusAplikasi->id) }}" class="small d-block mt-1">
                            File tersimpan: {{ $bonusAplikasi->file_name }}
                        </a>
                    @endif
                </div>
                <div class="col-md-6 form-group">
                    <label for="bonus-thumbnail">Thumbnail</label>
                    <input type="file" name="thumbnail" id="bonus-thumbnail" class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">
                    <small class="form-text text-muted">JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
                    @if ($isEdit && $bonusAplikasi->thumbnail_path)
                        <img src="{{ asset($bonusAplikasi->thumbnail_path) }}" alt="Thumbnail {{ $bonusAplikasi->nama }}"
                            class="img-thumbnail d-block mt-2" style="max-width: 180px; max-height: 100px; object-fit: cover;">
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save mr-1"></i> {{ $isEdit ? 'Perbarui Bonus' : 'Simpan Bonus' }}
            </button>
        </form>
    </div>

    <div class="widget widget-content-area br-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
                <h5 class="mb-1">Daftar Bonus Aplikasi</h5>
                <p class="text-muted small mb-0">Data tersimpan ditampilkan melalui DataTables.</p>
            </div>
            <span class="text-muted small">{{ $bonusAplikasiList->count() }} aplikasi</span>
        </div>

        <div class="table-responsive">
            <table id="bonus-aplikasi-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Thumbnail</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Sumber</th>
                        <th>Diperbarui</th>
                        <th class="dt-no-sorting">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bonusAplikasiList as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->thumbnail_path)
                                    <img src="{{ asset($item->thumbnail_path) }}" alt="Thumbnail {{ $item->nama }}"
                                        width="80" height="45" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td class="text-truncate" style="max-width: 260px;" title="{{ $item->deskripsi }}">
                                {{ $item->deskripsi ?: '-' }}
                            </td>
                            <td>
                                <span class="badge {{ $item->status === 'upcoming' ? 'badge-warning' : 'badge-success' }}">
                                    {{ $item->status === 'upcoming' ? 'Upcoming' : 'Non upcoming' }}
                                </span>
                            </td>
                            <td>
                                @if ($item->tipe_sumber === 'url')
                                    <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">Link URL</a>
                                @else
                                    <a href="{{ route('admin.bonus_aplikasi.download', $item->id) }}">File ZIP</a>
                                @endif
                            </td>
                            <td>{{ $item->updated_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.bonus_aplikasi.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ route('admin.bonus_aplikasi.destroy', $item->id) }}" method="POST"
                                    class="d-inline" data-delete-bonus-form>
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" data-delete-bonus title="Hapus">
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
        createDataTable('#bonus-aplikasi-table', {
            order: [[0, 'asc']]
        });

        function toggleSourceFields() {
            var source = $('#bonus-source').val();
            var isUrl = source === 'url';
            var urlGroup = $('#bonus-url-group');
            var fileGroup = $('#bonus-file-group');

            urlGroup.toggleClass('d-none', !isUrl);
            fileGroup.toggleClass('d-none', isUrl);
            $('#bonus-url').prop('disabled', !isUrl);
            $('#bonus-file').prop('disabled', isUrl);
        }

        $('#bonus-source').on('change', toggleSourceFields);
        toggleSourceFields();

        $(document).on('click', '[data-delete-bonus]', function () {
            var form = $(this).closest('form');

            swal({
                title: 'Hapus bonus aplikasi ini?',
                text: 'File dan thumbnail terkait akan ikut dihapus.',
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
