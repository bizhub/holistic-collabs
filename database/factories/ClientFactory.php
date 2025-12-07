<?php

namespace Database\Factories;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'clinic_id' => Clinic::factory(),

            'shopify_id' => Uuid::uuid4(),

            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];
    }
}
