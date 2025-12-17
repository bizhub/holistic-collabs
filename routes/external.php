<?php

use App\Http\Controllers\Shopify\HandleOrdersCreatedWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('shopify/webhook/orders/created', HandleOrdersCreatedWebhookController::class);
