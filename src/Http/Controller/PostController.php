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

        // render response
        $response = new Response();
        $response->body .= '<html><body>';
        // $response->body .= '<pre>';
        // $response->body .= var_export($posts, true);
        // $response->body .= '</pre>';
        $response->body .= '<h1>Post Index</h1>';
        foreach ($posts as $post) {
            $response->body .= sprintf('<h2>%s</h2>', date('Y-m-d H:i:s', (int) $post['createdAt'] ?? 0));
            $response->body .= sprintf('<p><i>%s</i></p>', $post['id']);
            $response->body .= sprintf('<p>%s</p>', $post['content']);
            $response->body .= '<hr>';
        }
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

    public function form(Request $request): Response
    {
        $response = new Response();

        $response->body = <<<EOH
<html>
<head>
</head>
<body style="font-size: 16px;">
<h1>New Post</h1>
<form method="post" action="/posts/create">
<textarea rows="10" name="content" placeholder="Hello, world!" style="width: 100%; font-size: inherit;"></textarea>
<button type="submit">create</button>
</form>
</body>
</html>
EOH;

        return $response;
    }
}
