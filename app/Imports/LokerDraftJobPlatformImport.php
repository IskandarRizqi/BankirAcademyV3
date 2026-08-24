<?php

namespace App\Imports;

use App\Models\LokerDraft;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LokerDraftJobPlatformImport implements WithMultipleSheets
{
    protected $platform;

    public function __construct($platform = 'JobStreet')
    {
        $this->platform = $platform;
    }

    /**
     * Membatasi sheet yang dibaca hanya sheet pertama (Index 0).
     * Jika nama sheet 1 pasti "Data Loker", bisa juga menggunakan key: 'Data Loker' => ...
     */
    public function sheets(): array
    {
        return [
            0 => new SingleSheetJobPlatformImport($this->platform), // Mengambil sheet ke-1 saja
        ];
    }
}

/**
 * Class khusus untuk memproses baris data di sheet 1
 */
class SingleSheetJobPlatformImport implements ToModel, WithStartRow
{
    protected $platform;

    public function __construct($platform)
    {
        $this->platform = $platform;
    }

    /**
     * Mulai membaca dari baris ke-2 (mengabaikan baris header)
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // Abaikan jika baris kosong (misal kolom posisi kosong)
        if (empty($row[0])) {
            return null;
        }

        return new LokerDraft([
            'source_type'         => 'job_platform',
            'platform'            => $this->platform,
            'posisi'              => $row[0] ?? null, // Kolom 1 (Index 0)
            'nama_perusahaan'     => $row[1] ?? null, // Kolom 2 (Index 1)
            'provinsi_raw'        => $row[2] ?? null, // Kolom 3 (Index 2 - Lokasi)
            'gaji_raw'            => $row[3] ?? null, // Kolom 4 (Index 3 - Gaji)
            // $row[4] = Kapan diposting (Dilewati)
            'tipe_pekerjaan'      => $row[5] ?? 'Fulltime', // Kolom 6 (Index 5)
            'kualifikasi_jobspek' => $row[6] ?? null, // Kolom 7 (Index 6)
            'deskripsi_pekerjaan' => $row[7] ?? null, // Kolom 8 (Index 7)
            // $row[8] = Fasilitas (Dilewati)
            'sumber_url'          => $row[9] ?? null, // Kolom 10 (Index 9)
            'status_draft'        => 'pending',
        ]);
    }
}
