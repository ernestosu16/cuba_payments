<?php

namespace Lnx\CubaPayment\Manager;

use Lnx\CubaPayment\Guzzle\Manager\EnzonaTokenManager;
use Lnx\CubaPayment\Request\RequestInterface;
use RuntimeException;

final class EnzonaManager extends BaseManager
{
    static function tokenManager(): string
    {
        return EnzonaTokenManager::class;
    }

    public function execute(RequestInterface $request, $method, $uri): array
    {
        $form = json_decode(json_encode($request), true);
        $response = $this->guzzle()->request($method,$uri, [
            'json' => $form
        ]);

        $contentType = $response->getHeader('Content-Type');
        $body = $response->getBody();

        if(count($contentType) > 0 && $contentType[0] !== 'application/json'){
            throw new RuntimeException($body->getContents());
        }

        return json_decode($body->getContents(), true);
    }
}