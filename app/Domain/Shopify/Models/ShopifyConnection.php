<?php

namespace Domain\Shopify\Models;

use Domain\Shopify\Enums\ConnectionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopifyConnection extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'status',
        'url',
        'access_token',
        'scope',
    ];

    protected function casts(): array
    {
        return [
            'status'       => ConnectionStatus::class,
            'access_token' => 'encrypted',
        ];
    }
}
