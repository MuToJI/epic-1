<?php namespace Epic\DB;

class Cachable implements DataBase
{
    /**
     * @var DataBase $main
     * @var DataBase $cache
     */
    private $main, $cache;

    /**
     * @param DataBase $main
     * @param DataBase $cache
     */
    public function __construct(DataBase $main, DataBase $cache)
    {
        $this->main = $main;
        $this->cache = $cache;
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
        $res = $this->main->save($key, $value, $ttl, empty($options['main']) ? [] : $options['main'], $exception_callback);
        if (!empty($res)) {
            $this->cache->save($key, $value, empty($options['cache']['ttl']) ? $ttl : $options['cache']['ttl'], empty($options['cache']) ? [] : $options['cache'], $exception_callback);
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
        $res = $this->main->delete($key, empty($options['main']) ? [] : $options['main'], $exception_callback);
        if (!empty($res)) {
            $this->cache->delete($key, empty($options['cache']) ? [] : $options['cache'], $exception_callback);
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
        $res = $this->cache->load($key, empty($options['cache']) ? [] : $options['cache'], $exception_callback);
        if (!empty($res)) {
            return $res;
        }

        $res = $this->main->load($key, empty($options['main']) ? [] : $options['main'], $exception_callback);
        if (!empty($res)) {
            $this->cache->save($key, $res, empty($options['cache']['ttl']) ? 0 : $options['cache']['ttl'], empty($options['cache']) ? [] : $options['cache'], $exception_callback);
        }

        return $res;
    }

    /**
     * @param mixed $query
     * @param array $options
     * @param null $exception_callback - function to call
     * @return mixed
     */
    public function query($query, $options = [], $exception_callback = null)
    {
        return $this->main->query($query, $options, $exception_callback);
    }

    /**
     * @return null
     */
    public function getConnection()
    {
        return null;
    }
}