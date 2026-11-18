@extends('layouts.compact')

@section('title', 'Exam Kelas')

@section('content')
<div class="col-lg-12">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Import tidak dapat diproses:</strong>
            <ul class="mb-0 mt-2 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Exam</h3>
            <p class="text-muted mb-0">Kelola soal dan lihat nilai peserta tanpa membuka hasil di halaman publik.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('admin.exams.template') }}" class="btn btn-outline-success mr-1"><i class="bx bx-download mr-1"></i>Template</a>
            <button type="button" class="btn btn-outline-primary mr-1" data-toggle="modal" data-target="#importExamModal"><i class="bx bx-upload mr-1"></i>Import Excel</button>
            <a href="{{ route('admin.exams.create') }}" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah Exam</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" class="row align-items-end">
                <div class="col-md-6">
                    <label class="small font-weight-bold text-muted">Filter kelas</label>
                    <select name="class_id" class="form-control">
                        <option value="">Semua kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ (string) request('class_id') === (string) $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-2 mt-md-0">
                    <button class="btn btn-outline-primary mr-1" type="submit">Terapkan</button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.exams.index') }}">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr><th>Exam</th><th>Kelas</th><th>Soal</th><th>Status</th><th>Pengisian</th><th class="text-right">Aksi</th></tr>
                </thead>
                <tbody>
                @forelse($exams as $exam)
                    <tr>
                        <td><strong>{{ $exam->title }}</strong><small class="d-block text-muted">{{ $exam->description ? \Illuminate\Support\Str::limit($exam->description, 80) : 'Tanpa deskripsi' }}</small></td>
                        <td>{{ $exam->classData?->title ?? 'Tanpa kelas' }}</td>
                        <td>{{ count($exam->questions ?: []) }}</td>
                        <td><span class="badge badge-{{ $exam->status ? 'success' : 'secondary' }}">{{ $exam->status ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td><a href="{{ route('admin.exams.results', $exam) }}">{{ $exam->submissions_count }} peserta</a></td>
                        <td class="text-right text-nowrap">
                            <a href="{{ route('exam.show', $exam->public_token) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Buka link publik"><i class="bx bx-link-external"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyExamLink('{{ route('exam.show', $exam->public_token) }}')" title="Salin link"><i class="bx bx-copy"></i></button>
                            <a href="{{ route('admin.exams.results', $exam) }}" class="btn btn-sm btn-outline-success" title="Lihat hasil"><i class="bx bx-bar-chart-alt-2"></i></a>
                            <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bx bx-edit"></i></a>
                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus exam ini beserta seluruh hasilnya?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bx bx-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada exam.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($exams->hasPages())<div class="card-footer bg-white">{{ $exams->links() }}</div>@endif
    </div>
</div>

<div class="modal fade" id="importExamModal" tabindex="-1" role="dialog" aria-labelledby="importExamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="importExamModalLabel"><i class="bx bx-upload mr-1"></i>Import Exam</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.exams.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="mb-2">Import akan membuat exam baru. Gunakan template yang tersedia. Satu baris berisi satu soal; baris dengan <code>exam_code</code> yang sama akan digabung menjadi satu exam.</p>
                    <ul class="small text-muted pl-3">
                        <li>Gunakan <code>class_id</code> yang valid atau kosongkan jika exam tidak terkait kelas.</li>
                        <li><code>status</code>: 1 untuk aktif, 0 untuk nonaktif.</li>
                        <li>Hapus dua baris contoh dari template sebelum mengisi data sebenarnya.</li>
                    </ul>
                    <div class="form-group mb-0">
                        <label for="exam-file" class="font-weight-bold">File Excel/CSV</label>
                        <input type="file" name="file_excel" id="exam-file" class="form-control-file" accept=".xlsx,.xls,.csv" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    function copyExamLink(link) {
        navigator.clipboard.writeText(link).then(function () {
            if (typeof Swal !== 'undefined') Swal.fire({icon: 'success', title: 'Link disalin', timer: 1200, showConfirmButton: false});
        });
    }
</script>
@endsection
