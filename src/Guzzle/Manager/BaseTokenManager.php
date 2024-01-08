<?php

namespace Lnx\CubaPayment\Guzzle\Manager;

use Lnx\CubaPayment\Config\ConfigInterfaces;
use Lnx\CubaPayment\Guzzle\Token\TokenInterface;

abstract class BaseTokenManager implements TokenManagerInterface
{
    private TokenInterface $token;

    public function __construct(
        private readonly ConfigInterfaces $connection,
        private string $uri
    )
    {
    }

    public function getConnection(): ConfigInterfaces
    {
        return $this->connection;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    public function getToken(): TokenInterface
    {
        if (!isset($this->token) or !$this->token->isValid()){
            $this->token = $this->getTokenManager();
        }

        return $this->token;
    }

    abstract protected function getTokenManager(): TokenInterface;
}