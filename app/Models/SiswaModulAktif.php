<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiswaModulAktif extends Model
{
    // 1. Deklarasikan nama tabel secara eksplisit karena tidak menggunakan akhiran 's' jamak (plural)
    protected $table = 'siswa_modul_aktif';

    // 2. Tentukan kolom yang boleh diisi jika nanti ada proses insert/update
    protected $fillable = [
        'user_id',
        'class_id',
    ];

    /**
     * Relasi ke model User (Pemilik modul)
     */
    public function user(): BelongsTo
    {
        // Sesuaikan 'User::class' dengan namespace model User Anda (misal: \App\Models\User::class)
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke model Materi/Class
     */
    public function materi(): BelongsTo
    {
        // Menghubungkan ke MateriModel menggunakan foreign key 'class_id'
        return $this->belongsTo(MateriModel::class, 'class_id', 'id');
    }
}