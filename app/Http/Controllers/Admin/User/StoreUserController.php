<?php

namespace App\Http\Controllers\Admin\User;

use Domain\User\Data\UserFormData;
use Domain\User\Models\User;
use Inertia\Inertia;

class StoreUserController
{
    public function __invoke(UserFormData $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        if ($request->is_admin) {
            $user->is_admin = true;
        } else {
            $user->clinic_id = $request->clinic_id;
        }

        $user->save();

        Inertia::flash('success', 'User created');

        return redirect('users');
    }
}
