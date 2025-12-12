<?php

namespace Domain\Shopify\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopifyActivity extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'description',
    ];
}
