<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExamImportTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'exam_code',
            'title',
            'class_id',
            'description',
            'status',
            'question',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'option_e',
            'answer',
        ];
    }

    public function array(): array
    {
        return [
            [
                'EXAM-001',
                'Contoh Exam Pengetahuan Umum',
                '',
                'Petunjuk singkat untuk peserta.',
                0,
                'Ibu kota Indonesia adalah?',
                'Jakarta',
                'Bandung',
                'Surabaya',
                'Medan',
                '',
                'A',
            ],
            [
                'EXAM-001',
                'Contoh Exam Pengetahuan Umum',
                '',
                'Petunjuk singkat untuk peserta.',
                0,
                'Hasil dari 2 + 2 adalah?',
                '3',
                '4',
                '5',
                '6',
                '',
                'B',
            ],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
