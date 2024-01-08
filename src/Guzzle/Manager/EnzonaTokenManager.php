<?php

namespace Lnx\CubaPayment\Guzzle\Manager;

use GuzzleHttp;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Guzzle\Token\EnzonaToken;
use Lnx\CubaPayment\Guzzle\Token\TokenInterface;
use RuntimeException;

final class EnzonaTokenManager extends BaseTokenManager
{
    public function __construct(EnzonaConfig $connection)
    {
        parent::__construct($connection, '/api/token');
    }

    protected function getTokenManager(): TokenInterface
    {
        /** @var EnzonaConfig $connection */
        $connection = $this->getConnection();

        $client = new GuzzleHttp\Client([
            'verify' => false,
            'base_uri' => $this->getConnection()->url()]);

        $response = $client->post($this->getUri(), [
            'header' => [
                'Authorization' => 'Basic ' . base64_encode($connection->getConsumerKey() . ":" . $connection->getConsumerSecret())
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'enzona_business_payment',
            ]
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new RuntimeException("Error getting token");
        }

        $data = json_decode((string)$response->getBody(), true);

        return new EnzonaToken($data['access_token'], $data['expires_in']);
    }
}