<?php

namespace App\Http\Controllers\Admin\Invite;

use Inertia\Inertia;

class InviteIndexController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Invite/Invites');
    }
}
