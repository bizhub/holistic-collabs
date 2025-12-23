<?php

namespace App\Http\Controllers\Admin\User;

use Domain\User\Data\UserData;
use Domain\User\Models\User;
use Inertia\Inertia;

class UserIndexController
{
    public function __invoke()
    {
        $users = User::query()
            ->with('clinic')
            ->get();

        return Inertia::render('Admin/User/Users', [
            'users' => UserData::collect($users),
        ]);
    }
}
