<?php

$chan = new chan(2);

go(function () use ($chan) {
    $result = [];
    for ($i = 0; $i < 2; $i++)
    {
        $result[] = $chan->pop();
    }
    var_dump($result);
});

// Start fetching the first webpage without blocking the script
go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.google.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.google.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.google.com' => $cli->statusCode]);
});

// Start fetching the second webpage without blocking the script
go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.bing.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.bing.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.bing.com' => $cli->statusCode]);
});
