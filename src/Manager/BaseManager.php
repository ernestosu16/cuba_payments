<?php

namespace Lnx\CubaPayment\Manager;

use GuzzleHttp\ClientInterface;
use Lnx\CubaPayment\Config\ConfigInterfaces;
use Lnx\CubaPayment\Guzzle\ClientBuilder;

abstract class BaseManager
{
    protected ClientInterface $guzzle;

    public function __construct(
        ConfigInterfaces             $connection,
        private readonly string|null $tokenManagerClass = null
    )
    {
        $this->guzzle = $this->buildGuzzle($connection);
    }

    abstract static function tokenManager(): string;

    private function buildGuzzle(ConfigInterfaces $connection): ClientInterface
    {
        $tokenManagerClass = $this->tokenManagerClass ?? static::tokenManager();

        $clientBuilder = new ClientBuilder();
        $clientBuilder->withServerUrl($connection->url());
        $clientBuilder->withTokenManagerClass($tokenManagerClass, $connection);
        return $clientBuilder->build();
    }
}