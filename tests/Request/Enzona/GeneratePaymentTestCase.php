<?php

namespace Lnx\CubaPayment\Tests\Request\Enzona;

use Lnx\CubaPayment\Attribute\Request;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Request\Enzona\GeneratePayment;

#[Request(
    connection: EnzonaConfig::class,
    method: Request::METHOD_POST,
    uri: '/enzona/payment/v1.0.0/payments.php'
)]
class GeneratePaymentTestCase extends GeneratePayment
{
}