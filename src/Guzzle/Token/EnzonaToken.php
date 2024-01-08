<?php

namespace Lnx\CubaPayment\Guzzle\Token;

use DateInterval;
use DateTimeInterface;

final class EnzonaToken implements TokenInterface
{
    private string $token;
    private DateTimeInterface $expires;

    public function __construct(string $token, int $expires)
    {
        $this->token = $token;
        $this->expires = $this->processExpire($expires);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function isValid(): bool
    {
        return ($this->expires > date_create());
    }

    private function processExpire(int $expires): DateTimeInterface
    {
        $dateInterval = new DateInterval(sprintf('PT%dS', $expires));
        return (date_create())->add($dateInterval);
    }
}
