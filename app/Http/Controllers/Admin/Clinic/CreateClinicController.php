<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Coupon\Actions\GetAvailableCouponsFromShopifyAction;
use Inertia\Inertia;
use Inertia\Response;

class CreateClinicController
{
    public function __invoke(
        GetAvailableCouponsFromShopifyAction $getAvailableCouponsFromShopifyAction,
    ): Response {
        $availableCoupons = $getAvailableCouponsFromShopifyAction->execute();

        return Inertia::render('Admin/Clinic/ClinicForm', [
            'available_coupons' => $availableCoupons,
        ]);
    }
}
