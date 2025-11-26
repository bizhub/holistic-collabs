<?php

namespace Domain\Shopify\Enums;

/** @typescript */
enum ConnectionStatus: string
{
    case Active = 'active';
    case Disconnected = 'disconnected';
}
