<?php

namespace App\Http\Controllers\Clinic;

use Domain\Coupon\Actions\GetAvailableCouponsFromShopifyAction;
use Inertia\Inertia;
use Inertia\Response;

class CreateClinicController
{
    public function __invoke(
        GetAvailableCouponsFromShopifyAction $getAvailableCouponsFromShopifyAction,
    ): Response {
        $availableCoupons = $getAvailableCouponsFromShopifyAction->execute();

        return Inertia::render('Clinic/ClinicForm', [
            'available_coupons' => $availableCoupons,
        ]);
    }
}
