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

    public function add($route, $controller, $before = [], $after = [])
    {
        if (!empty($this->routes[$route])) {
            return false;
        }
        $controller = self::$NAMESPACE . "\\{$controller}";
        $this->routes[$route]['controller'] = new $controller();
        $this->routes[$route]['before'] = $before;
        $this->routes[$route]['after'] = $after;
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
        foreach ($this->routes[$route]['before'] as $callback) {
            !is_callable($callback) ?: $callback($params);
        }
        echo $this->routes[$route]['controller']->handle($route, $_SERVER['REQUEST_METHOD'], $params);
        foreach ($this->routes[$route]['after'] as $callback) {
            !is_callable($callback) ?: $callback($params);
        }
    }
}