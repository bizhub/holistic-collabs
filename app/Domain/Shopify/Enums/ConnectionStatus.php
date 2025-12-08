<?php

namespace Domain\Shopify\Enums;

/** @typescript */
enum ConnectionStatus: string
{
    case Connected = 'connected';
    case Disconnected = 'disconnected';
}
