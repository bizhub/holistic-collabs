<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Models\Clinic;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DeleteClinicController
{
    public function __invoke(Clinic $clinic)
    {
        $clinic->delete();

        Cache::forget('shopify_price_rules');

        Inertia::flash('success', 'Clinic deleted');

        return back();
    }
}
