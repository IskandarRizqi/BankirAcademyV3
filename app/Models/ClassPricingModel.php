<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPricingModel extends Model
{
    use HasFactory;
	protected $table = 'class_pricing';
	protected $fillable = [
		'class_id',
		'price',
		'promo',
		'promo_price',
		'promo_start',
		'promo_end',
	];
}
