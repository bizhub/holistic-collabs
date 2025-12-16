<?php

namespace App\Http\Controllers\Coupon;

use Domain\Coupon\Data\CouponData;
use Domain\Coupon\Models\Coupon;
use Inertia\Inertia;

class CouponIndexController
{
    public function __invoke()
    {
        $coupons = Coupon::query()
            ->with('clinic')
            ->withCount('commissions')
            ->get();

        return Inertia::render('Coupon/Coupons', [
            'coupons' => CouponData::collect($coupons),
        ]);
    }
}
