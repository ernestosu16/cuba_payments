<?php

namespace Lnx\CubaPayment\Guzzle;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\HandlerStack;
use Lnx\CubaPayment\Config\ConfigInterfaces;
use Lnx\CubaPayment\Guzzle\Manager\TokenManagerInterface;
use Lnx\CubaPayment\Guzzle\Middleware\DefaultHeadersMiddleware;
use Lnx\CubaPayment\Guzzle\Middleware\TokenMiddleware;

final class ClientBuilder
{
    private TokenManagerInterface $tokenManager;
    private ?string $serverUrl = null;

    public function getTokenManager(): TokenManagerInterface
    {
        return $this->tokenManager;
    }

    public function withTokenManagerClass(string $class, ConfigInterfaces $connection): ClientBuilder
    {
        $tokenManager = new $class($connection);
        if (!$tokenManager instanceof TokenManagerInterface) {
            throw new \RuntimeException('class not token manager');
        }

        $this->tokenManager = $tokenManager;

        return $this;
    }

    public function withServerUrl(string $url): ClientBuilder
    {
        $this->serverUrl = $url;

        return $this;
    }

    private function buildGuzzle(array $config = []): GuzzleClient
    {
        if ($this->serverUrl === null) {
            throw new InvalidArgumentException("Undefined: base_uri");
        }

        $config['base_uri'] = $this->serverUrl;

        return new GuzzleClient($config);
    }

    public function build(array $config = []): GuzzleClient
    {
        if ($this->tokenManager->getToken()) {
            $stack = HandlerStack::create();
            $stack->push(new DefaultHeadersMiddleware());
            $stack->push(new TokenMiddleware($this->tokenManager->getToken()));
            $config['handler'] = $stack;
        }

        return $this->buildGuzzle($config);
    }
}