<?php

declare(strict_types=1);

namespace Project\Http;

use BadMethodCallException;
use Project\Http\Middleware\MiddlewareListInterface;
use Project\Http\Middleware\RoutingMiddleware;

class Application
{
    public MiddlewareListInterface $middlewares;

    public function handleRequest(Request $request): Response
    {
        if (!$this->middlewares) {
            throw new BadMethodCallException(sprintf('No middlewares set; at least %s is required', RoutingMiddleware::class));
        }

        return $this->middlewares->first()($request, $this->middlewares);
    }
}
