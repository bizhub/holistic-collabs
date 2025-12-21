<?php

use App\Http\Controllers\Admin\Shopify\HandleOrdersCreatedWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('shopify/webhook/orders/created', HandleOrdersCreatedWebhookController::class);
