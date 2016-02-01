<?php

define('TEMPLATE_DIR', __DIR__);

$mysql = connection([
                       'host' => 'localhost',
                       'port' => '',
                       'user' => 'some',
                       'password' => '',
                    ]);

echo template('index.html', ['test' => 'some']);

//=======================================================================
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