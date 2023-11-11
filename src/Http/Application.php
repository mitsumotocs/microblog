<?php

declare(strict_types=1);

namespace Project\Http;

use Project\Http\Middleware\MiddlewareListInterface;

class Application
{
    public function __construct(
        private MiddlewareListInterface $middlewares,
    ) {
    }

    public function __invoke(): void
    {
        $this->run(Request::createFromGlobals())->send();
    }

    public function run(Request $request): Response
    {
        $response = new Response();
        $response->body = 'Hello, world!';
        return $response;
    }
}
