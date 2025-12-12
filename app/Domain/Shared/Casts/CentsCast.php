<?php

namespace Domain\Shared\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CentsCast implements CastsAttributes
{
    protected int $precision;

    public function __construct(int $precision = 100)
    {
        $this->precision = $precision;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        return $value / $this->precision;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        return (int) round($value * $this->precision);
    }
}
