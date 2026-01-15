<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Data\CommissionData;
use Domain\Commission\Enums\CommissionStatus;
use Inertia\Inertia;

class ClinicCommissionsController
{
    public function __invoke(Clinic $clinic)
    {
        $commissions = $clinic
            ->commissions()
            ->where('status', CommissionStatus::Pending)
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Clinic/Commissions', [
            'clinic' => ClinicData::from($clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'commissions' => CommissionData::collect($commissions),
        ]);
    }
}
