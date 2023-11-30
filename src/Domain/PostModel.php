<?php

declare(strict_types=1);

namespace Project\Domain;

use Project\Storage\StorageInterface;

class PostModel
{
    public function __construct(
        private StorageInterface $storage,
    )
    {

    }

    public function add(Post $post): void
    {
        $this->storage->save($post, 'posts/' . $post->id);
    }
}