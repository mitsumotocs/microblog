<?php

declare(strict_types=1);

namespace Project\Http;

use Project\Http\Controller\ControllerInterface;

class Router
{
    public function __construct(
        private array $routes = [],
    ) {
    }

    public function route(string $method, string $url, ControllerInterface $controller, ?string $action = null): self
    {
        return $this;
    }
}
