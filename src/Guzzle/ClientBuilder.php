<?php

namespace Lnx\CubaPayment\Guzzle;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\HandlerStack;
use Lnx\CubaPayment\Config\ConfigInterfaces;
use Lnx\CubaPayment\Guzzle\Manager\TokenManagerInterface;
use Lnx\CubaPayment\Guzzle\Middleware\DefaultHeadersMiddleware;
use Lnx\CubaPayment\Guzzle\Middleware\TokenMiddleware;
use Lnx\CubaPayment\Guzzle\Token\TokenInterface;

final class ClientBuilder
{
    private ?string $serverUrl = null;
    private ?TokenInterface $token = null;

    public function withServerUrl(string $url): ClientBuilder
    {
        $this->serverUrl = $url;

        return $this;
    }

    public function withTokenManagerClass(string $class, ConfigInterfaces $connection): ClientBuilder
    {
        $manager = new $class($connection);
        if (!$manager instanceof TokenManagerInterface) {
            throw new \RuntimeException('class not tocker manager');
        }

        $this->token = $manager->getToken();

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

        if ($this->token) {
            $stack = HandlerStack::create();
            $stack->push(new DefaultHeadersMiddleware());
            $stack->push(new TokenMiddleware($this->token));
            $config['handler'] = $stack;
        }

        return $this->buildGuzzle($config);
    }
}