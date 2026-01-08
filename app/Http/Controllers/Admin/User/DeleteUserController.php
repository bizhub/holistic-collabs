<?php

namespace App\Http\Controllers\Admin\User;

use Domain\User\Models\User;
use Inertia\Inertia;

class DeleteUserController
{
    public function __invoke(User $user)
    {
        $user->delete();

        Inertia::flash('success', 'User deleted');

        return back();
    }
}
