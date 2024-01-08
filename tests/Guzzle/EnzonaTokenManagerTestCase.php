<?php

namespace Lnx\CubaPayment\Tests\Guzzle;

use GuzzleHttp;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Guzzle\Manager\TokenManagerInterface;
use Lnx\CubaPayment\Guzzle\Token\EnzonaToken;
use Lnx\CubaPayment\Guzzle\Token\TokenInterface;

final class EnzonaTokenManagerTestCase implements TokenManagerInterface
{
    private TokenInterface|null $token = null;

    public function __construct(private readonly EnzonaConfig $connection)
    {
    }

    public function getToken(): TokenInterface
    {
        if ($this->token == null || $this->token->isValid()) {
            $this->token = $this->getEnzonaToken();
        }

        return $this->token;
    }

    private function getEnzonaToken(): TokenInterface
    {
        $client = new GuzzleHttp\Client([
            'verify' => false,
            'base_uri' => $this->connection->url()]
        );

        $response = $client->post('/enzona/token.php', [
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