<?php

use App\Http\Controllers\Admin\Commission\CommissionIndexController;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Models\Commission;
use Domain\Commission\Models\Payout;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the commission index page with clinics', function () {
    actingAsAdmin();

    $clinicWithCommissions = Clinic::factory()->create();
    $clinicWithoutCommissions = Clinic::factory()->create();

    // commissions with payout_id = null
    Commission::factory()->count(2)
        ->for($clinicWithCommissions)
        ->create(['payout_id' => null, 'amount' => 100]);

    // commission with payout_id set (should be ignored)
    Commission::factory()->count(1)
        ->for($clinicWithCommissions)
        ->create(['payout_id' => Payout::factory()->create()->id, 'amount' => 50]);

    // commissions for a clinic with no null payouts (should be ignored)
    Commission::factory()->count(3)
        ->for($clinicWithoutCommissions)
        ->create(['payout_id' => Payout::factory()->create()->id, 'amount' => 200]);

    $response = $this->get(action(CommissionIndexController::class));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) =>
        $page
            ->component('Admin/Commission/Commissions')
            ->has('clinics', 1) // only clinicWithCommissions passes the filter
            ->has('clinics.0', fn (Assert $clinic) =>
                $clinic
                    ->where('commissions_count', 2)
                    ->where('commissions_sum_amount', 20000)
                    ->has('coupons') // can be null or empty
                    ->has('clients_count')
                    ->has('users_count')
                    ->etc()
            )
    );
});
