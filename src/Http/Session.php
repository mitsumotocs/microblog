<?php

declare(strict_types=1);

namespace Project\Http;

use ArrayAccess;
use RuntimeException;

class Session implements ArrayAccess
{
    public readonly string $id;

    public function __construct(
        public readonly array $options = [],
    ) {
        $status = session_status();
        if ($status === PHP_SESSION_DISABLED) {
            throw new RuntimeException('Session is disabled');
        }
        if ($status === PHP_SESSION_NONE || !isset($_SESSION)) {
            if (session_start($this->options) === false) {
                throw new RuntimeException('Failed to start a session');
            }
        }
        $this->id = $id ?? session_id();
    }

    public function renew(): self
    {
        if (session_regenerate_id() === false) {
            throw new RuntimeException('Failed to renew the session');
        }

        return new self($this->options);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $_SESSION[$offset] = $value;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($_SESSION[$offset]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($_SESSION[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $_SESSION[$offset];
    }
}
