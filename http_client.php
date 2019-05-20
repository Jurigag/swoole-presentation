<?php

use Swoole\Http\Server as ServerAlias;

$http = new ServerAlias("127.0.0.1", 80);

$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    $response->end("<h1>Hello World. #".rand(1000, 9999)."</h1>");
});

$http->start();
