<?php

\Swoole\Runtime::enableCoroutine();
go(function(){
    while(true) {
        echo 'a';
        sleep(1);
    }
});
go(function(){
    while(true) {
        echo 'b';
        sleep(2);
    }
});
