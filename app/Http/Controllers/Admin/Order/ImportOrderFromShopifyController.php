<?php

namespace App\Http\Controllers\Admin\Order;

use Domain\Shopify\Actions\ImportOrderAction;
use Domain\Shopify\Data\ImportOrderData;
use Exception;
use Inertia\Inertia;

class ImportOrderFromShopifyController
{
    public function __invoke(ImportOrderData $data, ImportOrderAction $importOrder)
    {
        try {
            $importOrder->execute(
                shopifyOrderId: $data->shopify_id,
            );
        } catch (Exception $e) {
            Inertia::flash('error', 'Shopify: ' . $e->getMessage());

            return back();
        }

        Inertia::flash('success', 'Order imported');

        return back();
    }
}
