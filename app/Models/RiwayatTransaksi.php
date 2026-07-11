<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RiwayatTransaksi extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'riwayat_transaksi';

    protected $fillable = [
        'user_id',
        'class_id',
        'nominal_transaksi',
        'metode_pembayaran',
        'status',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function materi()
    {
        return $this->belongsTo(MateriModel::class, 'class_id');
    }
     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([ 'user_id',
        'class_id',
        'nominal_transaksi',
        'metode_pembayaran',
        'status',
        'keterangan']) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}