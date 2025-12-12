<?php

namespace App\Http\Controllers\Clinic;

use Domain\Clinic\Actions\CreateClinicAction;
use Domain\Clinic\Data\ClinicFormData;

class StoreClinicController
{
    public function __invoke(
        ClinicFormData $request,
        CreateClinicAction $createClinic,
    ) {
        $createClinic->execute($request);

        return redirect('/clinics');
    }
}
