<?php

namespace App\Http\Controllers\Admin\Payout;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Data\CommissionData;
use Domain\Commission\Models\Commission;
use Inertia\Inertia;

class CreatePayoutController
{
    public function __invoke(Clinic $clinic)
    {
        $commissions = Commission::query()
            ->with('client')
            ->where('clinic_id', $clinic->id)
            ->whereNull('payout_id')
            ->where('created_at', '<=', now())
            ->orderByDesc('created_at')
            ->get();

        // dd(
        //     (string)$commissions->first()->created_at,
        //     $commissions->first()->created_at,
        // );

        return Inertia::render('Admin/Payout/CreatePayout', [
            'clinic' => ClinicData::from($clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'commissions' => CommissionData::collect($commissions),
            'paid_until' => now(),
        ]);
    }
}
