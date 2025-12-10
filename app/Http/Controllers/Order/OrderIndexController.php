<?php

namespace App\Http\Controllers\Order;

use Inertia\Inertia;

class OrderIndexController
{
    public function __invoke()
    {
        return Inertia::render('Order/Orders');
    }
}
