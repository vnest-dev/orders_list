<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$_ENV['DB_CONTAINER_NAME']};dbname={$_ENV['MYSQL_DATABASE']}",
    'username' => "{$_ENV['MYSQL_USER']}",
    'password' => "{$_ENV['MYSQL_PASSWORD']}",
    'charset' => 'utf8',

];
