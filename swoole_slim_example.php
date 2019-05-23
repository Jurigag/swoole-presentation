<?php

use Pachico\SlimSwoole\BridgeManager;
use Slim\Http;

const CORE_NUM = 1;
const WORKER_PER_CORE = 2;

require 'vendor/autoload.php';

/**
 * This is how you would normally bootstrap your Slim application
 * For the sake of demonstration, we also add a simple middleware
 * to check that the entire app stack is being setup and executed
 * properly.
 */
$app = new \Slim\App();
$app->any('/test/{random}', function (Http\Request $request, Http\Response $response, array $args) {
    $data = [
        'args' => $args,
        'body' => (string) $request->getBody(),
        'parsedBody' => $request->getParsedBody(),
        'params' => $request->getParams(),
        'headers' => $request->getHeaders(),
        'uploadedFiles' => $request->getUploadedFiles()
    ];

    return $response->withJson($data);
});

/**
 * We instanciate the BridgeManager (this library)
 */
$bridgeManager = new BridgeManager($app);

/**
 * We start the Swoole server
 */
$http = new Swoole\Http\Server("0.0.0.0", 80);

$http->set([
    'worker_num' => CORE_NUM * WORKER_PER_CORE,
    'reactor_num' => CORE_NUM,
    'task_ipc_mode' => 1,
    'dispatch_mode' => 1,
    'enable_reuse_port' => 1,
    'open_tcp_nodelay' => 1,
//'daemonize' => true

]);

/**
 * We register the on "start" event
 */
$http->on("start", function (\Swoole\Http\Server $server) {
    echo sprintf('Swoole http server is started at http://%s:%s', $server->host, $server->port), PHP_EOL;
});

/**
 * We register the on "request event, which will use the BridgeManager to transform request, process it
 * as a Slim request and merge back the response
 *
 */
$http->on(
    "request",
    function (\Swoole\Http\Request $swooleRequest, \Swoole\Http\Response $swooleResponse) use ($bridgeManager) {
        $bridgeManager->process($swooleRequest, $swooleResponse)->end();
    }
);

$http->start();
