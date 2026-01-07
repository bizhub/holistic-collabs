<?php

namespace App\Http\Controllers\Admin\Invite;

use Domain\Invite\Actions\SendInviteAction;
use Domain\Invite\Models\Invite;
use Inertia\Inertia;

class ResendInviteController
{
    public function __invoke(Invite $invite, SendInviteAction $sendInvite)
    {
        $sendInvite->execute($invite);

        Inertia::flash('success', 'Invitation resent');

        return back();
    }
}
