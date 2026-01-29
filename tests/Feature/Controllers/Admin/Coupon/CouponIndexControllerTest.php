<?php

use App\Http\Controllers\Admin\Coupon\CouponIndexController;
use Domain\Clinic\Models\Clinic;
use Domain\Coupon\Models\Coupon;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the coupon index page with coupons', function () {
    actingAsAdmin();

    $clinic = Clinic::factory()->create();

    Coupon::factory()
        ->count(3)
        ->for($clinic)
        ->create();

    $response = $this->get(action(CouponIndexController::class));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) =>
        $page
            ->component('Admin/Coupon/Coupons')
            ->has('coupons', 3)
            ->has('coupons.0', fn (Assert $coupon) =>
                $coupon
                    ->has('clinic')
                    ->has('commissions_count')
                    ->etc()
            )
    );
});
