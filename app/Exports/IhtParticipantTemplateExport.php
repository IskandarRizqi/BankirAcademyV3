<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IhtParticipantTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new IhtParticipantTemplateSheet,
            new IhtParticipantInstructionSheet,
        ];
    }
}

class IhtParticipantTemplateSheet implements FromArray, ShouldAutoSize, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            ['nama', 'email', 'nomor_handphone'],
        ];
    }

    public function title(): string
    {
        return 'Template Peserta';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4F46E5'],
            ]],
        ];
    }
}

class IhtParticipantInstructionSheet implements FromArray, ShouldAutoSize, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            ['Petunjuk Import Data Peserta IHT'],
            ['1. Isi data pada sheet Template Peserta mulai dari baris kedua.'],
            ['2. Jangan mengubah nama kolom: nama, email, nomor_handphone.'],
            ['3. Satu baris hanya untuk satu peserta.'],
            ['4. Import dapat digunakan untuk menambahkan atau memperbarui data peserta dalam jumlah banyak.'],
            ['5. Nama wajib diisi, maksimal 255 karakter.'],
            ['6. Email wajib valid dan tidak boleh sama dengan peserta lain dalam file.'],
            ['7. Nomor handphone wajib diisi, maksimal 30 karakter.'],
            ['8. Baris kosong akan diabaikan.'],
            ['9. Import akan menggantikan daftar peserta yang tersimpan pada kelas ini.'],
            ['10. Periksa kembali data sebelum mengunggah file.'],
            ['Format file yang diterima: .xlsx, .xls, atau .csv. Maksimal ukuran file: 5 MB.'],
        ];
    }

    public function title(): string
    {
        return 'Petunjuk';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }
}
