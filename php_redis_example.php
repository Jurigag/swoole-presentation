<?php

for ($i = 0; $i < 100; $i++) {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l'];
    foreach ($keys as $key) {
        $redis->set($key . $i, rand(1, 1000));
    }
}
$result = [];
for ($i = 0; $i < 10; $i++) {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l'];
    foreach ($keys as $key) {
        $result[] = $redis->get($key . $i);
    }
}
echo json_encode($result);
