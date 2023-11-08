<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use Exception;

class MiddlewareStack
{
    private int $length = 0;
    private int $cursor = 0;

    public function __construct(
        private array $middlewares = [],
    ) {
        $this->length = count($this->middlewares);
    }

    public function push(MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
        $this->length = count($this->middlewares);

        return $this;
    }

    public function first(): MiddlewareInterface
    {
        if ($this->length === 0) {
            throw new Exception('No middlewares set');
        }

        $this->cursor = count($this->middlewares) - 1;

        return $this->middlewares[$this->cursor];
    }

    public function next(): MiddlewareInterface
    {
        if ($this->length === 0) {
            throw new Exception('No middlewares set');
        }

        $this->cursor -= 1;

        if ($this->cursor < 0) {
            throw new Exception('No more middlewares');
        }

        return $this->middlewares[$this->cursor];
    }
}
