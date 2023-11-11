<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use Exception;

class MiddlewareStack
{
    private int $cursor = 0;

    public function __construct(
        private array $middlewares = [],
    ) {
    }

    public function push(MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    public function at(int $index): MiddlewareInterface
    {
        if (!isset($this->middlewares[$index])) {
            throw new Exception(sprintf('No middleware set at index #%d', $index));
        }

        return $this->middlewares[$index];
    }

    public function first(): MiddlewareInterface
    {
        if (empty($this->middlewares)) {
            throw new Exception('No middlewares set');
        }

        $this->cursor = count($this->middlewares) - 1;

        return $this->middlewares[$this->cursor];
    }

    public function last(): MiddlewareInterface
    {
        if (empty($this->middlewares)) {
            throw new Exception('No middlewares set');
        }

        $this->cursor = 0;

        return $this->middlewares[$this->cursor];
    }

    public function next(): MiddlewareInterface
    {
        if (empty($this->middlewares)) {
            throw new Exception('No middlewares set');
        }

        if (!isset($this->middlewares[$this->cursor - 1])) {
            throw new Exception('No more middlewares');
        }

        $this->cursor -= 1;

        return $this->middlewares[$this->cursor];
    }
}
