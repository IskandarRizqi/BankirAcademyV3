<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExamResultsExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    private Collection $submissions;

    public function __construct(Collection $submissions)
    {
        $this->submissions = $submissions;
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'No HP', 'Nilai', 'Jawaban benar', 'Total soal', 'Waktu submit'];
    }

    public function array(): array
    {
        return $this->submissions->values()->map(function ($submission, $index) {
            return [
                $index + 1,
                $submission->name,
                $submission->phone,
                $submission->score,
                $submission->correct_answers,
                $submission->total_questions,
                optional($submission->submitted_at)->format('d/m/Y H:i'),
            ];
        })->all();
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
