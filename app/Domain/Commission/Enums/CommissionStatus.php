<?php

namespace Domain\Commission\Enums;

/** @typescript */
enum CommissionStatus: string
{
    case Paid = 'paid';
    case Pending = 'pending';
}
