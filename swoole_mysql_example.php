<?php

use Smf\ConnectionPool\ConnectionPool;
use Smf\ConnectionPool\ConnectionPoolTrait;
use Smf\ConnectionPool\Connectors\CoroutineMySQLConnector;
use Swoole\Coroutine\MySQL;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

require 'vendor/autoload.php';

const CORE_NUM = 1;
const WORKER_PER_CORE = 2;

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
            $channel = new \Swoole\Coroutine\Channel(25);
            go(function () use ($channel, $response) {
                $result = [];
                for ($i = 0; $i < 25; $i++) {
                    $result[] = $channel->pop();
                }
                $response->header('Content-Type', 'application/json');
                $response->end(json_encode($result));
            });
            go(function () use ($channel) {
                $pool1 = $this->getConnectionPool('mysql');
                for ($i = 0; $i < 25; $i++) {
                    go(function () use ($channel, $pool1) {
                        $mysql = $pool1->borrow();
                        defer(function () use ($pool1, $mysql) {
                            $pool1->return($mysql);
                        });
                        $from = ['users', 'users2', 'users3', 'users4', 'users5'];
                        $result = $mysql->query("SELECT * FROM " . $from[array_rand($from)]);
                        $channel->push($result);
                    });
                }
            });
        });
    }

    protected function bindWorkerEvents()
    {
        $createPools = function () {
            // All MySQL connections: [4 workers * 2 = 8, 4 workers * 10 = 40]
            $pool1 = new ConnectionPool(
                [
                    'minActive' => 2,
                    'maxActive' => floor(500/(CORE_NUM*WORKER_PER_CORE)),
                ],
                new CoroutineMySQLConnector,
                [
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => 'indahash',
                    'database' => 'test',
                    'timeout' => 10,
                    'charset' => 'utf8',
                    'strict_type' => true,
                    'fetch_mode' => true,
                ]);
            $pool1->init();
            $this->addConnectionPool('mysql', $pool1);
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
