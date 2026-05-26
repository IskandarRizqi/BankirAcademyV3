<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanDana extends Model
{
    use HasFactory;

    protected $table = 'penarikan_dana';

    protected $fillable = [
        'user_id',
        'jumlah',
        'bank_tujuan',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'jumlah' => 'float',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}