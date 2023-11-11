<?php

declare(strict_types=1);

namespace Project\Http;

use LogicException;
use Project\Http\Controller\ControllerInterface;
use Project\Http\Middleware\MiddlewareStack;
use Project\Http\Middleware\RoutingMiddleware;

class Application
{
    public MiddlewareStack $middlewareStack;

    public function __construct()
    {
        $this->middlewareStack = new MiddlewareStack();
        $this->middlewareStack->push(new RoutingMiddleware());
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

    public function handleRequest(Request $request): Response
    {
        return $this->middlewareStack->first()($request, $this->middlewareStack);
    }

    public function route(string $method, string $pattern, ControllerInterface $controller, ?string $action = null): self
    {
        /** @var RoutingMiddleware $router */
        $router = $this->middlewareStack->last();
        if (!$router instanceof RoutingMiddleware) {
            throw new LogicException('Unable to get the routing middleware');
        }

        $router->route($method, $pattern, $controller, $action);

        return $this;
    }
}