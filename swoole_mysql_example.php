<?php

use Smf\ConnectionPool\ConnectionPool;
use Smf\ConnectionPool\ConnectionPoolTrait;
use Smf\ConnectionPool\Connectors\CoroutineMySQLConnector;
use Swoole\Coroutine\MySQL;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

require 'vendor/autoload.php';

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
            'worker_num'            => 8, // Each worker holds a connection pool
        ]);
    }

    protected function bindHttpEvent()
    {
        $this->swoole->on('Request', function (Request $request, Response $response) {
            $pool1 = $this->getConnectionPool('mysql');
            /**@var MySQL $mysql */
            $mysql = $pool1->borrow();
            defer(function () use ($pool1, $mysql) {
                $pool1->return($mysql);
            });
            $result = $mysql->query('SELECT * FROM users');
            $response->header('Content-Type', 'application/json');
            $response->end(json_encode($result));
        });
    }

    protected function bindWorkerEvents()
    {
        $createPools = function () {
            // All MySQL connections: [4 workers * 2 = 8, 4 workers * 10 = 40]
            $pool1 = new ConnectionPool(
                [
                    'minActive' => 5,
                    'maxActive' => 15,
                ],
                new CoroutineMySQLConnector,
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
                ]);
            $pool1->init();
            $this->addConnectionPool('mysql', $pool1);
        };
        $closePools = function () {
            $this->closeConnectionPools();
        };
        $this->swoole->on('WorkerStart', $createPools);
        $this->swoole->on('WorkerStop', $closePools);
        $this->swoole->on('WorkerError', $closePools);
    }

    public function start()
    {
        $this->swoole->start();
    }
}

$server = new HttpServer('0.0.0.0', 80);
$server->start();
