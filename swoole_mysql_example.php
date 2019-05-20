<?php

use Swoole\Http\Server as ServerAlias;

require 'vendor/autoload.php';

$http = new ServerAlias("0.0.0.0", 80);
$http->set([
    'worker_num' => 8
]);

$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    $channel = new \Swoole\Coroutine\Channel(1);
    go(function() use($channel) {

        $pool = new \Smf\ConnectionPool\ConnectionPool([
            'minActive'         => 1,
            'maxActive'         => 18, // workes * maxActive
            'maxWaitTime'       => 60,
            'maxIdleTime'       => 20,
            'idleCheckInterval' => 10,
        ],
            new \Smf\ConnectionPool\Connectors\CoroutineMySQLConnector(),
            [
                'host'        => '127.0.0.1',
                'port'        => '3306',
                'user'        => 'root',
                'password'    => 'indahash',
                'database'    => 'test',
                'timeout'     => 10,
                'charset'     => 'utf8',
            ]
        );
        $pool->init();
        $mysql = $pool->borrow();
        defer(function () use ($pool) {
            $pool->close();
        });
        $result = $mysql->query('select * FROM users');
        $channel->push($result);
    });
    go(function() use ($channel, $response) {
        $response->end(json_encode($channel->pop()));
    });
});

$http->start();

