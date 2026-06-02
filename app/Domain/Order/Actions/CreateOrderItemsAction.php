<?php

namespace Domain\Order\Actions;

use Domain\Order\Models\Order;

class CreateOrderItemsAction
{
    public function execute(
        Order $order,
        array $lineItems,
    ): void {
        foreach ($lineItems as $item) {
            $order->items()->create([
                'shopify_product_id' => $item->product_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }
    }
}
