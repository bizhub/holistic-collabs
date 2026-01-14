<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Invite\Data\InviteData;
use Inertia\Inertia;

class ClinicInvitesController
{
    public function __invoke(Clinic $clinic)
    {
        $invites = $clinic
            ->invites()
            ->get();

        return Inertia::render('Admin/Clinic/Invites', [
            'clinic' => ClinicData::from($clinic),
            'invites' => InviteData::collect($invites),
        ]);
    }
}
