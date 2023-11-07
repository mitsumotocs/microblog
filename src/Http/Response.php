<?php

declare(strict_types=1);

namespace Project\Http;

class Response
{
    public const STATUS_OK = 200;
    public const STATUS_FOUND = 302;
    public const STATUS_BAD_REQUEST = 400;
    public const STATUS_UNAUTHORIZED = 401;
    public const STATUS_FORBIDDEN = 403;
    public const STATUS_NOT_FOUND = 404;
    public const STATUS_PAYLOAD_TOO_LARGE = 413;
    public const STATUS_UNPROCESSABLE_ENTITY = 422;
    public const STATUS_TOO_MANY_REQUESTS = 429;
    public const STATUS_INTERNAL_SERVER_ERROR = 500;
    public const STATUS_SERVICE_UNAVAILABLE = 503;

    public function __construct(
        public int $status = self::STATUS_OK,
        public array $headers = [],
        public string $body = '',
    ) {
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
