<?php

use Swoole\Http\Server as ServerAlias;

require 'vendor/autoload.php';

$http = new ServerAlias("0.0.0.0", 80);
$http->set([
    'worker_num' => 8
]);

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
        'strict_type' => true,
        'fetch_mode'  => true,
    ]
);
$pool->init();

$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) use($pool) {
    $mysql = $pool->borrow();
    $result = $mysql->query('select * FROM users');
    $pool->return($mysql);
    $response->end(json_encode($result));
});

$http->start();

