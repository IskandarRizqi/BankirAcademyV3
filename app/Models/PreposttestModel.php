<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PreposttestModel extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'preposttest';
    protected $fillable = [
        'id_materi',
        'id_submateri',
        'soal',
        'judul',
        'tipe_prepost'
    ];

    protected $casts = [
        'soal' => 'array',
    ];

    public function materi(): HasOne
    {
        return $this->hasOne(MateriModel::class, 'id', 'id_materi');
    }
    public function submateri(): HasOne
    {
        return $this->hasOne(SubMateriModel::class, 'id', 'id_submateri');
    }
     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([ 'id_materi',
        'id_submateri',
        'soal',
        'judul',
        'tipe_prepost']) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}
