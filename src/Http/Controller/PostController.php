<?php

declare(strict_types=1);

namespace Project\Http\Controller;

use DateTimeImmutable;
use Project\Http\Request;
use Project\Http\Response;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Sqids\Sqids;

class PostController implements ControllerInterface
{
    use ControllerTrait;

    public function index(Request $request): Response
    {
        $response = new Response();
        $response->body .= '<html><body>';
        $response->body .= '</body><html>';

        return $response;
    }

    public function create(Request $request): Response
    {
        $content = trim($request->inputs['content'] ?? '');

        $id = (string) Uuid::uuid4();

        $createdAt = (new DateTimeImmutable())->getTimestamp();

        $postData = compact('id', 'createdAt', 'content', 'request');

        $file = __DIR__ . '/../../../storage/posts/' . $id . '.json';
        if (file_put_contents($file, json_encode($postData), LOCK_EX) === false) {
            throw new RuntimeException(sprintf('Unable to put %s', $file));
        }

        $response = new Response();
        $response->headers['Content-Type'] = 'application/json; charset=UTF-8';
        $response->body .= json_encode($postData);

        return $response;
    }
}
