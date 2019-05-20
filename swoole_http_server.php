<?php

use Swoole\Http\Server as ServerAlias;

$http = new ServerAlias("0.0.0.0", 80);
$http->set([
    'worker_num' => 8
]);

$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("<h1>Hello World</h1>");
});

$http->start();
