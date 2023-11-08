<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use Project\Http\Request;
use Project\Http\Response;

class RoutingMiddleware
{
    public function __invoke(Request $request): Response
    {
        $response = new Response();
        $response->body .= $this::class;
        return $response;
    }
}