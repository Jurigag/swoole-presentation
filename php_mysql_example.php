<?php

$pdo = new PDO("mysql:host=localhost;dbname=test", 'root', 'indahash');
$result = [];
$from = ['users', 'users2', 'users3', 'users4', 'users5'];
for ($i = 0; $i < 25; $i++) {
    $result[] = $pdo->query('select * from ' . $from[array_rand($from)])->fetchAll();
}
echo json_encode($result);
