<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;

class UserIndexController
{
    public function __invoke()
    {
        return Inertia::render('User/Users');
    }
}
