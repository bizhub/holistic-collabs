<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class ClinicIndexController
{
    public function __invoke()
    {
        $clinics = Clinic::query()
            ->with('coupons')
            ->withCount([
                'commissions',
                'clients',
            ])
            ->get();

        return Inertia::render('Admin/Clinic/Clinics', [
            'clinics' => ClinicData::collect($clinics),
        ]);
    }
}
