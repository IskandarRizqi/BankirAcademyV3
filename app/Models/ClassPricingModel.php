<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPricingModel extends Model
{
	use HasFactory;
	protected $table = 'class_pricing';

	protected $casts = [
		'price' => 'float',
		'promo' => 'integer',
		'promo_price' => 'float',
		'gratis' => 'integer',
	];

	protected $fillable = [
		'class_id',
		'price',
		'promo',
		'promo_price',
		'promo_start',
		'promo_end',
		'gratis',
		'cashback_persen',
		'cashback_nominal',
	];

	public function isFree(): bool
	{
		return (int) $this->gratis === 1;
	}

	public function effectivePrice(): float
	{
		if ($this->isFree()) {
			return 0;
		}

		if ((int) $this->promo === 1) {
			return max(0, (float) $this->price - (float) $this->promo_price);
		}

		return (float) $this->price;
	}
}
