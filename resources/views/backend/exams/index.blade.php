@extends('layouts.compact')

@section('title', 'Exam Kelas')

@section('content')
<div class="col-lg-12">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Exam</h3>
            <p class="text-muted mb-0">Kelola soal dan lihat nilai peserta tanpa membuka hasil di halaman publik.</p>
        </div>
        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary mt-2 mt-md-0"><i class="bx bx-plus mr-1"></i>Tambah Exam</a>
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
