<?php

namespace App\Http\Controllers\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class EditClinicController
{
    public function __invoke(Clinic $clinic)
    {
        return Inertia::render('Clinic/ClinicForm', [
            'clinic' => ClinicData::from($clinic),
        ]);
    }
}
