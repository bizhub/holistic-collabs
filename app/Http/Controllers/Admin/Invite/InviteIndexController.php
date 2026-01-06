<?php

namespace App\Http\Controllers\Admin\Invite;

use Domain\Invite\Data\InviteData;
use Domain\Invite\Models\Invite;
use Inertia\Inertia;

class InviteIndexController
{
    public function __invoke()
    {
        $invites = Invite::query()
            ->with('clinic')
            ->get();

        Inertia::flash('success', 'Invitation created and sent');

        return Inertia::render('Admin/Invite/Invites', [
            'invites' => InviteData::collect($invites),
        ]);
    }
}
