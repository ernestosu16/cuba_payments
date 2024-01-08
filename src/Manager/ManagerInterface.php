<?php

namespace Lnx\CubaPayment\Manager;

use Lnx\CubaPayment\Request\RequestInterface;

interface ManagerInterface
{
    public function execute(RequestInterface $request, string $method, string $uri): array;
}
