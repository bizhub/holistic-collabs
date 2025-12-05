<?php

namespace Domain\Clinic\Actions;

use Domain\Clinic\Models\Clinic;
use Domain\Clinic\Requests\ClinicRequest;

class CreateClinicAction
{
    public function execute(ClinicRequest $data): Clinic
    {
        return Clinic::create([
            'name' => $data->name,
        ]);
    }
}
