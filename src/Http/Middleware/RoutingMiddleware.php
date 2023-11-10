<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use BadMethodCallException;
use InvalidArgumentException;
use Project\Http\Controller\ControllerInterface;
use Project\Http\Request;
use Project\Http\Response;
use RuntimeException;

class RoutingMiddleware
{
    public function __construct(
        private array $routes = [],
    ) {
    }

    public function __invoke(Request $request, MiddlewareStack $stack): Response
    {
        if (empty($this->routes)) {
            throw new BadMethodCallException('No routes set; required at least one route');
        }

        /** @var array $route */
        foreach ($this->routes as $route) {
            if ($route['method'] !== '*' && strcasecmp($route['method'], $request->method) !== 0) {
                continue;
            }

            if (preg_match($route['pattern'], self::normalizeUrl($request->url), $params) !== 1) {
                continue;
            }

            if (isset($route['action']) && !method_exists($route['controller'], $route['action'])) {
                throw new RuntimeException(sprintf('Action "%s" is not implemented in %s', $route['action'], $route['controller']::class));
            }

            array_shift($params);

            // TODO: fix the bug!
            return isset($route['action']) ? $route['controller']->$route['action']($request, $params) : $route['controller']($request, $params);
        }

        return new Response(Response::STATUS_NOT_FOUND);
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
