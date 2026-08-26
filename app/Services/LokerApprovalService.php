<?php

namespace App\Services;

use App\Models\LokerDraft;
use App\Models\LokerModel;
use App\Models\PerusahaanModel;
use Illuminate\Support\Facades\DB;

class LokerApprovalService
{
    private const DEFAULT_COMPANY_LOGO = '/Bank-academy-logo-03.png';

    public function approveAndPublish(int $draftId, array $options = []): LokerModel
    {
        return DB::transaction(function () use ($draftId, $options) {
            $draft = LokerDraft::whereKey($draftId)->lockForUpdate()->firstOrFail();

            if ($draft->status_draft !== 'pending') {
                abort(422, 'Draft loker ini sudah diproses.');
            }

            $companyName = $this->companyName($draft, $options);
            $companyAction = $options['company_action'] ?? 'create_new';
            $company = null;

            if ($companyAction === 'use_existing') {
                $company = PerusahaanModel::lockForUpdate()->findOrFail($options['company_id']);
            }

            if (! $company) {
                $company = new PerusahaanModel;
            }

            $company->fill([
                'nama' => $companyName,
                'email' => $draft->email_perusahaan,
                'alamat' => $draft->alamat_raw,
                'provinsi' => $draft->provinsi_id,
                'kabupaten' => $draft->kabupaten_id,
                'kecamatan' => $draft->kecamatan_id,
                'kelurahan' => $draft->kelurahan_id,
            ]);

            if (! filled($company->image)) {
                $company->image = json_encode([
                    'url' => self::DEFAULT_COMPANY_LOGO,
                    'size' => null,
                ]);
            }

            $company->save();

            $description = $draft->deskripsi_pekerjaan
                ?: $draft->ringkasan_ai
                ?: $draft->jobdesk
                ?: $draft->posisi;
            $jobdesk = $draft->jobdesk ?: $description;

            $loker = LokerModel::create([
                'user_id' => auth()->id(),
                'title' => $draft->posisi,
                'gaji_min' => $draft->gaji_min ?? 0,
                'gaji_max' => $draft->gaji_max ?? 0,
                'deskripsi' => $description,
                'jobdesk' => $jobdesk,
                'image' => $company->image,
                'skill' => json_encode($this->listValue($draft->keahlian_skill)),
                'type' => json_encode($this->listValue($draft->tipe_pekerjaan)),
                'status' => 0,
                'nama' => $draft->posisi,
                'email' => $draft->email_perusahaan,
                'alamat' => $draft->alamat_raw,
                'provinsi' => $draft->provinsi_id,
                'kabupaten' => $draft->kabupaten_id,
                'kecamatan' => $draft->kecamatan_id,
                'kelurahan' => $draft->kelurahan_id,
                'tanggal_awal' => $draft->tanggal_posting?->format('Y-m-d') ?: now()->format('Y-m-d'),
                'tanggal_akhir' => $draft->batas_pendaftaran?->format('Y-m-d'),
                'perusahaan_id' => $company->id,
            ]);

            $draft->update([
                'nama_perusahaan' => $companyName,
                'status_draft' => 'approved',
                'approved_by' => auth()->id(),
                'published_loker_id' => $loker->id,
                'published_perusahaan_id' => $company->id,
            ]);

            return $loker;
        });
    }

    private function companyName(LokerDraft $draft, array $options): string
    {
        if (($options['company_action'] ?? null) === 'use_existing') {
            return PerusahaanModel::whereKey($options['company_id'])->value('nama') ?: $draft->nama_perusahaan;
        }

        return trim((string) ($options['company_name'] ?? $draft->nama_perusahaan));
    }

    private function listValue($value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map('trim', $value)));
        }

        $decoded = json_decode((string) $value, true);
        if (is_array($decoded)) {
            return array_values(array_filter(array_map('trim', $decoded)));
        }

        return array_values(array_filter(array_map(
            'trim',
            preg_split('/[,;\r\n]+/', (string) $value, -1, PREG_SPLIT_NO_EMPTY)
        )));
    }
}
