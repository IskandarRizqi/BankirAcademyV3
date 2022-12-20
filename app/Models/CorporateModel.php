<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateModel extends Model
{
    use HasFactory;
    protected $table = 'corporate';
    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
    ];
}
