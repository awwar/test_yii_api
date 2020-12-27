<?php

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => 'mysql:host=db;dbname=' . getenv('MYSQL_DATABASE'),
    'username' => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASSWORD'),
    'charset'  => 'utf8',
];
