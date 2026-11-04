@extends('layouts.compact')

@section('title', 'Hasil Exam')

@section('content')
<div class="col-lg-12">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <div><h3 class="mb-1">Hasil Exam</h3><p class="text-muted mb-0">{{ $exam->title }} | Kelas: {{ $exam->classData->title }}</p></div>
        <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Kembali ke daftar exam</a>
    </div>
    <div class="alert alert-info">Halaman ini hanya dapat diakses oleh admin/root. Nilai tidak ditampilkan pada halaman peserta.</div>
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light"><tr><th>Peserta</th><th>No HP</th><th>Nilai</th><th>Benar</th><th>Waktu</th><th>Detail</th></tr></thead>
                <tbody>
                @forelse($submissions as $submission)
                    <tr>
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
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada peserta yang mengisi exam ini.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($submissions->hasPages())<div class="card-footer bg-white">{{ $submissions->links() }}</div>@endif
    </div>
</div>
@endsection
