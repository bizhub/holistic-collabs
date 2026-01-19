<?php

namespace Domain\Commission\Actions;

use Domain\Clinic\Models\Clinic;
use Domain\Commission\Data\CreatePayoutData;
use Domain\Commission\Models\Payout;

final class CreatePayoutAction
{
    public function execute(Clinic $clinic, CreatePayoutData $data): Payout
    {
        return Payout::create([
            'clinic_id' => $clinic->id,
            'paid_until' => $data->paid_until,
            'paid_at' => now(),
            'total_amount' => 0,
        ]);
    }
}
