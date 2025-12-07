<?php

namespace Database\Factories;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Enums\CommissionStatus;
use Domain\Commission\Models\Commission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommissionFactory extends Factory
{
    protected $model = Commission::class;

    public function definition(): array
    {
        return [
            'clinic_id' => Clinic::factory(),
            'client_id' => Client::factory(),

            'amount' => $this->faker->numberBetween(500, 5000),

            'status' => CommissionStatus::Pending,
        ];
    }
}
