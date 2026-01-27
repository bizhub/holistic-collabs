<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Domain\Order\Data\OrderData;
use Inertia\Inertia;

class ClinicOrdersController
{
    public function __invoke(Clinic $clinic)
    {
        $orders = $clinic
            ->orders()
            ->with('client')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Clinic/Orders', [
            'clinic' => ClinicData::from($clinic),
            'clinics' => ClinicData::collect(Clinic::all()),
            'orders' => OrderData::collect($orders),
        ]);
    }
}
