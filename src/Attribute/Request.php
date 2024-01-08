<?php

namespace Lnx\CubaPayment\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public function __construct(
        public readonly string $connection,
        public readonly string $method,
        public readonly string $uri,
    )
    {
    }
}