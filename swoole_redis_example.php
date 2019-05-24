<?php

require 'vendor/autoload.php';

use Smf\ConnectionPool\ConnectionPool;
use Smf\ConnectionPool\Connectors\CoroutineRedisConnector;

\Swoole\Runtime::enableCoroutine();
$pool = new ConnectionPool(
    [
        'minActive' => 1,
        'maxActive' => 1000,
        'maxWaitTime' => 5,
        'maxIdleTime' => 20,
        'idleCheckInterval' => 10,
    ],
    new CoroutineRedisConnector,
    [
        'host' => '10.135.85.41',
        'port' => '6379',
        'database' => 0,
        'password' => null,
        'options' => [
            'connect_timeout' => 1,
            'timeout' => 5,
        ],
    ]
);
$pool->init();
$channel = new \Swoole\Coroutine\Channel(100);
go(function () use ($channel, $pool) {
    for ($i = 0; $i < 10; $i++) {
        go(function () use ($pool, $i) {
            $redis = $pool->borrow();
            defer(function () use ($pool, $redis) {
                $pool->return($redis);
            });
            $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l'];
            foreach ($keys as $key) {
                $redis->set($key . $i, rand(1, 1000));
            }
        });
    }
});
go(function () use ($channel, $pool) {
    for ($i = 0; $i < 10; $i++) {
        go(function () use ($channel, $pool, $i) {
            $redis = $pool->borrow();
            defer(function () use ($pool, $redis) {
                $pool->return($redis);
            });
            $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l'];
            foreach ($keys as $key) {
                $channel->push($redis->get($key . $i));
            }
        });
    }
});
go(function () use ($channel) {
    $result = [];
    for ($i = 0; $i < 100; $i++) {
        $result[] = $channel->pop();
    }
    print_r($result);
    defer(function() {
       echo 'end';
    });
});
