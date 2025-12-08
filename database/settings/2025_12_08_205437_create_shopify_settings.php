<?php

use Domain\Shopify\Enums\ConnectionStatus;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('shopify.status', ConnectionStatus::Disconnected);
        $this->migrator->add('shopify.url', '');
        $this->migrator->add('shopify.access_token', null);
        $this->migrator->add('shopify.webhook_secret', null);
    }
};
