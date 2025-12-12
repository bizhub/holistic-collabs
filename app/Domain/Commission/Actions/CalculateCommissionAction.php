<?php

namespace Domain\Commission\Actions;

use Domain\Clinic\Models\Clinic;

class CalculateCommissionAction
{
    public function execute(
        Clinic $clinic,
        float $total = 0,
    ): float {
        return round($total * ($clinic->commission_rate / 100), 2);
    }
}
