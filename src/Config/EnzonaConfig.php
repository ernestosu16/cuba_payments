<?php

namespace Lnx\CubaPayment\Config;

final class EnzonaConfig implements ConfigInterfaces
{
    public function __construct(
        private readonly string $url,
        private readonly string $consumer_key,
        private readonly string $consumer_secret
    )
    {
    }

    public function url(): string
    {
        return $this->url;
    }

    public function getConsumerKey(): string
    {
        return $this->consumer_key;
    }

    public function getConsumerSecret(): string
    {
        return $this->consumer_secret;
    }
}