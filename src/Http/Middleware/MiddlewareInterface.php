<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use Project\Http\Request;
use Project\Http\Response;

interface MiddlewareInterface
{
    public function __invoke(Request $request, MiddlewareStack $stack): Response;
}