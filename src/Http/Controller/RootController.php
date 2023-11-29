<?php

declare(strict_types=1);

namespace Project\Http\Controller;

use Project\Http\Request;
use Project\Http\Response;

class RootController implements ControllerInterface
{
    use ControllerTrait;

    public function index(Request $request): Response
    {
        $response = new Response();

        $response->body = <<<EOH
<html>
<head>
</head>
<body style="font-size: 16px;">
<h1>Microblog example</h1>
<ul>
<li><a href="/posts">Post Index</a></li>
<li><a href="/posts/new">New Post</a></li>
</ul>
</body>
</html>
EOH;

        return $response;
    }
}
