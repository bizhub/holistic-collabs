<?php

namespace App\Http\Controllers\Auth;

use Domain\Invite\Actions\AcceptInviteAction;
use Domain\Invite\Data\AcceptInviteData;
use Domain\Invite\Models\Invite;

class RegisterInviteController
{
    public function __invoke(
        Invite $invite,
        AcceptInviteData $data,
        AcceptInviteAction $acceptInvite,
    ) {
        $acceptInvite->execute($invite, $data);

        return redirect('login');
    }
}
