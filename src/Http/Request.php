<?php

declare(strict_types=1);

namespace Project\Http;

class Request
{
    public function __construct(
        public readonly string $method,
        public readonly string $url,
        public readonly array $headers = [],
        public readonly array $inputs = [],
    ) {
    }

    public static function createFromScratch(
        string $method,
        string $url,
        array $headers = [],
        array $inputs = [],
    ): self
    {
        return new self($method, $url, $headers, $inputs);
    }

    public static function createFromGlobals(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        $url = $_SERVER['REQUEST_URI'];

        //$protocol = $_SERVER['SERVER_PROTOCOL'];

        $headers = [];
        foreach (getallheaders() as $key => $value) {
            $headers[ucwords($key, '-')] = $value;
        }

        //$cookies = $_COOKIE;

        $inputs = $_POST;

        //$queries = $_GET;

        return new self($method, $url, $headers, $inputs);
    }
}
