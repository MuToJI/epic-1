<?php namespace Epic\DB;

interface DataBase
{
    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @param array $options
     * @param null $exception_callback
     * @return bool
     */
    public function save($key, $value, $ttl = 0, $options = [], $exception_callback = null);

    /**
     * @param string $key
     * @param array $options
     * @param null $exception_callback
     * @return bool
     */
    public function delete($key, $options = [], $exception_callback = null);

    /**
     * @param $key
     * @param array $options
     * @param null $exception_callback
     * @return mixed
     */
    public function load($key, $options = [], $exception_callback = null);

    /**
     * @param $query
     * @param array $options
     * @param null $exception_callback
     * @return mixed
     */
    public function query($query, $options = [], $exception_callback = null);

    /**
     * @return mixed
     */
    public function getConnection();
}