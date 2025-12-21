<?php

namespace App\Http\Controllers\Admin\Clinic;

use Domain\Clinic\Models\Clinic;
use Illuminate\Support\Facades\Cache;

class DeleteClinicController
{
    public function __invoke(Clinic $clinic)
    {
        $clinic->delete();

        Cache::forget('shopify_price_rules');

        return back();
    }
}
