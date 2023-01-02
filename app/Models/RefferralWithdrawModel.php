<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefferralWithdrawModel extends Model
{
    use HasFactory;
    protected $table = 'refferral_withdraw';
    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'nama_bank',
        'no_rekening',
        'date',
        'acc_amount',
        'acc_date',
        'keterangan',
    ];
}
