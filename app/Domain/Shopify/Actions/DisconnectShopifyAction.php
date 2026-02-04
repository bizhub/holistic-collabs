<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Enums\ConnectionStatus;
use Domain\Shopify\Settings\ShopifySettings;

class DisconnectShopifyAction
{
    public function __construct(
        protected ShopifySettings $settings,
        protected DeleteAllWebhooksAction $deleteAllWebhooks,
        protected RecordShopifyActivityAction $recordShopifyActivity,
    ) {}

    public function execute(): void
    {
        $this->deleteAllWebhooks->execute();

        $shop = $this->settings->url;

        $this->settings->status = ConnectionStatus::Disconnected;
        $this->settings->access_token = null;
        $this->settings->url = '';

        $this->settings->save();

        $this->recordShopifyActivity->execute(
            'Disconnected Shopify store' . ($shop ? ': ' . $shop : '')
        );
    }
}
