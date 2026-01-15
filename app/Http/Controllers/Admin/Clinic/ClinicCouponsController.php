<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Coupon\Data\CouponData;
use Inertia\Inertia;

class ClinicCouponsController
{
    public function __invoke(Clinic $clinic)
    {
        $coupons = $clinic
            ->coupons()
            ->withCount('commissions')
            ->get();

        return Inertia::render('Admin/Clinic/Coupons', [
            'clinic' => ClinicData::from($clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'coupons' => CouponData::collect($coupons),
        ]);
    }
}
