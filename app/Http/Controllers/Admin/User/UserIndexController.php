<?php

namespace App\Http\Controllers\Admin\User;

use Inertia\Inertia;

class UserIndexController
{
    public function __invoke()
    {
        return Inertia::render('Admin/User/Users');
    }
}
