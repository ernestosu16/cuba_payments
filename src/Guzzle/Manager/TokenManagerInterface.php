<?php

namespace Lnx\CubaPayment\Guzzle\Manager;

use Lnx\CubaPayment\Guzzle\Token\TokenInterface;

interface TokenManagerInterface
{

    public function setUri(string $uri): self;

    public function getUri(): string;

    public function getToken(): TokenInterface;
}