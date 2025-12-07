<?php

namespace Domain\Clinic\Actions;

use Domain\Clinic\Data\ClinicFormData;
use Domain\Clinic\Models\Clinic;

class CreateClinicAction
{
    public function execute(ClinicFormData $data): Clinic
    {
        return Clinic::create([
            'name' => $data->name,
        ]);
    }
}
