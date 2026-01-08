<?php

namespace Domain\Clinic\Support;

use Illuminate\Support\Facades\Auth;
use RuntimeException;

class ClinicContext
{
    public function id(): string
    {
        $user = Auth::user();

        if (! $user || ! $user->clinic_id) {
            throw new RuntimeException('ClinicContext unavailable');
        }

        return $user->clinic_id;
    }
}
