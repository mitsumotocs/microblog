<?php

declare(strict_types=1);

namespace Project\Http\Middleware;

use Project\Http\Request;
use Project\Http\Response;

class PerformanceMonitoringMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, MiddlewareStack $stack): Response
    {
        $start = microtime(true);

        $response = $stack->next()($request, $stack);

        $end = microtime(true);

        $response->headers['X-Execution-Time'] = sprintf('%.2f ms', ($end - $start) * 1000);
        $response->headers['X-Loaded-Files'] = count(get_included_files());

        return $response;
    }
}
