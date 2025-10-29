<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRekeningModel extends Model
{
    use HasFactory;
    protected $table = 'data_rekening';
    protected $fillable = [
        'user_id',
        'nama_bank',
        'no_rekening',
    ];
}
