<?php

namespace Lnx\CubaPayment\Guzzle\Manager;

use GuzzleHttp;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Guzzle\Token\EnzonaToken;
use Lnx\CubaPayment\Guzzle\Token\TokenInterface;

final class EnzonaTokenManager implements TokenManagerInterface
{
    public function __construct(private readonly EnzonaConfig $connection)
    {
    }

    public function getToken(): TokenInterface
    {
        if (isset($this->token) && $this->token->isValid()) {
            return $this->token;
        }

        return $this->getEnzonaToken();
    }

    private function getEnzonaToken(): TokenInterface
    {
        $client = new GuzzleHttp\Client([
            'verify' => false,
            'base_uri' => $this->connection->url()]);

        $response = $client->post('/api/token', [
            'header' => [
                'Authorization' => 'Basic ' . base64_encode($this->connection->getConsumerKey() . ":" . $this->connection->getConsumerSecret())
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'enzona_business_payment',
            ]
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException("Error getting token");
        }

        $data = json_decode((string)$response->getBody(), true);

        return new EnzonaToken($data['access_token'], $data['expires_in']);
    }
}