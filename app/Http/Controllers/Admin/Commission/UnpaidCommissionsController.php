<?php

namespace App\Http\Controllers\Admin\Commission;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Data\CommissionData;
use Domain\Commission\Enums\CommissionStatus;
use Domain\Commission\Models\Commission;
use Inertia\Inertia;

class UnpaidCommissionsController
{
    public function __invoke(Clinic $clinic)
    {
        $commissions = $clinic
            ->commissions()
            ->where('status', CommissionStatus::Pending)
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Commission/Commissions', [
            'clinic' => ClinicData::from($clinic),
            'commissions' => CommissionData::collect($commissions),
        ]);
    }
}
