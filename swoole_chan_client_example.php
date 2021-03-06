<?php

use Swoole\Coroutine\Http\Client;

$chan = new chan(42);

go(function () use ($chan) {
    $result = [];
    for ($i = 0; $i < 42; $i++)
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

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.indahash.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.indahash.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.indahash.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.wykop.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.wykop.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.wykop.pl' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.facebook.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.facebook.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.facebook.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.onet.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.onet.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.onet.pl' => $cli->statusCode]);
});
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

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.indahash.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.indahash.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.indahash.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.wykop.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.wykop.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.wykop.pl' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.facebook.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.facebook.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.facebook.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.onet.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.onet.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.onet.pl' => $cli->statusCode]);
});
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

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.indahash.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.indahash.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.indahash.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.wykop.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.wykop.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.wykop.pl' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.facebook.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.facebook.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.facebook.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.onet.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.onet.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.onet.pl' => $cli->statusCode]);
});
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

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.indahash.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.indahash.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.indahash.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.wykop.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.wykop.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.wykop.pl' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.facebook.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.facebook.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.facebook.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.onet.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.onet.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.onet.pl' => $cli->statusCode]);
});
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

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.indahash.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.indahash.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.indahash.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.wykop.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.wykop.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.wykop.pl' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.facebook.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.facebook.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.facebook.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.onet.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.onet.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.onet.pl' => $cli->statusCode]);
});
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

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.indahash.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.indahash.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.indahash.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.wykop.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.wykop.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.wykop.pl' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.facebook.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.facebook.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.facebook.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.onet.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.onet.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.onet.pl' => $cli->statusCode]);
});
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

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.indahash.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.indahash.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.indahash.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.wykop.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.wykop.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.wykop.pl' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.facebook.com', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.facebook.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.facebook.com' => $cli->statusCode]);
});

go(function () use ($chan) {
    $cli = new Swoole\Coroutine\Http\Client('www.onet.pl', 80);
    $cli->set(['timeout' => 10]);
    $cli->setHeaders([
        'Host' => "www.onet.pl",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $ret = $cli->get('/');
    $chan->push(['www.onet.pl' => $cli->statusCode]);
});
