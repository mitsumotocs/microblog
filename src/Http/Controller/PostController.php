<?php

declare(strict_types=1);

namespace Project\Http\Controller;

use DateTimeImmutable;
use Project\Http\Request;
use Project\Http\Response;
use Ramsey\Uuid\Uuid;
use RuntimeException;

class PostController implements ControllerInterface
{
    use ControllerTrait;

    public function index(Request $request): Response
    {
        // read post index
        $indexFile = __DIR__ . '/../../../storage/meta/index.json';
        $indexDataString = file_get_contents($indexFile);
        if ($indexDataString === false) {
            throw new RuntimeException(sprintf('Unable to get %s', $indexDataString));
        }
        $indexData = json_decode($indexDataString, true);

        // read posts
        $posts = [];
        foreach ($indexData as $postId) {
            $postFile = __DIR__ . '/../../../storage/posts/' . $postId . '.json';
            $postDataString = file_get_contents($postFile);
            if ($postDataString === false) {
                throw new RuntimeException(sprintf('Unable to get %s', $postDataString));
            }
            $postData = json_decode($postDataString, true);
            $posts[] = $postData;
        }

        $response = new Response();
        $response->body .= '<html><body>';
        $response->body .= '<pre>';
        $response->body .= var_export($posts, true);
        $response->body .= '</pre>';
        $response->body .= '</body><html>';

        return $response;
    }

    public function create(Request $request): Response
    {
        // save the post
        $content = trim($request->inputs['content'] ?? '');

        $id = (string) Uuid::uuid4();

        $createdAt = (new DateTimeImmutable())->getTimestamp();

        $postData = compact('id', 'createdAt', 'content', 'request');

        $postFile = __DIR__ . '/../../../storage/posts/' . $id . '.json';
        if (file_put_contents($postFile, json_encode($postData), LOCK_EX) === false) {
            throw new RuntimeException(sprintf('Unable to put %s', $postFile));
        }

        // update post index
        $indexFile = __DIR__ . '/../../../storage/meta/index.json';
        $indexDataString = file_get_contents($indexFile);
        if ($indexDataString === false) {
            throw new RuntimeException(sprintf('Unable to get %s', $indexDataString));
        }
        $indexData = json_decode($indexDataString, true);
        array_push($indexData, $postData['id']);
        if (file_put_contents($indexFile, json_encode($indexData), LOCK_EX) == false) {
            throw new RuntimeException(sprintf('Unable to put %s', $indexFile));
        }

        $response = new Response();
        $response->headers['Content-Type'] = 'application/json; charset=UTF-8';
        $response->body .= json_encode($postData);

        return $response;
    }
}
