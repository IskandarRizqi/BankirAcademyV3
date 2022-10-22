<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPaymentModel extends Model
{
	use HasFactory;
	protected $table = 'class_payment';
	protected $fillable = [
		'status',
		'user_id',
		'class_id',
		'unique_code',
		'price',
		'price_final',
		'expired',
		'no_invoice'
	];
}
