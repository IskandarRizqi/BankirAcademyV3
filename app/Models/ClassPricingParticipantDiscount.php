<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPricingParticipantDiscount extends Model
{
    use HasFactory;

    protected $table = 'class_pricing_participant_discounts';

    protected $fillable = [
        'class_id',
        'minimum_participants',
        'discount_amount',
    ];

    protected $casts = [
        'class_id' => 'integer',
        'minimum_participants' => 'integer',
        'discount_amount' => 'float',
    ];
}
