<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassPricingModel extends Model
{
    use HasFactory;

    protected $table = 'class_pricing';

    protected $casts = [
        'price' => 'float',
        'promo' => 'integer',
        'promo_price' => 'float',
        'discount_value' => 'float',
        'gratis' => 'integer',
    ];

    protected $fillable = [
        'class_id',
        'price',
        'promo',
        'promo_price',
        'discount_type',
        'discount_value',
        'promo_start',
        'promo_end',
        'gratis',
        'cashback_persen',
        'cashback_nominal',
    ];

    public function membershipDiscounts(): HasMany
    {
        return $this->hasMany(ClassPricingMembershipDiscount::class, 'class_id', 'class_id');
    }

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
            $value = (float) ($this->discount_value ?? $this->promo_price ?? 0);
            $discount = ($this->discount_type ?? 'nominal') === 'percent'
                ? (float) $this->price * $value / 100
                : $value;

            return max(0, (float) $this->price - min((float) $this->price, $discount));
        }

        return (float) $this->price;
    }

}
