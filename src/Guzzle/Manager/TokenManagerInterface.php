<?php

namespace Lnx\CubaPayment\Guzzle\Manager;

use Lnx\CubaPayment\Guzzle\Token\TokenInterface;

interface TokenManagerInterface
{
    public function getToken(): TokenInterface;
}