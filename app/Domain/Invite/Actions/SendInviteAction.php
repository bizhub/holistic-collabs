<?php

namespace Domain\Invite\Actions;

use Domain\Invite\Models\Invite;
use Domain\Invite\Notifications\InviteNotification;
use Illuminate\Support\Facades\Notification;

class SendInviteAction
{
    public function execute(Invite $invite)
    {
        Notification::route('mail', $invite->email)
            ->notify(new InviteNotification($invite));
    }
}
