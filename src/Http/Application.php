<?php

declare(strict_types=1);

namespace Project\Http;

use InvalidArgumentException;
use Project\Http\Controller\ControllerInterface;
use Project\Http\Middleware\MiddlewareListInterface;

class Application
{
    private array $routes = [];

    public function __construct(
        private Router $router,
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

    public function route(string $method, string $pattern, ControllerInterface $controller, ?string $action = null): self
    {
        if (!self::validatePattern($pattern)) {
            throw new InvalidArgumentException('Invalid regular expression pattern');
        }

        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action,
        ];

        return $this;
    }

    private static function validatePattern(string $pattern): bool
    {
        set_error_handler(function () {
        }, E_WARNING);

        $match = preg_match($pattern, '');

        restore_error_handler();

        return $match !== false;
    }

    private static function normalizeUrl(string $url): string
    {
        if (preg_match('/\A\/+\z/', $url) === 1) {
            return '/';
        }

        return rtrim(preg_replace('/\?.*\z/', '', $url), '/');
    }
}
