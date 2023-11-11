<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

interface MiddlewareListInterface
{
    public function add(MiddlewareInterface $middleware): self;

    public function first(): MiddlewareInterface;

    public function next(): MiddlewareInterface;
}
