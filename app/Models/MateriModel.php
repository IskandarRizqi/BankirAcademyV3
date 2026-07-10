<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MateriModel extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'materi';
    protected $fillable = [
        'id_kategori',
        'urutan',
        'harga',
        'nama',
        'keterangan',
        'banner',          
    'icon',            
    'jumlah_peserta',  
    ];

    public function kategori(): HasOne
    {
        return $this->hasOne(KategoriModel::class, 'id', 'id_kategori');
    }

    public function subMateri(): HasMany
    {
        return $this->hasMany(SubMateriModel::class, 'id_materi', 'id');
    }
    public function preposttest(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(PreposttestModel::class, 'id_materi', 'id');
}
public function certificateTemplate()
{
    // Mengambil template certificate yang bertipe 'materi'
    return $this->hasOne(CertificateTemplate::class, 'materi_id')->where('target_type', 'materi');
}
 public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id_kategori',
        'urutan',
        'nama',
        'banner',          
    'icon',            
    'jumlah_peserta', 
        'harga',
        'keterangan']) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}
