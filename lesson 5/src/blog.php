<?php

/**
 * @param $token
 * @return bool
 */
function valid_token($token)
{
    return !empty($token) && !empty($_SESSION['token']) && $token === $_SESSION['token'];
}

/**
 * @param array $config
 * @return PDO
 */
function connection(array $config)
{
    $connection = new \PDO("mysql:host={$config['host']}" . (empty($config['port']) ? '' : ";port:{$config['port']}"), $config['user'], $config['password'], [
       \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
       \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ]);
    empty($config['dbname']) ?: $connection->query("USE `{$config['dbname']}`");
    empty($config['encoding']) ?: $connection->query("SET NAMES '{$config['encoding']}'");
    return $connection;
}

/**
 * @param $name
 * @param array $vars
 * @return string
 * @throws exception
 */
function template($name, array $vars = [])
{
    if (!is_file(TEMPLATE_DIR . "/{$name}")) {
        throw new exception("Could not load template file {$name}");
    }
    ob_start();
    extract($vars);
    require(TEMPLATE_DIR . "/{$name}");
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}

/**
 * @param PDO $connection
 * @param $input
 * @return array
 */
function user(\PDO $connection = null, $input = [])
{
    if (!empty($_SESSION['user'])) {
        return $_SESSION['user'];
    }

    if (empty($connection) || empty($input['login']) || empty($input['password'])) {
        return [];
    }

    $query = $connection->prepare("SELECT * FROM `users` WHERE `login`=:login AND `password`=:password");
    $query->execute([
                       ':login' => $input['login'],
                       ':password' => md5($input['password']),
                    ]);
    $user = $query->fetch();
    if (!empty($user)) {
        $_SESSION['user'] = $user;
    }
    return $user;
}

/**
 * @param PDO $connection
 * @param array $input
 * @param array $user
 * @return bool
 */
function insert_message(\PDO $connection, array $input, array $user)
{
    $statement = $connection->prepare('INSERT INTO `messages` SET `message`=:message, `user_id`=:user_id, `time`=:time');
    return $statement->execute([':message' => $input['message'], ':user_id' => $user['id'], ':time' => date('Y-m-d H:i:s')]);
}

/**
 * @param PDO $connection
 * @return array
 */
function load_messages(\PDO $connection)
{
    return $connection->query('SELECT m.`message`, m.`time`, u.`login` FROM `messages` m LEFT JOIN `users` u ON `m`.`user_id`=`u`.`id` ORDER BY m.`time` DESC')->fetchAll();
}

/**
 * @param $uri
 * @param $routes
 * @return string|bool
 */
function routes($uri, $routes)
{
    $request = parse_url($uri);
    $params = [];
    if (!empty($request['query'])) {
        parse_str($request['query'], $params);
    }

    foreach ($routes as $route => $callback) {
        if (preg_match("#/[/]?{$route}[/]?#", $request['path']) && is_callable($callback)) {
            return $callback($params);
        }
    }
    return false;
}