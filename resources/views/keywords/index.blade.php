@extends('layouts.compact')

@section('content')
    <div class="py-4" style="background-color: #f8fafc; min-height: 100vh;">

        <!-- Alert Status -->
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Form Input Keyword Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-top: 4px solid #3b82f6;">
            <div class="card-body p-4">
                <h5 class="font-weight-bold text-dark mb-3">
                    <i class="fas fa-key text-primary mr-2"></i> Tambah Keyword Ke Antrean Generate
                </h5>
                <form action="{{ route('keywords.store') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-9 mb-3 mb-md-0">
                            <label for="keyword" class="text-secondary small font-weight-bold">Keyword / Topik Artikel
                                Baru</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-tags text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="keyword" id="keyword" required
                                    placeholder="Contoh: Tips Memulai Bisnis Thrift Store 2026"
                                    class="form-control border-left-0 @error('keyword') is-invalid @enderror"
                                    value="{{ old('keyword') }}">
                            </div>
                            @error('keyword')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-md-4">
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-2"
                                style="border-radius: 8px;">
                                <i class="fas fa-plus mr-1"></i> Simpan Keyword
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 5px solid #3b82f6 !important;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 mr-3 text-primary" style="background: #eff6ff;">
                            <i class="fas fa-database fa-2x"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block">Total Keyword Master</small>
                            <h4 class="font-weight-bold text-dark mb-0">{{ $stats['total_keyword'] }} Kata Kunci</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 5px solid #f59e0b !important;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 mr-3 text-warning" style="background: #fffbe6;">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block">Antrean (Pending)</small>
                            <h4 class="font-weight-bold text-dark mb-0">{{ $stats['pending'] }} Keyword</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 5px solid #10b981 !important;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 mr-3 text-success" style="background: #ecfdf5;">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block">Selesai Digenerate</small>
                            <h4 class="font-weight-bold text-dark mb-0">{{ $stats['completed'] }} Artikel</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-list text-primary mr-2"></i> Master Antrean Keyword
                </h5>
                <span class="badge badge-pill badge-light border text-muted px-3 py-2 font-weight-bold">
                    {{ $keywords->count() }} Data Tersedia
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="zero-config" class="table table-hover table-striped align-middle mb-0"
                        style="background-color: white;">
                        <thead class="bg-light text-secondary small font-weight-bold">
                            <tr>
                                <th width="5%" class="pl-4">No</th>
                                <th width="35%">Keyword / Topik Target</th>
                                <th width="15%">Status Antrean</th>
                                <th width="20%">Tanggal Ditambahkan</th>
                                <th width="20%">Tanggal Diproses</th>
                                <th width="15%" class="text-center pr-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keywords as $index => $item)
                                <tr>
                                    <td class="pl-4 text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $item->keyword }}</div>
                                    </td>
                                    <td>
                                        @if ($item->status === 'pending')
                                            <span class="badge badge-warning px-2 py-1 text-dark font-weight-bold"
                                                style="border-radius: 6px;">
                                                <i class="fas fa-hourglass-half mr-1"></i> Pending
                                            </span>
                                        @elseif($item->status === 'processing')
                                            <span class="badge badge-info px-2 py-1 font-weight-bold"
                                                style="border-radius: 6px;">
                                                <i class="fas fa-spinner fa-spin mr-1"></i> Processing
                                            </span>
                                        @elseif($item->status === 'completed')
                                            <span class="badge badge-success px-2 py-1 font-weight-bold"
                                                style="border-radius: 6px;">
                                                <i class="fas fa-check mr-1"></i> Completed
                                            </span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1 font-weight-bold"
                                                style="border-radius: 6px;">
                                                <i class="fas fa-times mr-1"></i> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="text-muted small">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $item->used_at ? \Carbon\Carbon::parse($item->used_at)->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="text-center pr-4">
                                        <div class="btn-group" role="group">
                                            <!-- Edit Keyword Button -->
                                            <button type="button"
                                                class="btn btn-sm btn-warning text-white font-weight-bold px-2 shadow-sm"
                                                style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;"
                                                data-toggle="modal" data-target="#editModal{{ $item->id }}"
                                                title="Edit Keyword">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Hapus Keyword Form -->
                                            <form action="{{ route('keywords.destroy', $item->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus keyword ini dari antrean?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger font-weight-bold px-2 shadow-sm"
                                                    style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;"
                                                    title="Hapus Keyword">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Keyword -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title font-weight-bold text-dark">
                                                    <i class="fas fa-edit text-warning mr-2"></i> Edit Keyword
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('keywords.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="form-group mb-3">
                                                        <label class="text-secondary small font-weight-bold">Keyword /
                                                            Topik</label>
                                                        <input type="text" name="keyword" class="form-control"
                                                            value="{{ $item->keyword }}" required>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label class="text-secondary small font-weight-bold">Status
                                                            Antrean</label>
                                                        <select name="status" class="form-control custom-select">
                                                            <option value="pending"
                                                                {{ $item->status == 'pending' ? 'selected' : '' }}>Pending
                                                            </option>
                                                            <option value="processing"
                                                                {{ $item->status == 'processing' ? 'selected' : '' }}>
                                                                Processing</option>
                                                            <option value="completed"
                                                                {{ $item->status == 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                            <option value="failed"
                                                                {{ $item->status == 'failed' ? 'selected' : '' }}>Failed
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top bg-light">
                                                    <button type="button" class="btn btn-secondary font-weight-bold px-3"
                                                        data-dismiss="modal" style="border-radius: 6px;">Batal</button>
                                                    <button type="submit" class="btn btn-primary font-weight-bold px-3"
                                                        style="border-radius: 6px;">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3 d-block"></i>
                                        <h5 class="text-secondary font-weight-bold">Antrean Keyword Kosong</h5>
                                        <p class="text-muted small mb-0">Tambahkan kata kunci baru di form atas untuk
                                            dijalankan otomatis oleh n8n.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        createDataTable('#zero-config')
    </script>
@endpush
