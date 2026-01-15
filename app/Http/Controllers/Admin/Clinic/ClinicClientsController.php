<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Client\Data\ClientData;
use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class ClinicClientsController
{
    public function __invoke(Clinic $clinic)
    {
        $clients = $clinic
            ->clients()
            ->withCount('commissions')
            ->get();

        return Inertia::render('Admin/Clinic/Clients', [
            'clinic' => ClinicData::from($clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'clients' => ClientData::collect($clients),
        ]);
    }
}
