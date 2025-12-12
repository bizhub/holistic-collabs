<?php

namespace Domain\Commission\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CommissionRateCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value / 100;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return (int) round($value * 100);
    }
}
