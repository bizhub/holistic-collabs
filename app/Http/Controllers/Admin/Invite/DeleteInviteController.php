<?php

namespace App\Http\Controllers\Admin\Invite;

use Domain\Invite\Models\Invite;
use Inertia\Inertia;

class DeleteInviteController
{
    public function __invoke(Invite $invite)
    {
        $invite->delete();

        Inertia::flash('success', 'Invitation deleted');

        return back();
    }
}
