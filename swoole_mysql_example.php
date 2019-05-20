<?php

use Swoole\Http\Server as ServerAlias;

$http = new ServerAlias("0.0.0.0", 80);
$http->set([
    'worker_num' => 8
]);

$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    $mysql = new Swoole\Coroutine\MySQL();
    $mysql->connect([
        'host' => '127.0.0.1',
        'user' => 'user',
        'password' => 'pass',
        'database' => 'test',
    ]);
    $mysql->setDefer();
    $mysql->query('select * FROM users');
    $mysql_response = $mysql->recv();
    $response->end(json_encode($mysql_response));
});

$http->start();

