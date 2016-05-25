<?php

/**
 * @param array $config
 * @return PDO
 */
function connection(array $config)
{
    $connection = new PDO("mysql:host=localhost;dbname={$config['dbname']}", $config['user'], $config['password'], [
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]);
    return $connection;
}

/**
 * @param PDO $connection
 * @param $table
 * @param $row_id
 * @return PDOStatement
 */
function delete_row(PDO $connection, $table, $row_id)
{
    return $connection->query("DELETE FROM {$table} WHERE `id`={$row_id}");
}

/**
 * @param PDO $connection
 * @param $message
 * @param $message_id
 * @return bool
 */
function save(PDO $connection, $message, $message_id)
{
    $params[':message'] = $message;
    if (!empty($message_id)) {
        $params[':message_id'] = $message_id;
        $sql = 'UPDATE `messages` SET `message`=:message, `time`=NOW(), `user_id`=0 WHERE `id`=:message_id';
    } else {
        $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=0';
    }
    $query = $connection->prepare($sql);
    return $query->execute($params);
}

/**
 * @param $name
 * @param array $vars
 * @return string
 * @throws exception
 */
function template($name, array $vars = [])
{
    if (!is_file($name)) {
        throw new exception("Could not load template file {$name}");
    }
    ob_start();
    extract($vars);
    require($name);
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}