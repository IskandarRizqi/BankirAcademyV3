<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SubMateriModel extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'sub_materi';
    protected $fillable = [
        'nama',
        'link',
        'keterangan',
        'id_materi',
        'urutan',
        'tipe_link',
        'tipe_beasiswa',
        'masa_aktif',
        'harga',
        'diskon',
        'harga_final',
    ];

    public function materi(): HasOne
    {
        return $this->hasOne(MateriModel::class, 'id', 'id_materi');
    }
    public function items()
    {
        return $this->hasMany(SubMateriItemModel::class, 'id_sub_materi');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama',
        'link',
        'keterangan',
        'id_materi',
        'urutan',
        'tipe_link',
        'tipe_beasiswa',
        'masa_aktif',
        'harga',
        'diskon',
        'harga_final',])
            ->logOnlyDirty();
    }
}
