<?php

use Swoole\Http\Server as ServerAlias;

require 'vendor/autoload.php';

$http = new ServerAlias("0.0.0.0", 80);
$http->set([
    'worker_num' => 8
]);

$channel = new \Swoole\Coroutine\Channel(1);
$channel2 = new \Swoole\Coroutine\Channel(1);

go(function () use ($channel) {
    $pool = new \Smf\ConnectionPool\ConnectionPool([
        'minActive' => 1,
        'maxActive' => 18, // workes * maxActive
        'maxWaitTime' => 60,
        'maxIdleTime' => 20,
        'idleCheckInterval' => 10,
    ],
        new \Smf\ConnectionPool\Connectors\CoroutineMySQLConnector(),
        [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'password' => 'indahash',
            'database' => 'test',
            'timeout' => 10,
            'charset' => 'utf8',
        ]
    );
    $pool->init();
    $channel->push($pool);
});

$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) use ($channel, $channel2) {
    go(function () use ($channel, $response, $channel2) {
        $pool = $channel->pop();
        $mysql = $pool->borrow();
        defer(function () use ($pool, $mysql) {
            $pool->return($mysql);
        });
        $result = $mysql->query('SELECT * from users');
        $channel2->push($result);
    });
    go(function () use ($channel2, $response) {
        $result = $channel2->pop();
        $response->end(json_encode($result));
    });
});

$http->start();

