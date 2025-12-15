<?php

use App\Http\Controllers\Shopify\HandleOrdersCreatedWebhookController;
use App\Http\Controllers\Shopify\ShopifyCallbackController;
use Illuminate\Support\Facades\Route;

Route::get('shopify/callback', ShopifyCallbackController::class);
Route::post('shopify/webhook/orders/created', HandleOrdersCreatedWebhookController::class);
