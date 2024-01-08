<?php

namespace Lnx\CubaPayment\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY, Attribute::TARGET_METHOD)]
class RequestValue
{
    public function __construct(
        public readonly string $name
    )
    {
    }
}