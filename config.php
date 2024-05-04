<?php

return [
  'database' => [
    'dbname' => 'bazaar_books',
    'username' => 'root',
    'password' => '', //'root' in MAMP //'' (empty) in easyPHP
    'connection' => 'mysql:host=127.0.0.1',
    'port' => ' 3306', // '8889' default port in MAMP //  '3306' in easyPHP
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
      PDO::ATTR_PERSISTENT => true
    ]
  ],
  'install_prefix' => './',
];
