<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Membership extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'nama', 'harga', 'diskon', 'harga_final', 
        'limit_siswa', 'limit_beasiswa', 'masa_hingga', 'gambar', 'saldo_siswa', 'limit_video'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([ 'nama', 'harga', 'diskon', 'harga_final', 
        'limit_siswa', 'limit_beasiswa', 'masa_hingga', 'gambar', 'saldo_siswa', 'limit_video']) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}