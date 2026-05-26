<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dompet extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit karena Laravel default-nya mendeteksi jamak (dompets)
    protected $table = 'dompet';

    protected $fillable = [
        'user_id',
        'saldo',
    ];

    // Mengubah string dari database otomatis menjadi float/double di PHP
    protected $casts = [
        'saldo' => 'float',
    ];

    /**
     * Relasi Balik ke User (Dompet ini milik siapa?)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}