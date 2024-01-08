<?php

namespace Lnx\CubaPayment\Config;

final class TransfermovilConfig implements ConfigInterfaces
{
    public function __construct(
        private readonly string $url
    )
    {
    }

    public function url(): string
    {
        return $this->url;
    }

}
