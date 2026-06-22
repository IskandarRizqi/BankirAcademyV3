<?php

namespace App\Imports;

use App\Models\User;
use App\Models\SiswaProfile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SiswaImport implements WithMultipleSheets
{
    protected $bankId;
    protected $sekolahId;

    // Terima parameter bank dan sekolah dari Controller
    public function __construct($bankId = null, $sekolahId = null)
    {
        $this->bankId = $bankId;
        $this->sekolahId = $sekolahId;
    }

    public function sheets(): array
    {
        return [
            'Non Beasiswa' => new SiswaSheetImport(false, $this->bankId, $this->sekolahId),
            'Beasiswa' => new SiswaSheetImport(true, $this->bankId, $this->sekolahId),
        ];
    }
}

class SiswaSheetImport implements ToCollection, WithHeadingRow
{
    private $isBeasiswa;
    private $bankId;
    private $sekolahId;

    public function __construct($isBeasiswa, $bankId, $sekolahId)
    {
        $this->isBeasiswa = $isBeasiswa;
        $this->bankId = $bankId;
        $this->sekolahId = $sekolahId;
    }

    public function collection(Collection $rows)
    {
        $authUser = auth()->user();
        $authRole = (int) $authUser->role;
        $authEmail = $authUser->email;

        // Penentuan Bank & Sekolah secara dinamis berdasarkan siapa yang login
        $finalBankId = null;
        $finalSekolahId = null;

        if ($authEmail === 'cb@bankir.academy') {
            $finalBankId = $this->bankId;
            $finalSekolahId = $this->sekolahId;
        } else if ($authRole === 4) {
            $finalBankId = $authUser->id;
            $finalSekolahId = $this->sekolahId;
        } else if ($authRole === 5) {
            $finalBankId = $authUser->bank_id;
            $finalSekolahId = $authUser->id;
        }

        // 1. Ambil Limit Siswa & Limit Beasiswa dari Membership Bank Pembina
        $targetBank = User::find($finalBankId);
        $limitSiswa = null;
        $limitBeasiswa = null;

        if ($targetBank && $targetBank->membership_id) {
            $membership = $targetBank->membership; // Pastikan relasi 'membership' ada di model User
            if ($membership) {
                $limitSiswa = !is_null($membership->limit_siswa) ? (int)$membership->limit_siswa : null;
                $limitBeasiswa = !is_null($membership->limit_beasiswa) ? (int)$membership->limit_beasiswa : null;
            }
        }

        foreach ($rows as $row) {
            if (empty($row['nisn']) || empty($row['nama'])) {
                continue;
            }

            $nisn = trim($row['nisn']);
            $email = $nisn . '@gmail.com';

            // Cek duplikat email/NISN
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                continue; 
            }

            // 2. Proteksi Kouta Global / Limit Siswa Umum
            if (!is_null($limitSiswa)) {
                $currentSiswaCount = User::where('role', 6)
                                        ->where('sekolah_id', $finalSekolahId)
                                        ->count();

                if ($currentSiswaCount >= $limitSiswa) {
                    throw new \Exception('Gagal import! Batas maksimal pendaftaran siswa untuk sekolah tujuan (' . $limitSiswa . ' siswa) telah tercapai sesuai paket membership Bank.');
                }
            }

            // 3. Proteksi Tambahan: Limit Beasiswa (Hanya berjalan jika sheet yang di-import adalah sheet Beasiswa)
            if ($this->isBeasiswa && !is_null($limitBeasiswa)) {
                // Hitung siswa di sekolah ini yang profilnya diset beasiswa = true/1
                $currentBeasiswaCount = \App\Models\SiswaProfile::where('beasiswa', true)
                    ->whereHas('user', function($query) use ($finalSekolahId) {
                        $query->where('sekolah_id', $finalSekolahId);
                    })->count();

                if ($currentBeasiswaCount >= $limitBeasiswa) {
                    throw new \Exception('Gagal import pada sheet Beasiswa! Batas maksimal kuota beasiswa untuk sekolah tujuan (' . $limitBeasiswa . ' siswa) telah habis.');
                }
            }

            // 4. Buat User Siswa
            $passwordSiswa = $nisn . 'Bankir!';
            
            $user = User::create([
                'name' => $row['nama'],
                'email' => $email,
                'role' => 6,
                'password' => Hash::make($passwordSiswa),
                'bank_id' => $finalBankId,
                'sekolah_id' => $finalSekolahId,
            ]);

            // 5. Buat Profil Siswa
            SiswaProfile::create([
                'user_id' => $user->id,
                'no_telp' => $row['no_telepon'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'nisn' => $nisn,
                'kelas' => $row['kelas'] ?? null,
                'beasiswa' => $this->isBeasiswa, // true jika sheet Beasiswa, false jika Non Beasiswa
            ]);
        }
    }
}