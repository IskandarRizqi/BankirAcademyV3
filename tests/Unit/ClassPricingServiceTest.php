<?php

namespace Tests\Unit;

use App\Models\ClassesModel;
use App\Models\ClassPricingMembershipDiscount;
use App\Models\ClassPricingModel;
use App\Services\ClassPricingService;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class ClassPricingServiceTest extends TestCase
{
    private ClassPricingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ClassPricingService;
    }

    public function test_individual_discount_is_stackable_but_capped_at_fifteen_percent(): void
    {
        $class = $this->class();
        $pricing = $this->pricing(10000000, 10, [
            ['membership_type' => 'individual', 'discount_category' => 'individual_class', 'discount_percent' => 5],
        ]);

        $result = $this->service->resolvePricing($class, $pricing, ClassPricingService::MEMBERSHIP_INDIVIDUAL);

        $this->assertSame(1500000.0, $result['total_discount']);
        $this->assertSame(8500000.0, $result['final_price']);
        $this->assertSame(15.0, $result['discount_percent']);
    }

    public function test_company_uses_the_larger_discount_without_stacking(): void
    {
        $class = $this->class();
        $pricing = $this->pricing(10000000, 15, [
            ['membership_type' => 'company', 'discount_category' => 'company_online', 'discount_percent' => 20],
        ]);

        $result = $this->service->resolvePricing($class, $pricing, ClassPricingService::MEMBERSHIP_COMPANY);

        $this->assertSame(2000000.0, $result['total_discount']);
        $this->assertSame(8000000.0, $result['final_price']);
        $this->assertSame('membership', $result['discount_source']);
    }

    public function test_company_discount_is_capped_at_fifty_percent(): void
    {
        $class = $this->class();
        $pricing = $this->pricing(10000000, 15, [
            ['membership_type' => 'company', 'discount_category' => 'company_online', 'discount_percent' => 75],
        ]);

        $result = $this->service->resolvePricing($class, $pricing, ClassPricingService::MEMBERSHIP_COMPANY);

        $this->assertSame(5000000.0, $result['total_discount']);
        $this->assertSame(5000000.0, $result['final_price']);
    }

    public function test_iht_only_uses_company_iht_discount_and_is_not_regularly_purchasable(): void
    {
        $class = $this->class(['iht' => 1, 'kategori' => 1]);
        $pricing = $this->pricing(10000000, 15, [
            ['membership_type' => 'individual', 'discount_category' => 'individual_class', 'discount_percent' => 15],
            ['membership_type' => 'company', 'discount_category' => 'company_iht', 'discount_percent' => 50],
        ]);

        $result = $this->service->resolvePricing($class, $pricing, ClassPricingService::MEMBERSHIP_COMPANY);

        $this->assertSame('iht', $this->service->classType($class));
        $this->assertSame(5000000.0, $result['final_price']);
        $this->assertFalse($result['regular_purchase_allowed']);
    }

    public function test_user_without_membership_only_gets_general_discount(): void
    {
        $class = $this->class();
        $pricing = $this->pricing(10000000, 15, [
            ['membership_type' => 'individual', 'discount_category' => 'individual_class', 'discount_percent' => 15],
        ]);

        $result = $this->service->resolvePricing($class, $pricing);

        $this->assertSame(1500000.0, $result['total_discount']);
        $this->assertSame(8500000.0, $result['final_price']);
        $this->assertNull($result['membership_type']);
    }

    private function class(array $attributes = []): ClassesModel
    {
        return new ClassesModel(array_merge([
            'id' => 1,
            'iht' => 0,
            'kategori' => 0,
        ], $attributes));
    }

    private function pricing(float $price, float $generalPercent, array $discounts): ClassPricingModel
    {
        $pricing = new ClassPricingModel([
            'class_id' => 1,
            'price' => $price,
            'promo' => 1,
            'promo_price' => $price * $generalPercent / 100,
            'discount_type' => 'percent',
            'discount_value' => $generalPercent,
            'gratis' => 0,
        ]);

        $pricing->setRelation(
            'membershipDiscounts',
            new Collection(array_map(
                fn (array $discount) => new ClassPricingMembershipDiscount($discount),
                $discounts
            ))
        );

        return $pricing;
    }
}
