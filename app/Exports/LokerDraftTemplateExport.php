<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LokerDraftTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * Header kolom sesuai dengan struktur tabel loker_drafts
     */
    public function headings(): array
    {
        return [
            'source_type',
            'platform',
            'sumber_url',
            'nama_perusahaan',
            'logo_url',
            'email_perusahaan',
            'no_hp',
            'instagram_dm',
            'website_form_url',
            'alamat_raw',
            'provinsi_raw',
            'posisi',
            'deskripsi_pekerjaan',
            'jobdesk',
            'kualifikasi_jobspek',
            'keahlian_skill',
            'tipe_pekerjaan',
            'kategori_bidang',
            'fasilitas',
            'cara_melamar',
            'gaji_raw',
            'gaji_min',
            'gaji_max',
            'ringkasan_ai',
            'tanggal_posting',
            'batas_pendaftaran',
        ];
    }

    /**
     * Baris contoh data bawaan di dalam template
     */
    public function array(): array
    {
        return [
            [
                'social_media',
                'Instagram',
                'https://instagram.com/p/sample',
                'PT Tech Nusantara',
                'https://example.com/logo.png',
                'hrd@tech.com',
                '08123456789',
                '@tech_career',
                'https://tech.com/careers',
                'Jl. Sudirman No. 12',
                'DKI Jakarta',
                'Backend Developer',
                'Mengembangkan API dan arsitektur database',
                'Membuat RESTful API dengan Laravel',
                'Pengalaman minimal 2 tahun di PHP/Laravel',
                'Laravel, MySQL, Redis, Git',
                'Fulltime',
                'IT & Software',
                'BPJS, Laptop, Hybrid',
                'Kirim CV ke email hrd@tech.com',
                'Rp 8.000.000 - Rp 12.000.000',
                8000000,
                12000000,
                'Dibutuhkan Backend Developer Laravel dengan pengalaman 2 tahun',
                '2026-08-01',
                '2026-08-31',
            ]
        ];
    }

    /**
     * Styling sederhana untuk header (tebal/bold)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
