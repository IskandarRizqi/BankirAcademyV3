<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class KategoriModel extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'kategori';
    protected $fillable = [
        'nama'
    ];

    public function materi(): HasMany
    {
        return $this->hasMany(MateriModel::class, 'id_kategori', 'id');
    }
     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama']) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}
