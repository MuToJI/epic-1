<?php namespace Epic;

use Epic\Controllers;

class Router
{
    /**
     * @var array Controller
     */
    private $routes;

    public function __construct($routes = [])
    {
    }

    public function add($route, $controller, $before = [], $after = [])
    {
        if (!empty($this->routes[$route])) {
            return false;
        }
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

        $action = empty($params['action']) ? 'home' : $params['action'];

        if (empty($this->routes[$action])) {
            throw new \Exception("No handlers for {$action}");
        }

        $controller = $this->routes[$action]['controller'];
        foreach ($this->routes[$action]['before'] as $before) {
            $before($params);
        }
        /**
         * @var Controllers\Controller $controller
         */
        $controller = new $controller();
        return $controller->handle($action, empty($_SERVER['REQUEST_METHOD']) ? 'get' : $_SERVER['REQUEST_METHOD'], $params);
    }
}