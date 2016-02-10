<?php namespace Epic\DB;

class Memcached implements DataBase
{
    private $connection;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->connection = new \Memcached(empty($config['key']) ? null : $config['key']);
        $this->connection->addServer($config['host'], $config['port']);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @param array $options
     * @param null $exception_callback
     * @return bool
     */
    public function save($key, $value, $ttl = 0, $options = [], $exception_callback = null)
    {
        $res = $this->connection->set($key, $value, $ttl);
        if ($res === false) {
            !is_callable($exception_callback) ?: $exception_callback(new \Exception($this->connection->getResultMessage()));
        }
        return $res;
    }

    /**
     * @param string $key
     * @param array $options
     * @param null $exception_callback
     * @return bool
     */
    public function delete($key, $options = [], $exception_callback = null)
    {
        $res = $this->connection->delete($key);
        if ($res === false) {
            !is_callable($exception_callback) ?: $exception_callback(new \Exception($this->connection->getResultMessage()));
        }
        return $res;
    }

    /**
     * @param $key
     * @param array $options
     * @param null $exception_callback
     * @return mixed
     */
    public function load($key, $options = [], $exception_callback = null)
    {
        $res = $this->connection->get($key);
        if ($res === false) {
            !is_callable($exception_callback) ?: $exception_callback(new \Exception($this->connection->getResultMessage()));
        }
        return $res;
    }

    /**
     * @param $query
     * @param array $options
     * @param null $exception_callback
     * @return bool
     */
    public function query($query, $options = [], $exception_callback = null)
    {
        return $this->load(md5($query), $options, $exception_callback);
    }

    /**
     * @return \Memcached
     */
    public function getConnection()
    {
        return $this->connection;
    }

}