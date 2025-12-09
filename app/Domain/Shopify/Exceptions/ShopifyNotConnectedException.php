<?php

namespace Domain\Shopify\Exceptions;

use RuntimeException;

class ShopifyNotConnectedException extends RuntimeException
{
    public function __construct(string $message = 'Shopify integration is not connected.')
    {
        parent::__construct($message);
    }
}
