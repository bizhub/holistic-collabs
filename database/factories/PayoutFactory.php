<?php

namespace Database\Factories;

use Domain\Clinic\Models\Clinic;
use Domain\Commission\Models\Payout;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Commission\Models\Payout>
 */
class PayoutFactory extends Factory
{
    protected $model = Payout::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clinic_id' => Clinic::factory(),

            'paid_until' => now(),
            'total_amount' => 0,
        ];
    }
}
