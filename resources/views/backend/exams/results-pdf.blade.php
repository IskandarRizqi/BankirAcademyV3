<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Exam - {{ $exam->title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #202d48; font-size: 10px; }
        h1 { margin: 0 0 5px; font-size: 18px; }
        .meta { color: #667085; margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #5148c5; color: #fff; font-weight: bold; }
        th, td { border: 1px solid #d9deea; padding: 7px; text-align: left; }
        td:first-child, td:nth-child(4), td:nth-child(5), td:nth-child(6) { text-align: center; }
        tr:nth-child(even) { background: #f7f9fc; }
    </style>
</head>
<body>
    <h1>Hasil Exam: {{ $exam->title }}</h1>
    <div class="meta">{{ $exam->classData?->title ?? 'Tanpa kelas' }} | Total peserta unik: {{ $submissions->count() }}</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Nilai</th>
                <th>Benar</th>
                <th>Total Soal</th>
                <th>Waktu Submit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $index => $submission)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $submission->name }}</td>
                    <td>{{ $submission->phone }}</td>
                    <td>{{ number_format($submission->score, 2, ',', '.') }}</td>
                    <td>{{ $submission->correct_answers }}</td>
                    <td>{{ $submission->total_questions }}</td>
                    <td>{{ optional($submission->submitted_at)->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="7">Belum ada hasil exam.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
