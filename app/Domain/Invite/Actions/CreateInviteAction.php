<?php

namespace Domain\Invite\Actions;

use Domain\Invite\Data\CreateInviteData;
use Domain\Invite\Models\Invite;
use Illuminate\Support\Str;

class CreateInviteAction
{
    public function execute(CreateInviteData $data): Invite
    {
        return Invite::create([
            'clinic_id' => $data->clinic_id,
            'token' => Str::uuid(),
            'name' => $data->name,
            'email' => $data->email,
        ]);
    }
}
