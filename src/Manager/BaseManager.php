<?php

namespace Lnx\CubaPayment\Manager;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Lnx\CubaPayment\Config\ConfigInterfaces;
use Lnx\CubaPayment\Guzzle\ClientBuilder;

abstract class BaseManager implements ManagerInterface
{
    private ?ClientBuilder $clientBuilder = null;
    private ?Client $guzzle = null;

    public function __construct(
        private readonly ConfigInterfaces $connection,
        private readonly string|null      $tokenManagerClass = null
    )
    {
    }

    abstract static function tokenManager(): string;

    public function getClientBuilder(): ClientBuilder
    {
        if (!$this->clientBuilder) {
            $this->clientBuilder = $this->buildGuzzle($this->connection);
        }
        return $this->clientBuilder;
    }

    public function guzzle(): ClientInterface
    {
        if (!$this->guzzle) {
            $this->guzzle = $this->getClientBuilder()->build();
        }
        return $this->guzzle;
    }


    private function buildGuzzle(ConfigInterfaces $connection): ClientBuilder
    {
        $tokenManagerClass = $this->tokenManagerClass ?? static::tokenManager();

        $clientBuilder = new ClientBuilder();
        $clientBuilder->withServerUrl($connection->url());
        $clientBuilder->withTokenManagerClass($tokenManagerClass, $connection);
        return $clientBuilder;
    }
}