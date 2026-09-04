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
                    <i class="fas fa-pen-nib text-primary mr-2"></i> Generate Artikel Baru
                </h5>
                <form action="{{ route('articles.generate') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-9 mb-3 mb-md-0">
                            <label for="keyword" class="text-secondary small font-weight-bold">Keyword / Topik
                                Artikel</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i
                                            class="fas fa-search text-muted"></i></span>
                                </div>
                                <input type="text" name="keyword" id="keyword" required
                                    placeholder="Contoh: Strategi Digital Marketing untuk UMKM"
                                    class="form-control border-left-0 @error('keyword') is-invalid @enderror">
                            </div>
                            @error('keyword')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-md-4">
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-2"
                                style="border-radius: 8px;">
                                <i class="fas fa-magic mr-1"></i> Generate Sekarang
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
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block">Total Artikel</small>
                            <h4 class="font-weight-bold text-dark mb-0">{{ $stats['total_artikel'] }} Artikel</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 5px solid #10b981 !important;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 mr-3 text-success" style="background: #ecfdf5;">
                            <i class="fas fa-key fa-2x"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block">Unik Keyword</small>
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
                            <i class="fas fa-history fa-2x"></i>
                        </div>
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block">Terakhir Digenerate</small>
                            <h4 class="font-weight-bold text-dark mb-0">{{ $stats['artikel_terbaru'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-list text-primary mr-2"></i> Daftar Artikel Tersimpan
                </h5>
                <div>
                    <a href="{{ route('articles.exportAllPdf') }}"
                        class="btn btn-sm btn-danger font-weight-bold shadow-sm mr-2">
                        <i class="fas fa-file-pdf mr-1"></i> Export All PDF
                    </a>
                    <span class="badge badge-pill badge-light border text-muted px-3 py-2 font-weight-bold">
                        {{ $articles->count() }} Data Tersedia
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="zero-config" class="table table-hover table-striped align-middle mb-0"
                        style="background-color: white;">
                        <thead class="bg-light text-secondary small font-weight-bold">
                            <tr>
                                <th width="5%" class="pl-4">No</th>
                                <th width="20%">Keyword Utama</th>
                                <th>Judul Artikel</th>
                                <th width="15%">Tanggal Dibuat</th>
                                <th width="25%" class="text-center pr-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $index => $article)
                                <tr>
                                    <td class="pl-4 text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge badge-info px-2 py-1 font-weight-bold"
                                            style="border-radius: 6px;">
                                            <i class="fas fa-tag mr-1"></i> {{ $article->keyword }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $article->title }}</div>
                                    </td>
                                    <td class="text-muted small">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $article->created_at ? $article->created_at->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="text-center pr-4">
                                        <div class="btn-group" role="group">
                                            <!-- Lihat Hasil -->
                                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                                                class="btn btn-sm btn-info text-white font-weight-bold px-2 shadow-sm"
                                                style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;"
                                                title="Lihat Artikel">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('articles.exportPdf', $article->id) }}"
                                                class="btn btn-sm btn-danger text-white font-weight-bold px-2 shadow-sm"
                                                title="Export PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <!-- Edit Artikel -->
                                            <a href="{{ route('articles.edit', $article->id) }}"
                                                class="btn btn-sm btn-warning text-white font-weight-bold px-2 shadow-sm"
                                                title="Edit Artikel">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if ($article->status)
                                                <!-- Tombol Unpublish (Artikel Sedang Publish) -->
                                                <form action="{{ route('articles.unpublish', $article) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin membatal-publikasikan (unpublish) artikel ini?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-warning font-weight-bold px-2 shadow-sm"
                                                        title="Unpublish Artikel">
                                                        <i class="fas fa-eye-slash mr-1"></i> Unpublish
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Tombol Publish (Artikel Masih Draft/Unpublish) -->
                                                <form action="{{ route('articles.publish', $article) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin mempublikasikan artikel ini?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success font-weight-bold px-2 shadow-sm"
                                                        title="Publish Artikel">
                                                        <i class="fas fa-globe mr-1"></i> Publish
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Hapus Artikel -->
                                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger font-weight-bold px-2 shadow-sm"
                                                    style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;"
                                                    title="Hapus Artikel">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>
                                        <h5 class="text-secondary font-weight-bold">Belum Ada Artikel</h5>
                                        <p class="text-muted small mb-0">Masukkan keyword di atas untuk mulai memproses
                                            artikel AI pertama Anda.</p>
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
