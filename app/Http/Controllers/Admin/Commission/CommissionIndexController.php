<?php

namespace App\Http\Controllers\Admin\Commission;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class CommissionIndexController
{
    public function __invoke()
    {
        $clinics = Clinic::query()
            ->withCount('commissions')
            ->withSum('commissions', 'amount')
            ->get();

        return Inertia::render('Admin/Commission/Commissions', [
            'clinics' => ClinicData::collect($clinics),
        ]);
    }
}
