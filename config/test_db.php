<?php

$db = require __DIR__ . '/db.php';

$db['dsn'] = 'mysql:host=db;dbname=' . getenv('MYSQL_DATABASE') . '_tests';

return $db;
