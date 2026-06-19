<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMateriModel extends Model
{
    use HasFactory, SoftDeletes;

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
}
