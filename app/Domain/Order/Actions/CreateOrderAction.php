<?php

namespace Domain\Order\Actions;

use Domain\Clinic\Models\Clinic;
use Domain\Order\Models\Order;

class CreateOrderAction
{
    public function execute(
        Clinic $clinic,
        string $shopifyId,
        float $subtotal,
        ?string $couponCode,
    ): Order {
        return Order::create([
            'clinic_id' => $clinic->id,
            'shopify_id' => $shopifyId,
            'coupon_code' => $couponCode,
            'subtotal_price' => $subtotal,
        ]);
    }
}
