<?php

namespace Lnx\CubaPayment\Guzzle\Token;

interface TokenInterface
{
    public function getToken(): string;

    public function isValid(): bool;
}