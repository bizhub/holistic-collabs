<?php

namespace App\Http\Controllers\Clinic\Dashboard;

use Inertia\Inertia;

class DashboardIndexController
{
    public function __invoke()
    {
        return Inertia::render('Clinic/Dashboard/Dashboard');
    }
}
