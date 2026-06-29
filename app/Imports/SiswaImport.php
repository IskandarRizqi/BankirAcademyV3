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
    
    // Properti untuk menyimpan instance sheet
    public $sheetInstances = [];

    public function __construct($bankId = null, $sekolahId = null)
    {
        $this->bankId = $bankId;
        $this->sekolahId = $sekolahId;
    }

    public function sheets(): array
    {
        $this->sheetInstances = [
            'Non Beasiswa' => new SiswaSheetImport(false, $this->bankId, $this->sekolahId),
            'Beasiswa' => new SiswaSheetImport(true, $this->bankId, $this->sekolahId),
        ];

        return $this->sheetInstances;
    }
}

class SiswaSheetImport implements ToCollection, WithHeadingRow
{
    private $isBeasiswa;
    private $bankId;
    private $sekolahId;
    
    public $successCount = 0;
    public $errors = [];

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

        $targetBank = User::find($finalBankId);
        $limitSiswa = null;
        $limitBeasiswa = null;

        if ($targetBank && $targetBank->membership_id) {
            $membership = $targetBank->membership; 
            if ($membership) {
                $limitSiswa = !is_null($membership->limit_siswa) ? (int)$membership->limit_siswa : null;
                $limitBeasiswa = !is_null($membership->limit_beasiswa) ? (int)$membership->limit_beasiswa : null;
            }
        }

        $currentSiswaCount = User::where('role', 6)->where('sekolah_id', $finalSekolahId)->count();
        $currentBeasiswaCount = SiswaProfile::where('beasiswa', true)
            ->whereHas('user', function($query) use ($finalSekolahId) {
                $query->where('sekolah_id', $finalSekolahId);
            })->count();

        $sheetName = $this->isBeasiswa ? 'Beasiswa' : 'Non Beasiswa';

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; 

            if (empty($row['nisn']) || empty($row['nama'])) {
                continue;
            }

            // 1. Cek Kuota Siswa Umum
            if (!is_null($limitSiswa) && $currentSiswaCount >= $limitSiswa) {
                $this->errors[] = "Gagal import file! Kuota maksimal siswa untuk sekolah ini ({$limitSiswa} siswa) sudah penuh. Tidak ada data yang disimpan.";
                break; 
            }

            // 2. Cek Kuota Siswa Beasiswa
            if ($this->isBeasiswa && !is_null($limitBeasiswa) && $currentBeasiswaCount >= $limitBeasiswa) {
                $this->errors[] = "Gagal import file! Kuota beasiswa untuk sekolah ini ({$limitBeasiswa} siswa) sudah penuh. Tidak ada data yang disimpan.";
                break; 
            }

            $nisn = trim($row['nisn']);
            // Email ini TETAP digunakan untuk username login di tabel users
            $loginEmail = $nisn . '@gmail.com'; 

            // 3. Cek Duplikat NISN via loginEmail
            $existingUser = User::where('email', $loginEmail)->first();
            if ($existingUser) {
                $this->errors[] = "Sheet {$sheetName} (Baris {$rowNumber}): NISN {$nisn} sudah terdaftar. Proses import dibatalkan seluruhnya.";
                continue; 
            }

            $passwordSiswa = $nisn . 'Bankir!';
            
            // Simpan ke tabel users (untuk kebutuhan login)
            $user = User::create([
                'name' => $row['nama'],
                'email' => $loginEmail, // Tetap format nisn@gmail.com
                'role' => 6,
                'password' => Hash::make($passwordSiswa),
                'bank_id' => $finalBankId,
                'sekolah_id' => $finalSekolahId,
            ]);

            // Simpan ke tabel siswa_profiles (termasuk email asli siswa & alamat dari excel)
            SiswaProfile::create([
                'user_id' => $user->id,
                'no_telp' => $row['no_telepon'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'nisn' => $nisn,
                'kelas' => $row['kelas'] ?? null,
                'beasiswa' => $this->isBeasiswa,
                'alamat' => $row['alamat'] ?? null, // <-- Tambahan kolom alamat
                'email' => $row['email'] ?? null,   // <-- Tambahan kolom email asli siswa
            ]);

            $this->successCount++;
            $currentSiswaCount++;
            if ($this->isBeasiswa) {
                $currentBeasiswaCount++;
            }
        }
    }
}