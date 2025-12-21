<?php

namespace App\Http\Controllers\Admin\Coupon;

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

        return Inertia::render('Admin/Coupon/Coupons', [
            'coupons' => CouponData::collect($coupons),
        ]);
    }
}
