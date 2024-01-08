<?php

namespace Lnx\CubaPayment\Manager;

use Lnx\CubaPayment\Guzzle\ClientBuilder;
use Lnx\CubaPayment\Request\RequestInterface;

interface ManagerInterface
{
    public function getClientBuilder(): ClientBuilder;
    public function execute(RequestInterface $request, string $method, string $uri): array;
}
