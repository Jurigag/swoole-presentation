<?php

Swoole\Runtime::enableCoroutine();

go(function () {
    echo "a";
    defer(function () {
        sleep(1);
        echo "~a";
    });
    echo "b";
    defer(function () {
        sleep(2);
        echo "~b";
    });
    sleep(1);
    echo "c";
});
