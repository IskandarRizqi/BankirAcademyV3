<?php

namespace App\Services;

use App\Models\LamaranModel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class CvAtsPdfService
{
    public function make(LamaranModel $cv, ?User $user = null)
    {
        $preparedCv = clone $cv;
        $preparedCv->setAttribute('pekerjaanperusahaan', $this->decodeList($cv->pekerjaanperusahaan));
        $preparedCv->setAttribute('pekerjaanjabatan', $this->decodeList($cv->pekerjaanjabatan));
        $preparedCv->setAttribute('pekerjaantahun', $this->decodeList($cv->pekerjaantahun));
        $preparedCv->setAttribute('pekerjaantanggungjawab', $this->decodeList($cv->pekerjaantanggungjawab, ';'));
        $preparedCv->setAttribute('pelatihannama', $this->decodeList($cv->pelatihannama));
        $preparedCv->setAttribute('pelatihanpenyelanggara', $this->decodeList($cv->pelatihanpenyelanggara));
        $preparedCv->setAttribute('pelatihantahun', $this->decodeList($cv->pelatihantahun));

        $user ??= $cv->user;

        return Pdf::loadView('compact.cvats_pdf', [
            'user' => $user,
            'lamaran' => $preparedCv,
        ])->setPaper('a4', 'portrait');
    }

    public function filename(LamaranModel $cv): string
    {
        $name = preg_replace('/[^A-Za-z0-9_-]+/', '_', (string) $cv->nama_lengkap);
        $name = trim((string) $name, '_');

        return 'CV_ATS_'.($name !== '' ? $name : 'Pelamar').'.pdf';
    }

    private function decodeList($value, string $separator = ','): array
    {
        if (is_array($value)) {
            return array_values($value);
        }

        $value = (string) $value;
        $decoded = json_decode($value, true);

        if (is_array($decoded)) {
            return array_values($decoded);
        }

        return $value === '' ? [] : array_map('trim', explode($separator, $value));
    }
}
