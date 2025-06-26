<?php

namespace Sowhatnow\Routes;

class Router
{
    private $routes = [];
    // @param string $uri The URI expects the path
    // @param array $controllerAction
    public function get($uri, $controllerAction): void
    {
        $this->routes["GET"][$uri] = $controllerAction;
    }
    // @param $uri The URI expects the path of the url
    // @param $controllerAction
    public function post($uri, $controllerAction): void
    {
        $this->routes["POST"][$uri] = $controllerAction;
    }
    // @param $uri
    // @param $method Ex: GET, POST
    public function dispatch($uri, $method): void
    {
        if (isset($this->routes[$method][$uri])) {
            list($controllerName, $action) = $this->routes[$method][$uri];
            $controllerClass = "Sowhatnow\\App\\Controllers\\{$controllerName}";
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    http_response_code(404);
                }
            } else {
                http_response_code(404);
            }
        } else {
            http_response_code(404);
        }
    }
}
