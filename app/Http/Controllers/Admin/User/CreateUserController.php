<?php

namespace App\Http\Controllers\Admin\User;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class CreateUserController
{
    public function __invoke()
    {
        $clinics = Clinic::query()
            ->orderBy('name')
            ->get();

        return Inertia::render('Admin/User/UserForm', [
            'clinics' => ClinicData::collect($clinics),
        ]);
    }
}
