<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Actions\UpdateClinicAction;
use Domain\Clinic\Data\ClinicFormData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class UpdateClinicController
{
    public function __invoke(
        ClinicFormData $data,
        Clinic $clinic,
        UpdateClinicAction $updateClinic,
    ) {
        $updateClinic->execute($clinic, $data);

        Inertia::flash('success', 'Clinic updated');

        return redirect('clinics');
    }
}
