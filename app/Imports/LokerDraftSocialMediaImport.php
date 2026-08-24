<?php

namespace App\Imports;

use App\Models\LokerDraft;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LokerDraftSocialMediaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new LokerDraft([
            'source_type'        => 'social_media',
            'platform'           => $row['platform'] ?? 'Instagram',
            'logo_url'           => $row['logo_url'] ?? null,
            'nama_perusahaan'    => $row['nama_perusahaan'] ?? null,
            'email_perusahaan'   => $row['email_perusahaan'] ?? null,
            'alamat_raw'         => $row['alamat_raw'] ?? null,
            'provinsi_raw'       => $row['provinsi_raw'] ?? null,
            'gaji_raw'           => $row['gaji_raw'] ?? null,
            'gaji_min'           => $row['gaji_min'] ?? null,
            'gaji_max'           => $row['gaji_max'] ?? null,
            'posisi'             => $row['posisi'],
            'ringkasan_ai'       => $row['ringkasan_ai'] ?? null,
            'deskripsi_pekerjaan' => $row['jobdesk'] ?? null,
            'kualifikasi_jobspek' => $row['kualifikasi_jobspek'] ?? null,
            'tipe_pekerjaan'     => $row['tipe_pekerjaan'] ?? null,
            'tanggal_posting'    => $row['tanggal_posting'] ?? null,
            'sumber_url'         => $row['sumber_url'] ?? null,
            'instagram_dm'       => $row['instagram_dm'] ?? null,
            'status_draft'       => 'pending',
        ]);
    }
}
