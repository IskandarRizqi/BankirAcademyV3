<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepotesUserModel extends Model
{
    use HasFactory;
    protected $table = 'prepotes_user';
    protected $fillable = [
        'class_id',
        'user_id',
        'jawaban',
        'nilai_awal',
        'nilai_akhir',
        'jml_jawaban',
    ];
}
