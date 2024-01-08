<?php

namespace Lnx\CubaPayment\Request\Enzona;

use Lnx\CubaPayment\Attribute\Request;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Request\RequestInterface;

#[Request(
    connection: EnzonaConfig::class,
    method: Request::METHOD_POST,
    uri: '/payment/v1.0.0/payments'
)]
class GeneratePayment implements RequestInterface
{
    protected string $merchant_uuid;
    protected string $merchant_op_id;
    protected string $description;
    protected string $return_url;
    protected string $cancel_url;
    protected string $currency;
    protected string $buyer_identity_code;
    protected string $terminal_id;
    protected array $amount = [];
    protected array $items = [];

    public function getMerchantUuid(): string
    {
        return $this->merchant_uuid;
    }

    public function setMerchantUuid(string $merchant_uuid): GeneratePayment
    {
        $this->merchant_uuid = $merchant_uuid;
        return $this;
    }

    public function getMerchantOpId(): string
    {
        return $this->merchant_op_id;
    }

    public function setMerchantOpId(string $merchant_op_id): GeneratePayment
    {
        $this->merchant_op_id = $merchant_op_id;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): GeneratePayment
    {
        $this->description = $description;
        return $this;
    }

    public function getReturnUrl(): string
    {
        return $this->return_url;
    }

    public function setReturnUrl(string $return_url): GeneratePayment
    {
        $this->return_url = $return_url;
        return $this;
    }

    public function getCancelUrl(): string
    {
        return $this->cancel_url;
    }

    public function setCancelUrl(string $cancel_url): GeneratePayment
    {
        $this->cancel_url = $cancel_url;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): GeneratePayment
    {
        $this->currency = $currency;
        return $this;
    }

    public function getBuyerIdentityCode(): string
    {
        return $this->buyer_identity_code;
    }

    public function setBuyerIdentityCode(string $buyer_identity_code): GeneratePayment
    {
        $this->buyer_identity_code = $buyer_identity_code;
        return $this;
    }

    public function getTerminalId(): string
    {
        return $this->terminal_id;
    }

    public function setTerminalId(string $terminal_id): GeneratePayment
    {
        $this->terminal_id = $terminal_id;
        return $this;
    }

    public function getAmount(): array
    {
        return $this->amount;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(int $quantity, float $price, string $name, string $description = '', float $tax = 0): GeneratePayment
    {
        $this->items[] = [
            "quantity" => $quantity,
            "price" => $price,
            "name" => $name,
            "description" => $description,
            "tax" => $tax,
        ];

        return $this;
    }
}
