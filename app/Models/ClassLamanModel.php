<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassLamanModel extends Model
{
    use HasFactory;
    protected $table = 'class_laman';
    protected $fillable = [
        'title',
        'meta',
        'og',
        'content',
        'slug',
        'tag',
        'tgl_tayang',
        'tgl_expired',
        'type',
        'status',
        'banner',
        'no_urut'
    ];
}
