<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Inertia\Inertia;

class DashboardIndexController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Dashboard');
    }
}
