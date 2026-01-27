<?php

namespace Domain\Order\Actions;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Order\Models\Order;

class CreateOrderAction
{
    public function execute(
        Clinic $clinic,
        Client $client,
        string $shopifyId,
        string $orderNumber,
        float $subtotal,
        ?string $couponCode,
    ): Order {
        return Order::create([
            'clinic_id' => $clinic->id,
            'client_id' => $client->id,
            'shopify_id' => $shopifyId,
            'order_number' => $orderNumber,
            'coupon_code' => $couponCode,
            'subtotal_price' => $subtotal,
        ]);
    }
}
