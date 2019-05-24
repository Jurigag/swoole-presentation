<?php

function sleep1()
{
    echo 'a';
    sleep(1);
}

function sleep2()
{
    echo 'b';
    sleep(2);
}

echo PHP_EOL;
sleep1();
sleep2();
