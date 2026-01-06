<?php

namespace App\Http\Controllers\Admin\Invite;

use Domain\Invite\Actions\CreateInviteAction;
use Domain\Invite\Actions\SendInviteAction;
use Domain\Invite\Data\CreateInviteData;
use Inertia\Inertia;

class StoreInviteController
{
    public function __invoke(
        CreateInviteData $data,
        CreateInviteAction $createInvite,
        SendInviteAction $sendInvite,
    ) {
        $invite = $createInvite->execute($data);

        $sendInvite->execute($invite);

        Inertia::flash('success', 'Invitation created and sent');

        return redirect('invites');
    }
}
