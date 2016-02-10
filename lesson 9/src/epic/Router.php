<?php namespace Epic;

use Epic\Controllers;

class Router
{
    /**
     * @var array Controller
     */
    private $routes;
    private static $NAMESPACE = '\Epic\Controllers';

    public function __construct($routes = [])
    {
    }

    public function add($route, $controller)
    {
        if (!empty($this->routes[$route])) {
            return false;
        }
        $controller = self::$NAMESPACE . "\\{$controller}";
        $this->routes[$route] = new $controller();
        return true;
    }

    public function handle()
    {
        $request = parse_url($_SERVER['REQUEST_URI']);
        $params = [];
        if (!empty($request['query'])) {
            parse_str($request['query'], $params);
        }
        $route = empty($params['action']) ? 'home' : $params['action'];
        echo $this->routes[$route]->handle($route, $_SERVER['REQUEST_METHOD'], $params);
    }
}