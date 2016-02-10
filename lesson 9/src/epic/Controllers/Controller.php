<?php namespace Epic\Controllers;

abstract class Controller
{
    public function __construct()
    {
    }

    public function handle($action, $method, $params)
    {
        $handler = $this->handler($action, $method);
        var_dump($handler);
        return $this->{$handler}($params);
    }

    protected function handler($action, $method)
    {
        $method = strtolower($method);
        $action = ucfirst($action);
        $handler = "{$method}{$action}";
        return $handler;
    }
}