<?php

namespace Lnx\CubaPayment\Tests;

use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Guzzle\Manager\EnzonaTokenManager;
use Lnx\CubaPayment\PaymentManager;
use Lnx\CubaPayment\Tests\Request\Enzona\ConfirmPaymentTestCase;
use Lnx\CubaPayment\Tests\Request\Enzona\GeneratePaymentTestCase;
use PHPUnit\Framework\TestCase;

class CubaPaymentTest extends TestCase
{
    public function testPaymentManager()
    {
        $enzonaConfig = new EnzonaConfig('http://http/', 'ASSA#', 'SDASD');

        $manager = new PaymentManager($enzonaConfig);
        $manager
            ->withTokenManager(EnzonaTokenManager::class)
            ->getTokenManager()->setUri('/enzona/token.php')
        ;

        $generatePayment = new GeneratePaymentTestCase();
        $generatePayment
            ->setCurrency('CUP');

        $data = $manager->execute($generatePayment);


        $confirmPayment = new ConfirmPaymentTestCase();
        $confirmPayment->setTransactionUuid('f89c79c8dfbd43939cdc43cf47b1ee47');
        $data = $manager->execute($confirmPayment);

        $this->isJson();
        $this->assertArrayHasKey('transaction_uuid', $data);
        $this->assertIsObject($manager);
    }
}