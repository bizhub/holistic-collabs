<?php

namespace App\Http\Controllers\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class ClinicIndexController
{
    public function __invoke()
    {
        $clinics = Clinic::query()
            ->with('coupons')
            ->get();

        return Inertia::render('Clinic/Clinics', [
            'clinics' => ClinicData::collect($clinics),
        ]);
    }
}
