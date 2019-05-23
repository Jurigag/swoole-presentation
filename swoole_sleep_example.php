<?php

\Swoole\Runtime::enableCoroutine();
go(function(){
    echo 'a';
    sleep(1);
});
go(function(){
    echo 'b';
    sleep(2);
});
