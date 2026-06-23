<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreposttestModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'preposttest';
    protected $fillable = [
        'id_materi',
        'id_submateri',
        'soal',
        'judul',
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
}
