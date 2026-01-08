<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Actions\CreateClinicAction;
use Domain\Clinic\Data\ClinicFormData;
use Inertia\Inertia;

class StoreClinicController
{
    public function __invoke(
        ClinicFormData $request,
        CreateClinicAction $createClinic,
    ) {
        $createClinic->execute($request);

        Inertia::flash('success', 'Clinic created');

        return redirect('/clinics');
    }
}
