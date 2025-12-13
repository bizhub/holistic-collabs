<?php

namespace App\Http\Controllers\Order;

use Domain\Order\Data\OrderData;
use Domain\Order\Models\Order;
use Inertia\Inertia;

class OrderIndexController
{
    public function __invoke()
    {
        $orders = Order::query()->get();

        return Inertia::render('Order/Orders', [
            'orders' => OrderData::collect($orders),
        ]);
    }
}
