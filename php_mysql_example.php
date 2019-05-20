<?php

$pdo = new PDO("mysql:host=localhost;dbname=test", 'root', 'indahash');
$result = $pdo->query('select * from users')->fetchAll();
echo json_encode($result);
