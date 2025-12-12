<?php

namespace Domain\Shopify\Enums;

/** @typescript */
enum WebhookStatus: string
{
    case Connected = 'connected';
    case Partial = 'partial';
    case Disconnected = 'disconnected';
    case Error = 'error';
}
