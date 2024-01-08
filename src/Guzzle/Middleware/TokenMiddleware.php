<?php

namespace Lnx\CubaPayment\Guzzle\Middleware;

use Lnx\CubaPayment\Guzzle\Token\TokenInterface;
use Psr\Http\Message\RequestInterface;

final class TokenMiddleware
{
    private TokenInterface $token;

    public function __construct(TokenInterface $token)
    {
        $this->token = $token;
    }

    public function __invoke(callable $handler): callable
    {
        $token = $this->token;

        return function (RequestInterface $request, array $options) use ($handler, $token) {
            $request = $request->withHeader('Authorization', $token->getToken());
            return $handler($request, $options);
        };
    }
}