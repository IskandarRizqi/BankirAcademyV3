<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori';
    protected $fillable = [
        'nama'
    ];

    public function materi(): HasMany
    {
        return $this->hasMany(MateriModel::class, 'id_kategori', 'id');
    }
}
