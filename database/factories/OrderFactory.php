<?php

namespace Database\Factories;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Order\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clinic_id' => Clinic::factory(),
            'client_id' => Client::factory(),

            'shopify_id' => $this->faker->unique()->uuid,
            'order_number' => '::order_number::',
            'subtotal_price' => 0,
        ];
    }
}
