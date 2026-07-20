<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;

class SiswaTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new SiswaSheetTemplate('Non Beasiswa'),
            new SiswaSheetTemplate('Beasiswa'),
        ];
    }
}

class SiswaSheetTemplate implements FromArray, WithTitle, WithHeadings
{
    private $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function array(): array
    {
        // Berikan 1 contoh baris data kosong/dummy di dalam template
        return [
            [
                'nama'          => 'Contoh Nama Siswa',
                'nisn'          => '3535632',
                'kelas'         => 'XII-RPL',
                'angkatan'         => '2023',
                'jenis_kelamin' => 'L/P',
                'no_telepon'    => '081234567890',
                'alamat'        => 'Jl. Contoh Alamat No. 123', // <-- Tambahan contoh alamat
                'email'         => 'siswa@email.com'           // <-- Tambahan contoh email asli siswa
            ]
        ];
    }

    public function headings(): array
    {
        // Pastikan urutannya sama persis dengan yang ada di method array() di atas
        return [
            'Nama',
            'NISN',
            'Kelas',
            'Angkatan',
            'Jenis Kelamin',
            'No Telepon',
            'Alamat', // <-- Tambahan heading Alamat
            'Email'   // <-- Tambahan heading Email
        ];
    }

    public function title(): string
    {
        return $this->title;
    }
}