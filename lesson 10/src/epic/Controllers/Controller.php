<?php namespace Epic\Controllers;

abstract class Controller
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function handle($action, $method, $params)
    {
        $handler = $this->handler($action, $method);
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