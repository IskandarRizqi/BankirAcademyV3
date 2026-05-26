<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiDompet extends Model
{
    use HasFactory;

    protected $table = 'mutasi_dompet';

    protected $fillable = [
        'user_id',
        'jenis',
        'jumlah',
        'class_id',
        'payment_id',
        'tipe_aksi',
        'referensi_id',
        'keterangan',
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