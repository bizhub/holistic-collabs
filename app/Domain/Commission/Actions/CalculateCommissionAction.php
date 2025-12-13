<?php

namespace Domain\Commission\Actions;

use Domain\Clinic\Models\Clinic;

class CalculateCommissionAction
{
    public function execute(
        Clinic $clinic,
        float $subtotal = 0,
        float $couponAmount = 0,
        bool $firstOrder = false,
    ): float {
        $commission = $subtotal * ($clinic->commission_rate / 100);

        if ($firstOrder) {
            $commission -= $couponAmount;
        }

        return max(0, round($commission, 2));
    }
}
