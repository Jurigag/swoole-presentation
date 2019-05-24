<?php

$pdo = new PDO("postgresql:host=host=db-postgresql-fra1-10918-do-user-1047222-0.db.ondigitalocean.com;port=25061;dbname=Pool1", 'doadmin', 'ghs91r5le9l8t2zc');
$result = [];
$result[] = $pdo->query('select * from users')->fetchAll();
$result[] = $pdo->query('select * from users2')->fetchAll();
$result[] = $pdo->query('select * from users3')->fetchAll();
$result[] = $pdo->query('select * from users4')->fetchAll();
$result[] = $pdo->query('select * from users5')->fetchAll();
echo json_encode($result);
