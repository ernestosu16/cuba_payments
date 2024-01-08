<?php

namespace Lnx\CubaPayment\Service;

use GuzzleHttp\ClientInterface;
use Lnx\CubaPayment\Config\ConfigInterfaces;
use Lnx\CubaPayment\Guzzle\ClientBuilder;

abstract class BaseService
{
    protected ClientInterface $guzzle;

    public function __construct(ConfigInterfaces $connection)
    {
        $this->guzzle = $this->buildGuzzle($connection);
    }

    abstract static function tokenManager(): string;

    private function buildGuzzle(ConfigInterfaces $connection): ClientInterface
    {
        $clientBuilder = new ClientBuilder();
        $clientBuilder->withServerUrl($connection->url());
        $clientBuilder->withTokenManagerClass(static::tokenManager(), $connection);
        return $clientBuilder->build();
    }
}