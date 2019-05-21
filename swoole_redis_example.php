<?php

use Smf\ConnectionPool\ConnectionPool;
use Smf\ConnectionPool\ConnectionPoolTrait;
use Smf\ConnectionPool\Connectors\CoroutineMySQLConnector;
use Smf\ConnectionPool\Connectors\CoroutineRedisConnector;
use Swoole\Coroutine\MySQL;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

require 'vendor/autoload.php';

const CORE_NUM = 1;
const WORKER_PER_CORE = 2;
const CONNECTION_LIMIT = 5000;

class HttpServer
{
    use ConnectionPoolTrait;

    protected $swoole;

    public function __construct(string $host, int $port)
    {
        $this->swoole = new Server($host, $port, SWOOLE_BASE);

        $this->setDefault();
        $this->bindWorkerEvents();
        $this->bindHttpEvent();
    }

    protected function setDefault()
    {
        $this->swoole->set([
            'worker_num' => CORE_NUM * WORKER_PER_CORE, // Each worker holds a connection pool, recommended worker number is 1-4 x core number, 2 is most likely best
        ]);
    }

    protected function bindHttpEvent()
    {
        $this->swoole->on('Request', function (Request $request, Response $response) {
            /**@var MySQL $mysql */
            $channel = new \Swoole\Coroutine\Channel(100);
            go(function () use ($channel, $response) {
                $result = [];
                for ($i = 0; $i < 100; $i++) {
                    $result[] = $channel->pop();
                }
                $response->header('Content-Type', 'application/json');
                $response->end(json_encode($result));
            });
            go(function () use ($channel) {
                $pool1 = $this->getConnectionPool('redis');
                for ($i = 0; $i < 100; $i++) {
                    go(function () use ($pool1, $i) {
                        $redis = $pool1->borrow();
                        defer(function () use ($pool1, $redis) {
                            $pool1->return($redis);
                        });
                        $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l'];
                        foreach ($keys as $key) {
                            $redis->set($key . $i, rand(1, 1000));
                        }
                    });
                }
                go(function () use ($channel) {
                    $pool = $this->getConnectionPool('redis');
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
            });
        });
    }

    protected function bindWorkerEvents()
    {
        $createPools = function () {
            // All redis connections: [4 workers * 2 = 8, 4 workers * 10 = 40]
            $pool = new ConnectionPool(
                [
                    'minActive' => 1,
                    'maxActive' => floor(CONNECTION_LIMIT / (CORE_NUM * WORKER_PER_CORE)),
                    'maxWaitTime' => 5,
                    'maxIdleTime' => 20,
                    'idleCheckInterval' => 10,
                ],
                new CoroutineRedisConnector,
                [
                    'host' => '127.0.0.1',
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
            $this->addConnectionPool('redis', $pool);
        };
        $closePools = function () {
            $this->closeConnectionPools();
        };
        $this->swoole->on('WorkerStart', $createPools); // create pools on worker start
        $this->swoole->on('WorkerStop', $closePools); // close pools on worker stop
        $this->swoole->on('WorkerError', $closePools); // close pools on worker error
    }

    public function start()
    {
        $this->swoole->start();
    }
}

$server = new HttpServer('0.0.0.0', 80);
$server->start();
