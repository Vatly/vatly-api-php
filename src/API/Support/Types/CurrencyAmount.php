<?php

namespace Vatly\API\Support\Types;

class CurrencyAmount
{
    public string $currency;
    public string $value;

    public function __construct(string $currency, string $value)
    {
        $this->currency = $currency;
        $this->value = $value;
    }

    public static function createResourceFromApiResult($value): CurrencyAmount
    {
        if (is_array($value)) {
            $value = (object) $value;
        }

        return new self($value->currency, $value->value);
    }
}
