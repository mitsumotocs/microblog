<?php

declare(strict_types=1);

namespace Project\Di;

use ArrayAccess;
use BadMethodCallException;
use OutOfBoundsException;
use ReflectionClass;
use ReflectionMethod;

class Container implements ArrayAccess
{
    private array $cache = [];

    public function __construct(
        private array $definitions,
    ) {
    }

    public function get(string $id): mixed
    {
        // cached
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        // factory
        if (is_callable($this->definitions[$id] ?? null)) {
            $object = call_user_func($this->definitions[$id], $this);
            $this->cache[$id] = $object;

            return $object;
        }

        // value
        if (array_key_exists($id, $this->definitions)) {
            return $this->definitions[$id];
        }

        // autowiring
        if (class_exists($id)) {
            $constructor = (new ReflectionClass($id))->getConstructor();

            if ($constructor instanceof ReflectionMethod) {
                $dependencies = [];
                foreach ($constructor->getParameters() as $parameter) {
                    $dependencies[] = $this->get((string) $parameter->getType());
                }
                $object = new $id(...$dependencies);
            } else {
                $object = new $id();
            }

            $this->cache[$id] = $object;

            return $object;
        }

        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        throw new OutOfBoundsException(sprintf('Unable to find "%s" required from %s:%s', $id, $backtrace[0]['file'], $backtrace[0]['line']));
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new BadMethodCallException('Not allowed to set stuff');
    }

    public function offsetExists(mixed $offset): bool
    {
        try {
            $this->get($offset);

            return true;
        } catch (OutOfBoundsException $thrown) {
            return false;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new BadMethodCallException('Not allowed to unset stuff');
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }
}
