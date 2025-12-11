<?php

namespace Domain\Commission\Actions;

use Domain\Clinic\Models\Clinic;
use Domain\Coupon\Models\Coupon;
use Domain\Commission\Models\Commission;

class CreateCommissionAction
{
    public function execute(
        Clinic $clinic,
        ?Coupon $coupon = null,
        float $orderTotal = 0,
        bool $firstTime = false
    ): Commission {
        $baseAmount = $firstTime ? $orderTotal : $orderTotal - ($coupon->amount ?? 0);

        $commissionRate = 0.05;
        $commissionAmount = round($baseAmount * $commissionRate, 2);

        return Commission::create([
            'clinic_id' => $clinic->id,
            'coupon_id' => $firstTime ? null : $coupon->id,
            'amount' => $commissionAmount,
            'first_time' => $firstTime,
        ]);
    }
}
