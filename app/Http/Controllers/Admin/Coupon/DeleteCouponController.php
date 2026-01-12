<?php

namespace App\Http\Controllers\Admin\Coupon;

use Domain\Coupon\Models\Coupon;
use Inertia\Inertia;

class DeleteCouponController
{
    public function __invoke(Coupon $coupon)
    {
        $coupon->delete();

        Inertia::flash('success', 'Coupon deleted');

        return back();
    }
}
