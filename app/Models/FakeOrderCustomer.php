<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeOrderCustomer extends Model
{
    use HasFactory;

    protected $table = 'fake_order_customer';

    protected $fillable = [
        'ip_address',
        'customer_name',
        'customer_city',
        'product_type',
        'product_id',
        'product_name',
        'display_date',
        'shown_at',
        'next_display_at',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'display_date' => 'date',
        'shown_at' => 'datetime',
        'next_display_at' => 'datetime',
    ];
}
