<?php

namespace App\Imports;

use App\Models\LokerDraft;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LokerDraftSocialMediaImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new LokerDraft([
            'source_type'         => 'social_media',
            'status_draft'        => 'pending',

            'nama_perusahaan'     => $row[2] ?? null,
            'email_perusahaan'    => $row[3] ?? null,
            'alamat_raw'          => $row[4] ?? null,
            'gaji_raw'            => $row[6] ?? null,
            'posisi'              => $row[7] ?? null,
            'ringkasan_ai'        => $row[8] ?? null,
            'jobdesk'             => $row[9] ?? null,
            'kualifikasi_jobspek' => $row[10] ?? null,
            'keahlian_skill'      => $row[11] ?? null,
            'tipe_pekerjaan'      => $row[12] ?? null,

            // Konversi tanggal posting
            'tanggal_posting'     => $this->parseDateTime($row[13] ?? null),
            'batas_pendaftaran'   => $this->parseDate($row[14] ?? null),

            'no_hp'               => $row[15] ?? null,
            'website_form_url'    => $row[16] ?? null,
            'instagram_dm'        => $row[17] ?? null,
            'cara_melamar'        => $row[19] ?? null,
            'kategori_bidang'     => $row[20] ?? null,
            'sumber_url'          => $row[21] ?? null,
        ]);
    }

    /**
     * Helper untuk parse tanggal & jam Indonesia (Contoh: '12 Agu 2026, 15.55')
     */
    private function parseDateTime(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Ubah singkatan bulan Indonesia ke Inggris
            $value = $this->replaceIndonesianMonth($value);

            // Parsing format 'd M Y, H.i' (misal: '12 Aug 2026, 15.55')
            return Carbon::createFromFormat('d M Y, H.i', trim($value))->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // Fallback jika format tidak sesuai/menggunakan parse standar
            try {
                return Carbon::parse($value)->format('Y-m-d H:i:s');
            } catch (\Exception $ex) {
                return null;
            }
        }
    }

    /**
     * Helper untuk parse tanggal saja (jika ada batas_pendaftaran dalam format serupa)
     */
    private function parseDate(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            $value = $this->replaceIndonesianMonth($value);
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Mengganti nama/singkatan bulan Indonesia ke Inggris
     */
    private function replaceIndonesianMonth(string $dateString): string
    {
        $months = [
            'Mei' => 'May',
            'Agu' => 'Aug',
            'Agus' => 'Aug',
            'Agustus' => 'August',
            'Okt' => 'Oct',
            'Des' => 'Dec',
        ];

        return strtr($dateString, $months);
    }
}
