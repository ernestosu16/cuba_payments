<?php

namespace Lnx\CubaPayment\Guzzle\Middleware;

use Psr\Http\Message\RequestInterface;

final class DefaultHeadersMiddleware
{
    public function __invoke(callable $handler): \Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $request = $request->withHeader('Accept', 'application/json');
            $request = $request->withHeader('Content-Type', 'application/json');
            return $handler($request, $options);
        };
    }
}