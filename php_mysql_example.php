<?php

$pdo = new PDO("mysql:host=localhost;dbname=test", 'root', 'indahash');
$result = [];
for($i=0;$i<10;$i++) {
    $result += $pdo->query('select * from users')->fetchAll();
}
echo json_encode($result);
