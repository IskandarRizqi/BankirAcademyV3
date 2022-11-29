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
		'no_invoice',
		'file',
		'jumlah',
		'kode_promo',
	];
	protected $appends = ['promo'];
	public function getPromoAttribute()
	{
		if (array_key_exists('kode_promo', $this->attributes)) {
			$kp = KodePromoModel::where('kode', $this->attributes['kode_promo'])->first();
			if ($kp) {
				return ($kp->nominal * $this->attributes['price_final']) / 100;
				// return $kp;
			}
		}
		return 0;
	}
}
