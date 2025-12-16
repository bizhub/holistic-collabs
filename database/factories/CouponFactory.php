<?php

namespace Database\Factories;

use Domain\Clinic\Models\Clinic;
use Domain\Coupon\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Coupon\Models\Coupon>
 */
class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        return [
            'clinic_id' => Clinic::factory(),

            'shopify_id' => Uuid::uuid4(),
            'code' => 'TEST',
        ];
    }
}
