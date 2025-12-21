<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Actions\UpdateClinicAction;
use Domain\Clinic\Data\ClinicFormData;
use Domain\Clinic\Models\Clinic;

class UpdateClinicController
{
    public function __invoke(
        ClinicFormData $data,
        Clinic $clinic,
        UpdateClinicAction $updateClinic,
    ) {
        $updateClinic->execute($clinic, $data);

        return redirect('clinics');
    }
}
