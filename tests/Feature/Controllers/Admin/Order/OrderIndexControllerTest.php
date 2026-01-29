<?php

use App\Http\Controllers\Admin\Order\OrderIndexController;
use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Order\Models\Order;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the order index page with orders', function () {
    actingAsAdmin();

    $clinic = Clinic::factory()->create();
    $client = Client::factory()->for($clinic)->create();

    Order::factory()
        ->count(3)
        ->for($clinic)
        ->for($client)
        ->create();

    $response = $this->get(action(OrderIndexController::class));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) =>
        $page
            ->component('Admin/Order/Orders')
            ->has('orders', 3)
            ->has('orders.0', fn (Assert $order) =>
                $order
                    ->has('id')
                    ->has('clinic')
                    ->has('client')
                    ->has('created_at')
                    ->etc()
            )
    );
});
