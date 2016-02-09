<?php
/**
 * @param array $config
 * @return PDO
 */
function connection(array $config)
{
    return new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['user'], $config['password'], [
       \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
       \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
       \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['encoding']}"
    ]);
}

/**
 * @param PDO $connection
 * @param $message
 * @param $user_id
 * @param null $time
 * @return bool
 */
function insert_message(\PDO $connection, $message, $user_id, $time = null)
{
    if (empty($message)) {
        return false;
    }

    $params = [
       'message' => $message,
       'user_id' => $user_id,
    ];

    if (empty($time)) {
        $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=:user_id';
    } else {
        $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=:time, `user_id`=:user_id';
        $params['time'] = date('Y-m-d H:i:s', $time);
    }
    $query = $connection->prepare($sql);
    return $query->execute($params);
}

/**
 * @param PDO $connection
 * @param $message
 * @param $message_id
 * @return bool
 */
function update_message(\PDO $connection, $message, $message_id)
{
    if (empty($message)) {
        return false;
    }

    $query = $connection->prepare('UPDATE `messages` SET `message`=:message WHERE `id`=:message_id');
    return $query->execute([
                              'message' => $message,
                              'message_id' => $message_id
                           ]);
}

/**
 * @param PDO $connection
 * @param null $message_id
 * @return array
 */
function load_messages(\PDO $connection, $message_id = null)
{
    if ($message_id !== null) {
        $message_id = (int)$message_id;
    }
    return
       $message_id === null
          ? $connection->query('SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` ORDER BY m.`time` DESC')->fetchAll()
          : $connection->query("SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` WHERE m.`id`={$message_id} ORDER BY m.`time` DESC")->fetchAll();
}

/**
 * @param $token
 * @return bool
 */
function valid_token($token)
{
    return !empty($_SESSION['token']) && $token == $_SESSION['token'];
}

/**
 * @param $user_style
 * @return null|string
 */
function style($user_style)
{
    switch ((int)$user_style) {
        case 1:
            return 'black';
            break;
        case 2:
            return 'yellow';
            break;
    }
    return 'main';
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