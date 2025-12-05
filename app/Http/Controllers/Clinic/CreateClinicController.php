<?php

namespace App\Http\Controllers\Clinic;

use Inertia\Inertia;

class CreateClinicController
{
    public function __invoke()
    {
        return Inertia::render('Clinic/ClinicForm');
    }
}
