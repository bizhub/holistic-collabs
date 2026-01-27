<?php

namespace App\Http\Controllers\Admin\Order;

use Domain\Order\Data\OrderData;
use Domain\Order\Models\Order;
use Inertia\Inertia;

class OrderIndexController
{
    public function __invoke()
    {
        $orders = Order::query()
            ->with([
                'clinic',
                'client',
            ])
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Order/Orders', [
            'orders' => OrderData::collect($orders),
        ]);
    }
}
