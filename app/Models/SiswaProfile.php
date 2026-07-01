<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SiswaProfile extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'siswa_profiles';

    protected $fillable = [
        'user_id',
        'no_telp',
        'jenis_kelamin',
        'nisn',
        'kelas',
        'beasiswa',
        'alamat',
        'email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([   'user_id',
        'no_telp',
        'jenis_kelamin',
        'nisn',
        'kelas',
        'beasiswa',
        'alamat',
        'email']) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}