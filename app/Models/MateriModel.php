<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MateriModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'materi';
    protected $fillable = [
        'id_kategori',
        'urutan',
        'nama',
        'keterangan',
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
}
