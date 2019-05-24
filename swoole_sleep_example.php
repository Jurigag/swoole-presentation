<?php

\Swoole\Runtime::enableCoroutine();
go(function(){
    while(true) {
        echo 'a';
    }
});
go(function(){
    while(true) {
        echo 'b';
    }
});
