<?php

namespace App\Http\Controllers\Clinic;

use Domain\Clinic\Actions\CreateClinicAction;
use Domain\Clinic\Requests\ClinicRequest;

class StoreClinicController
{
    public function __invoke(
        ClinicRequest $request,
        CreateClinicAction $createClinicAction,
    ) {
        $createClinicAction->execute($request);

        return redirect('/clinics');
    }
}
