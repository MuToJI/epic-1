<?php namespace Epic\DB;

class MySQL implements DataBase
{
    private $connection;

    public function __construct(array $config)
    {
        $this->connection = new \PDO("mysql:host={$config['host']}" . (empty($config['port']) ? '' : ";port:{$config['port']}"), $config['user'], $config['password'], [
           \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
           \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
        empty($config['dbname']) ?: $this->connection->query("USE `{$config['dbname']}`");
        empty($config['encoding']) ?: $this->connection->query("SET NAMES '{$config['encoding']}'");
    }

    public function save($key, $value, $ttl = 0, $options = [], $exception_callback = null)
    {
        return false;
    }

    public function delete($key, $options = [], $exception_callback = null)
    {
        return false;
    }

    public function load($key, $options = [], $exception_callback = null)
    {
        return false;
    }

    public function query($query, $options = [], $exception_callback = null)
    {
        return $this->connection->query($query);
    }

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}