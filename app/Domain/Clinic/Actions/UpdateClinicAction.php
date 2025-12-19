<?php

namespace Domain\Clinic\Actions;

use Domain\Clinic\Data\ClinicFormData;
use Domain\Clinic\Models\Clinic;

class UpdateClinicAction
{
    public function execute(Clinic $clinic, ClinicFormData $data): bool
    {
        return $clinic->update([
            'name' => $data->name,
            'commission_rate' => $data->commission_rate,
        ]);
    }
}
