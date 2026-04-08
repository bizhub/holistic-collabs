<?php

namespace Domain\Shopify\Actions;

use Domain\Order\Actions\CreateOrderAction;
use Domain\Order\Models\Order;
use Domain\Shopify\Data\OrderCreatedWebhookData;
use Illuminate\Support\Facades\DB;

class HandleOrderCreatedWebhookAction
{
    public function __construct(
        protected ResolveWebhookOrderCouponAction $resolveCoupon,
        protected ResolveWebhookOrderClientAction $resolveClient,
        protected CreateOrderAction $createOrder,
        protected CreateCommissionFromOrderAction $createCommission,
        protected RecordShopifyActivityAction $recordActivity,
    ) {}

    public function execute(OrderCreatedWebhookData $data): void
    {
        $orderExists = Order::query()
            ->where('shopify_id', $data->id)
            ->exists();

        if ($orderExists) {
            $this->recordActivity->execute(
                "Webhook (orders.created) {$data->id} - Duplicate",
            );
            return;
        }

        DB::transaction(function () use($data) {
            $couponContext = $this->resolveCoupon->execute(
                data: $data,
            );

            $client = $this->resolveClient->execute(
                data: $data,
                couponContext: $couponContext,
            );

            if (!$client) {
                $this->recordActivity->execute(
                    "Webhook (orders.created) {$data->id} - Skipped",
                );
                return;
            }

            $subtotal = $data->total_line_items_price - $couponContext->totalUnrelated;

            $clinic = $couponContext->coupon?->clinic ?? $client->clinic;

            $order = $this->createOrder->execute(
                clinic: $clinic,
                client: $client,
                shopifyId: $data->id,
                orderNumber: $data->order_number,
                subtotal: $subtotal,
                couponCode: $couponContext->coupon?->code,
            );

            $this->createCommission->execute(
                order: $order,
                client: $client,
                clinic: $clinic,
                couponContext: $couponContext,
                subtotal: $subtotal,
                firstOrder: (bool) $couponContext->coupon,
            );

            $this->recordActivity->execute(
                "Webhook (orders.created) {$data->id} - Processed",
            );
        });
    }
}
