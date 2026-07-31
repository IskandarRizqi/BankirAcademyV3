<?php

namespace App\Services;

use App\Models\ClassesModel;
use App\Models\ClassPricingModel;
use App\Models\DataPayment;
use App\Models\User;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;

class ClassPricingService
{
    public const CLASS_CATEGORY_ONLINE = 0;

    public const CLASS_CATEGORY_OFFLINE = 1;

    public const MEMBERSHIP_INDIVIDUAL = 'individual';

    public const MEMBERSHIP_COMPANY = 'company';

    public const DISCOUNT_INDIVIDUAL_CLASS = 'individual_class';

    public const DISCOUNT_COMPANY_ONLINE = 'company_online';

    public const DISCOUNT_COMPANY_OFFLINE = 'company_offline';

    public const DISCOUNT_COMPANY_IHT = 'company_iht';

    public function resolve(ClassesModel $class, ?User $user = null): array
    {
        $pricing = ClassPricingModel::query()
            ->where('class_id', $class->id)
            ->first();

        return $this->resolvePricing($class, $pricing, $this->activeMembershipType($user));
    }

    public function resolvePricing(
        ClassesModel $class,
        ?ClassPricingModel $pricing,
        ?string $membershipType = null
    ): array {
        $basePrice = max(0, (float) ($pricing?->price ?? 0));
        $isIht = (int) $class->iht === 1;

        if ($pricing && ! $pricing->relationLoaded('membershipDiscounts')) {
            if (Schema::hasTable('class_pricing_membership_discounts')) {
                $pricing->load('membershipDiscounts');
            } else {
                $pricing->setRelation('membershipDiscounts', new Collection);
            }
        }

        if (! $pricing) {
            return $this->result($basePrice, 0, 0, $membershipType, null, $isIht, ! $isIht);
        }

        if ($pricing->isFree()) {
            return $this->result($basePrice, $basePrice, 0, $membershipType, 'free', $isIht, ! $isIht);
        }

        $generalDiscount = $isIht ? 0 : $this->generalDiscountAmount($pricing, $basePrice);
        $membershipDiscount = 0;
        $source = $generalDiscount > 0 ? 'general' : null;

        if ($isIht) {
            if ($membershipType === self::MEMBERSHIP_COMPANY) {
                $membershipDiscount = $this->membershipDiscountAmount(
                    $pricing,
                    self::MEMBERSHIP_COMPANY,
                    self::DISCOUNT_COMPANY_IHT,
                    $basePrice
                );
                $source = $membershipDiscount > 0 ? 'membership' : null;
            }
        } elseif ($membershipType === self::MEMBERSHIP_INDIVIDUAL) {
            $membershipDiscount = $this->membershipDiscountAmount(
                $pricing,
                self::MEMBERSHIP_INDIVIDUAL,
                self::DISCOUNT_INDIVIDUAL_CLASS,
                $basePrice
            );
            $total = min($basePrice * 0.15, $generalDiscount + $membershipDiscount);
            $membershipDiscount = max(0, $total - $generalDiscount);
            $source = $total > $generalDiscount ? 'membership' : ($generalDiscount > 0 ? 'general' : null);
        } elseif ($membershipType === self::MEMBERSHIP_COMPANY) {
            $category = $this->companyDiscountCategory($class);
            $configuredMembershipDiscount = $this->membershipDiscountAmount(
                $pricing,
                self::MEMBERSHIP_COMPANY,
                $category,
                $basePrice
            );
            $total = min($basePrice * 0.50, max($generalDiscount, $configuredMembershipDiscount));

            if ($configuredMembershipDiscount >= $generalDiscount) {
                $membershipDiscount = $total;
                $generalDiscount = 0;
                $source = $total > 0 ? 'membership' : null;
            } else {
                $membershipDiscount = 0;
                $generalDiscount = $total;
                $source = $total > 0 ? 'general' : null;
            }
        }

        $totalDiscount = min($basePrice, max(0, $generalDiscount + $membershipDiscount));

        return $this->result(
            $basePrice,
            $totalDiscount,
            $membershipDiscount,
            $membershipType,
            $source,
            $isIht,
            ! $isIht
        );
    }

    public function classType(ClassesModel $class): string
    {
        if ((int) $class->iht === 1) {
            return 'iht';
        }

        return (int) $class->kategori === self::CLASS_CATEGORY_OFFLINE
            ? 'offline'
            : 'online';
    }

    public function activeMembershipType(?User $user): ?string
    {
        if (! $user) {
            return null;
        }

        $profile = UserProfileModel::where('user_id', $user->id)->first();

        if (! $profile || (int) $profile->status_membership !== DataPayment::STATUS_PAID) {
            return null;
        }

        if ($profile->masa_aktif_membership && Carbon::parse($profile->masa_aktif_membership)->endOfDay()->isPast()) {
            return null;
        }

        return match ((int) $profile->tipe_membership) {
            DataPayment::MEMBERSHIP_TYPE_COMPANY => self::MEMBERSHIP_COMPANY,
            DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL => self::MEMBERSHIP_INDIVIDUAL,
            default => null,
        };
    }

    private function companyDiscountCategory(ClassesModel $class): string
    {
        return match ($this->classType($class)) {
            'iht' => self::DISCOUNT_COMPANY_IHT,
            'offline' => self::DISCOUNT_COMPANY_OFFLINE,
            default => self::DISCOUNT_COMPANY_ONLINE,
        };
    }

    private function generalDiscountAmount(ClassPricingModel $pricing, float $basePrice): float
    {
        if ((int) $pricing->promo !== 1) {
            return 0;
        }

        $type = $pricing->discount_type ?: 'nominal';
        $value = (float) ($pricing->discount_value ?? $pricing->promo_price ?? 0);

        $amount = $type === 'percent'
            ? $basePrice * min(15, max(0, $value)) / 100
            : max(0, $value);

        return min($basePrice * 0.15, $amount);
    }

    private function membershipDiscountAmount(
        ClassPricingModel $pricing,
        string $membershipType,
        string $category,
        float $basePrice
    ): float {
        $discount = $pricing->membershipDiscounts
            ->first(function ($item) use ($membershipType, $category) {
                return $item->membership_type === $membershipType
                    && $item->discount_category === $category;
            });

        if (! $discount) {
            return 0;
        }

        $maximum = $membershipType === self::MEMBERSHIP_COMPANY ? 50 : 15;
        $percent = min($maximum, max(0, (float) $discount->discount_percent));

        return $basePrice * $percent / 100;
    }

    private function result(
        float $basePrice,
        float $totalDiscount,
        float $membershipDiscount,
        ?string $membershipType,
        ?string $source,
        bool $isIht,
        bool $regularPurchaseAllowed
    ): array {
        $totalDiscount = min($basePrice, max(0, $totalDiscount));

        return [
            'base_price' => $basePrice,
            'general_discount' => max(0, $totalDiscount - $membershipDiscount),
            'membership_discount' => min($totalDiscount, max(0, $membershipDiscount)),
            'total_discount' => $totalDiscount,
            'discount_percent' => $basePrice > 0 ? ($totalDiscount / $basePrice) * 100 : 0,
            'final_price' => max(0, $basePrice - $totalDiscount),
            'membership_type' => $membershipType,
            'discount_source' => $source,
            'is_iht' => $isIht,
            'regular_purchase_allowed' => $regularPurchaseAllowed,
        ];
    }
}
