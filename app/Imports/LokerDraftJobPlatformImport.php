<?php

namespace App\Imports;

use App\Models\LokerDraft;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LokerDraftJobPlatformImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new LokerDraft([
            'source_type'        => 'job_platform',
            'platform'           => $row['platform'] ?? 'JobStreet',
            'posisi'             => $row['posisi'],
            'nama_perusahaan'    => $row['nama_perusahaan'] ?? null,
            'provinsi_raw'       => $row['provinsi_raw'] ?? null,
            'gaji_raw'           => $row['gaji_raw'] ?? null,
            'tipe_pekerjaan'     => $row['tipe_pekerjaan'] ?? 'Fulltime',
            'kualifikasi_jobspek' => $row['kualifikasi_jobspek'] ?? null,
            'deskripsi_pekerjaan' => $row['deskripsi_pekerjaan'] ?? null,
            'sumber_url'         => $row['sumber_url'] ?? null,
            'status_draft'       => 'pending',
        ]);
    }
}
