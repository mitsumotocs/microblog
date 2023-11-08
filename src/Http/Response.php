<?php

declare(strict_types=1);

namespace Project\Http;

use Stringable;

class Response implements Stringable
{
    public const HTTP_VERSION = '1.1';
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

    public function __toString(): string
    {
        $lines[] = sprintf('HTTP/%s %s', self::HTTP_VERSION, $this->status);

        foreach ($this->headers as $name => $value) {
            $lines[] = sprintf('%s: %s', $name, $value);
        }

        $lines[] = '';

        $lines[] = $this->body;

        return implode("\r\n", $lines);
    }

    public static function createEmpty(): self
    {
        return new self();
    }

    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value));
        }

        echo $this->body;
    }
}
