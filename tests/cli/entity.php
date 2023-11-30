<?php

declare(strict_types=1);

use Project\Domain\Post;

require_once __DIR__ . '/../../vendor/autoload.php';

$post = new Post();
var_dump($post);

$postSerialized = serialize($post);
var_dump($postSerialized);

$postUnserialized = unserialize($postSerialized);
var_dump($postUnserialized);