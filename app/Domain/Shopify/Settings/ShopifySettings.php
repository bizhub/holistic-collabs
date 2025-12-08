<?php

namespace Domain\Shopify\Settings;

use Domain\Shopify\Enums\ConnectionStatus;
use Spatie\LaravelSettings\Settings;

class ShopifySettings extends Settings
{
    public ConnectionStatus $status = ConnectionStatus::Disconnected;
    public string $url = '';
    public ?string $access_token = null;
    public ?string $webhook_secret = null;

    public static function encrypted(): array
    {
        return [
            'access_token',
            'webhook_secret',
        ];
    }

    public static function group(): string
    {
        return 'shopify';
    }
}
