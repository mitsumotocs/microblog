<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use Project\Http\Request;
use Project\Http\Response;

class ContentLengthMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, MiddlewareStack $stack): Response
    {
        $response = $stack->next()($request, $stack);
        $response->headers['Content-Length'] = strlen($response->body);

        return $response;
    }
}
