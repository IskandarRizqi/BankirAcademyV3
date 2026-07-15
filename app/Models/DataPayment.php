<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPayment extends Model
{
    use HasFactory;

    protected $table = 'datapayment';

    protected $fillable = [
        'no_invoice',
        'user_id',
        'class_id',
        'pembelian',
        'nominal',
        'expired',
        'qty',
        'status',
        'keterangan',
        'link_payment',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'class_id' => 'integer',
        'nominal' => 'float',
        'expired' => 'integer',
        'qty' => 'float',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
