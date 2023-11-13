<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use Project\Http\Request;
use Project\Http\Response;
use Throwable;

class ErrorHandlingMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, MiddlewareStack $stack): Response
    {
        try {
            $response = $stack->next()($request, $stack);
        } catch (Throwable $thrown) {
            $response = new Response(Response::STATUS_INTERNAL_SERVER_ERROR, [], $thrown->getMessage());
        }

        $response->body = match ($response->status) {
            Response::STATUS_NOT_FOUND => 'Not Found',
            Response::STATUS_FORBIDDEN => 'Forbidden',
            Response::STATUS_INTERNAL_SERVER_ERROR => 'Internal Server Error',
            default => $response->body,
        };

        return $response;
    }
}
