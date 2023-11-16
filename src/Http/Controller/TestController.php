<?php

declare(strict_types=1);

namespace Project\Http\Controller;

use Project\Http\Request;
use Project\Http\Response;
use RuntimeException;

class TestController implements ControllerInterface
{
    use ControllerTrait;

    public function __invoke(Request $request): Response
    {
        return new Response(Response::STATUS_OK, [], 'It works!');
    }

    public function item(Request $request, array $params): Response
    {
        //throw new RuntimeException('test');

        $response = new Response();
        $response->body = 'Item action with params: ' . implode(', ', $params) . ' in ' . $this::class;

        return $response;
    }
}
