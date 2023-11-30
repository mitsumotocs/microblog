<?php

declare(strict_types=1);

namespace Project\Storage;

class JsonFileStorage implements StorageInterface
{
    private const DIRECTORY = __DIR__ . '/../../storage';

    public function save($entity, $resource): void
    {
        echo sprintf('saving %s to %s...', (string) $entity, realpath(self::DIRECTORY) . DIRECTORY_SEPARATOR . $resource), PHP_EOL;
    }
}