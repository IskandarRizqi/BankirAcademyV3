@extends('layouts.compact')

@section('title', 'Hasil Exam')

@section('content')
<div class="col-lg-12">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <div><h3 class="mb-1">Hasil Exam</h3><p class="text-muted mb-0">{{ $exam->title }} | {{ $exam->classData?->title ?? 'Tanpa kelas' }}</p></div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('admin.exams.results.export.excel', $exam) }}" class="btn btn-outline-success mr-1"><i class="fas fa-file-excel mr-1"></i>Excel</a>
            <a href="{{ route('admin.exams.results.export.pdf', $exam) }}" class="btn btn-outline-danger mr-1"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>
    <div class="alert alert-info">Halaman ini hanya dapat diakses oleh admin/root. Nilai tidak ditampilkan pada halaman peserta.</div>
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table id="exam-results-table" class="table table-hover mb-0 align-middle">
                <thead class="thead-light"><tr><th>No</th><th>Peserta</th><th>No HP</th><th>Nilai</th><th>Benar</th><th>Waktu</th><th>Detail</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($submissions as $submission)
                    <tr>
                        <td></td>
                        <td><strong>{{ $submission->name }}</strong></td>
                        <td>{{ $submission->phone }}</td>
                        <td><span class="badge badge-primary" style="font-size: 13px;">{{ number_format($submission->score, 2, ',', '.') }}</span></td>
                        <td>{{ $submission->correct_answers }} / {{ $submission->total_questions }}</td>
                        <td>{{ optional($submission->submitted_at)->format('d/m/Y H:i') }}</td>
                        <td><details><summary class="text-primary" style="cursor:pointer;">Lihat jawaban</summary><div class="mt-3" style="min-width: 360px;">
                            @foreach(($submission->questions_snapshot ?: []) as $index => $question)
                                @php $answer = $submission->answers[$index] ?? '-'; $correct = $question['answer'] ?? '-'; @endphp
                                <div class="border-bottom pb-2 mb-2"><strong>{{ $index + 1 }}. {{ $question['question'] ?? '' }}</strong><small class="d-block mt-1">Jawaban: <b>{{ $answer }}</b> | Kunci: <b>{{ $correct }}</b></small></div>
                            @endforeach
                        </div></details></td>
                        <td>
                            <form action="{{ route('admin.exams.results.destroy', [$exam, $submission]) }}" method="POST" onsubmit="return confirm('Hapus hasil exam peserta ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada peserta yang mengisi exam ini.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    $(function () {
        createDataTable('#exam-results-table', {
            order: [[5, 'desc']],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { targets: [6, 7], orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
