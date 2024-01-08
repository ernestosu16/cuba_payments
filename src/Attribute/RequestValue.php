<?php

namespace Lnx\CubaPayment\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class RequestValue
{
    public function __construct(
        public readonly string $name
    )
    {
    }
}