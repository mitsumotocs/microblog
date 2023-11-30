<?php

declare(strict_types=1);

namespace Project\Storage;

interface StorageInterface
{
    // TODO: should TYPE arguments
    public function save($entity, $resource): void;

    // public function load($resource): Entity
    // public function createIfNo($resource) - not sure if I need this

}
