<?php

namespace App\Http\Controllers\Integration;

use Inertia\Inertia;

class IntegrationIndexController
{
    public function __invoke()
    {
        return Inertia::render('Integration/Integrations');
    }
}
