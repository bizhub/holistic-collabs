<?php

namespace Domain\Shopify\Settings;

use Domain\Shopify\Enums\ConnectionStatus;
use Spatie\LaravelSettings\Settings;

class ShopifySettings extends Settings
{
    public ConnectionStatus $status = ConnectionStatus::Disconnected;
    public string $store_domain = '';
    public string $access_token = '';
    public string $scopes = '';
    public string $webhook_secret = '';

    public static function encrypted(): array
    {
        return [
            'access_token',
            'webhook_secret',
        ];
    }

    // public static function casts(): array
    // {
    //     return [
            // 'status' => ConnectionStatus::class,
    //     ];
    // }

    public static function group(): string
    {
        return 'shopify';
    }
}
