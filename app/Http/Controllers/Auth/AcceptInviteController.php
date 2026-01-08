<?php

namespace App\Http\Controllers\Auth;

use Domain\Invite\Data\InviteData;
use Domain\Invite\Models\Invite;
use Illuminate\Http\Response;
use Inertia\Inertia;

class AcceptInviteController
{
    public function __invoke(string $token)
    {
        $invite = Invite::query()
            ->with('clinic')
            ->where('token', $token)
            ->first();

        abort_if(
            boolean: !$invite,
            code: Response::HTTP_NOT_FOUND,
        );

        return Inertia::render('auth/AcceptInvite', [
            'invite' => InviteData::from($invite),
        ]);
    }
}
