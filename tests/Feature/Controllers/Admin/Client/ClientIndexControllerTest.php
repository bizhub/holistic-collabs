<?php

use App\Http\Controllers\Admin\Client\ClientIndexController;
use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Models\Commission;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the client index page with clients', function () {
    actingAsAdmin();

    $clinic = Clinic::factory()->create();

    $clients = Client::factory()
        ->count(2)
        ->for($clinic)
        ->create();

    Commission::factory()->count(3)->for($clients[0])->create();
    Commission::factory()->count(1)->for($clients[1])->create();

    $response = $this->get(action(ClientIndexController::class));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) =>
        $page
            ->component('Admin/Client/Clients')
            ->has('clients', 2)
            ->has('clients.0', fn (Assert $client) =>
                $client
                    ->has('id')
                    ->has('clinic')
                    ->has('commissions_count')
                    ->etc()
            )
    );
});
