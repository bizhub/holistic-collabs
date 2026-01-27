<?php

namespace App\Http\Controllers\Admin\Payout;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Data\CommissionData;
use Domain\Commission\Data\PayoutData;
use Domain\Commission\Models\Payout;
use Inertia\Inertia;

class ShowPayoutController
{
    public function __invoke(Payout $payout)
    {
        $payout->loadMissing([
            'clinic',
            'commissions.client',
        ]);

        return Inertia::render('Admin/Payout/View', [
            'clinic' => ClinicData::from($payout->clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'commissions' => CommissionData::collect($payout->commissions),
            'payout' => PayoutData::from($payout),
        ]);
    }
}
