<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPricingMembershipDiscount extends Model
{
    use HasFactory;

    protected $table = 'class_pricing_membership_discounts';

    protected $fillable = [
        'class_id',
        'membership_type',
        'discount_category',
        'discount_percent',
    ];

    protected $casts = [
        'class_id' => 'integer',
        'discount_percent' => 'float',
    ];
}
