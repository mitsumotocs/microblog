<?php

declare(strict_types=1);

namespace Project\Http;

class Application
{
    public function __invoke(): void
    {
        self::sendResponse($this->run(Request::createFromGlobals()));
    }

    public function run(Request $request): Response
    {
        $response = new Response();
        $response->body = 'Hello, world!';
        return $response;
    }

    // NOTE: or response->send() would be better?
    private static function sendResponse(Response $response): void
    {
        http_response_code($response->status);

        /*
        foreach ($response->cookies as $cookie) {
            if (!$cookie instanceof Cookie) {
                throw new DomainException('Invalid cookie');
            }
            setcookie($cookie->name, $cookie->value, $cookie->options);
        }
        */

        foreach ($response->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value));
        }

        echo $response->body;
    }
}