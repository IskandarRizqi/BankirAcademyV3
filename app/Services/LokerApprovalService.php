<?php

namespace App\Services;

use App\Models\LokerDraft;
use App\Models\LokerModel;
use App\Models\PerusahaanModel;

class LokerApprovalService
{
    public function approveAndPublish(int $draftId, array $validatedRegionData)
    {
        $draft = LokerDraft::findOrFail($draftId);

        // 1. Cek atau Buat Perusahaan
        $perusahaan = PerusahaanModel::firstOrCreate(
            ['nama' => $draft->nama_perusahaan],
            [
                'email'     => $draft->email_perusahaan,
                'alamat'    => $draft->alamat_raw,
                'provinsi'  => $validatedRegionData['provinsi_id'] ?? null,
                'kabupaten' => $validatedRegionData['kabupaten_id'] ?? null,
                'kecamatan' => $validatedRegionData['kecamatan_id'] ?? null,
                'kelurahan' => $validatedRegionData['kelurahan_id'] ?? null,
                'image'     => $draft->logo_url,
            ]
        );

        // 2. Buat Loker Resmi di Tabel `loker`
        $loker = LokerModel::create([
            'user_id'        => auth()->id(),
            'title'          => $draft->posisi,
            'gaji_min'       => $draft->gaji_min ?? 0,
            'gaji_max'       => $draft->gaji_max ?? 0,
            'deskripsi'      => $draft->deskripsi_pekerjaan ?? $draft->ringkasan_ai,
            'jobdesk'        => $draft->jobdesk,
            'skill'          => $draft->keahlian_skill,
            'type'           => $draft->tipe_pekerjaan,
            'status'         => 'active',
            'nama'           => $draft->posisi,
            'email'          => $draft->email_perusahaan,
            'alamat'         => $draft->alamat_raw,
            'provinsi'       => $validatedRegionData['provinsi_id'] ?? null,
            'kabupaten'      => $validatedRegionData['kabupaten_id'] ?? null,
            'kecamatan'      => $validatedRegionData['kecamatan_id'] ?? null,
            'kelurahan'      => $validatedRegionData['kelurahan_id'] ?? null,
            'tanggal_awal'   => $draft->tanggal_posting ? $draft->tanggal_posting->format('Y-m-d') : now()->format('Y-m-d'),
            'tanggal_akhir'  => $draft->batas_pendaftaran ? $draft->batas_pendaftaran->format('Y-m-d') : null,
            'perusahaan_id'  => $perusahaan->id,
        ]);

        // 3. Update Status Draft
        $draft->update([
            'status_draft' => 'approved',
            'approved_by'  => auth()->id(),
        ]);

        return $loker;
    }
}
