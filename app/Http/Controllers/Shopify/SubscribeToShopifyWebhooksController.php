<?php

namespace App\Http\Controllers\Shopify;

use Domain\Shopify\Actions\SubscribeWebhookAction;

class SubscribeToShopifyWebhooksController
{
    public function __invoke(SubscribeWebhookAction $subscribeWebhookAction)
    {
        $subscribeWebhookAction->execute();

        return back();
    }
}
