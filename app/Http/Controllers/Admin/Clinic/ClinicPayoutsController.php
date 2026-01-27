<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Data\PayoutData;
use Inertia\Inertia;

class ClinicPayoutsController
{
    public function __invoke(Clinic $clinic)
    {
        $payouts = $clinic
            ->payouts()
            ->with('clinic')
            ->get();

        return Inertia::render('Admin/Clinic/Payouts', [
            'clinic' => ClinicData::from($clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'payouts' => PayoutData::collect($payouts),
        ]);
    }
}
