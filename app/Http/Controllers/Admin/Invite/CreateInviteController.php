<?php

namespace App\Http\Controllers\Admin\Invite;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class CreateInviteController
{
    public function __invoke()
    {
        $clinics = Clinic::all();

        return Inertia::render('Admin/Invite/InviteForm', [
            'clinics' => ClinicData::collect($clinics),
        ]);
    }
}
