<?php

declare(strict_types=1);

use Project\Domain\Post;
use Project\Domain\PostModel;
use Project\Storage\JsonFileStorage;

require_once __DIR__ . '/../../vendor/autoload.php';

$storage = new JsonFileStorage();

$postModel = new PostModel($storage);

$post = new Post();

$postModel->add($post);
