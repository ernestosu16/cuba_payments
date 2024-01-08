<?php

namespace Lnx\CubaPayment\Tests\Request\Enzona;

use Lnx\CubaPayment\Attribute\Request;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Request\Enzona\ConfirmPayment;

/**
 * @group skip
 */
#[Request(
    connection: EnzonaConfig::class,
    method: Request::METHOD_POST,
    uri: '/enzona/payment/v1.0.0/payments.php?{transaction_uuid}=complete'
)]
class ConfirmPaymentTestCase extends ConfirmPayment
{
}