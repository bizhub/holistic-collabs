<?php

namespace Domain\Commission\Actions;

use Domain\Clinic\Models\Clinic;
use Domain\Commission\Data\CreatePayoutData;
use Domain\Commission\Models\Commission;
use Domain\Commission\Models\Payout;

final class CreatePayoutAction
{
    public function execute(Clinic $clinic, CreatePayoutData $data): ?Payout
    {
        $commissions = Commission::query()
            ->where('clinic_id', $clinic->id)
            ->whereNull('payout_id')
            ->where('created_at', '<=', $data->paid_until)
            ->get();

        if ($commissions->count() == 0) {
            return null;
        }

        return Payout::create([
            'clinic_id' => $clinic->id,
            'paid_until' => $data->paid_until,
            'paid_at' => now(),
            'total_amount' => $commissions->sum('amount'),
        ]);
    }
}
