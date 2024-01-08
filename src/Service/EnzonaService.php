<?php

namespace Lnx\CubaPayment\Service;

use Lnx\CubaPayment\Guzzle\Manager\EnzonaTokenManager;

final class EnzonaService extends BaseService
{
    static function tokenManager(): string
    {
        return EnzonaTokenManager::class;
    }
}