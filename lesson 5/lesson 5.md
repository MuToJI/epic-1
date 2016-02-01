#Практическое использование sql в php

##Задачи

* подключение бд к проекту
* выборка данных и сортировка по дате
* добавление новых данных в базу
* проблемы безопасности

##Подключение
<pre>
    $config = [
      'host' => 'localhost',
      'port' => '',
      'user' => 'some',
      'password' => '',
    ];
    $mysql = new \PDO("mysql:host={$config['host']}" . (empty($config['port']) ? '' : ";port:{$config['port']}"), $config['user'], $config['password'], [
      \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
      \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ]);
    empty($config['dbname']) ?: $mysql->query("USE `{$config['dbname']}`");
    empty($config['encoding']) ?: $mysql->query("SET NAMES '{$config['encoding']}'");
</pre>