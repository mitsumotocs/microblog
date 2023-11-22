<?php

declare(strict_types=1);

namespace Project\Http;

use RuntimeException;

class Session
{
    public readonly string $id;
    public array $data;

    public function __construct(
        public readonly array $options = [],
    ) {
        $status = session_status();
        if ($status === PHP_SESSION_DISABLED) {
            throw new RuntimeException('Session is disabled');
        }
        if ($status === PHP_SESSION_NONE) {
            if (session_start($this->options) === false) {
                throw new RuntimeException('Failed to start a session');
            }
        }

        $this->id = session_id();
        $this->data = &$_SESSION;
    }

    public function renew(): self
    {
        if (session_regenerate_id() === false) {
            throw new RuntimeException('Failed to renew the session');
        }

        return new self($this->options);
    }
}
