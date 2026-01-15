<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\User\Data\UserData;
use Inertia\Inertia;

class ClinicUsersController
{
    public function __invoke(Clinic $clinic)
    {
        $users = $clinic
            ->users()
            ->get();

        return Inertia::render('Admin/Clinic/Users', [
            'clinic' => ClinicData::from($clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'users' => UserData::collect($users),
        ]);
    }
}
