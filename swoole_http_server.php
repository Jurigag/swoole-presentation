<?php

use Swoole\Http\Server as ServerAlias;

const CORE_NUM = 1;
const WORKER_PER_CORE = 2;

$http = new ServerAlias("0.0.0.0", 80);
$http->set([
    'worker_num' => CORE_NUM * WORKER_PER_CORE,
    'reactor_num' => CORE_NUM,
    'task_ipc_mode' => 1,
    'dispatch_mode' => 1,
    'enable_reuse_port' => 1,
    'open_tcp_nodelay' => 1,
]);

$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("<h1>Hello World</h1>");
});

\Swoole\Runtime::enableCoroutine();
$http->start();
