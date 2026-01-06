<?php

namespace Domain\Invite\Actions;

use Domain\Invite\Data\AcceptInviteData;
use Domain\Invite\Models\Invite;
use Domain\User\Models\User;
use Illuminate\Support\Facades\DB;

class AcceptInviteAction
{
    public function execute(Invite $invite, AcceptInviteData $data): User
    {
        return DB::transaction(function () use ($invite, $data) {
            $user = User::create([
                'clinic_id' => $invite->clinic_id,
                'name' => $data->name,
                'email' => $invite->email,
                'password' => $data->password,
            ]);

            $invite->delete();

            return $user;
        });
    }
}
