<?php

namespace Lnx\CubaPayment\Request\Enzona;

use Lnx\CubaPayment\Attribute\Request;
use Lnx\CubaPayment\Attribute\RequestValue;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Request\RequestInterface;

#[Request(
    connection: EnzonaConfig::class,
    method: Request::METHOD_POST,
    uri: '/payment/v1.0.0/payments/{transaction_uuid}/complete'
)]
class ConfirmPayment implements RequestInterface
{
    protected ?string $transaction_uuid = null;

    #[RequestValue(name: "transaction_uuid")]
    public function getTransactionUuid(): ?string
    {
        return $this->transaction_uuid;
    }

    public function setTransactionUuid(?string $transaction_uuid): ConfirmPayment
    {
        $this->transaction_uuid = $transaction_uuid;
        return $this;
    }


}
