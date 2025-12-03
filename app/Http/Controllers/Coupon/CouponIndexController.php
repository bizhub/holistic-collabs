<?php

namespace App\Http\Controllers\Coupon;

use Inertia\Inertia;

class CouponIndexController
{
    public function __invoke()
    {
        return Inertia::render('Coupon/Coupons');
    }
}
