<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepotesModel extends Model
{
    use HasFactory;
    protected $table = 'prepotes';
    protected $fillable = [
        'class_id',
        'kelas_id',
        'pertanyaan',
        'jawaban',
        'status',
        'tanggal_awal',
        'tanggal_akhir',
    ];
}
