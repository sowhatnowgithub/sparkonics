<?php

namespace Sowhatnow\Routes;

class Router
{
    public $controller, $action;
    public $routes = [];
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
    public function routeAction($uri, $method, $setting = false)
    {
        try {
            list($this->controller, $this->action) = @$this->routes[$method][
                $uri
            ];
            $controllerClass = "Sowhatnow\\App\\Controllers\\{$this->controller}";
            try {
                if (class_exists($controllerClass)) {
                    if (method_exists($controllerClass, $this->action)) {
                        $model = new $controllerClass();
                        if ($setting != false) {
                            $model->{$this->action}($setting);
                        } else {
                            $model->{$this->action}();
                        }
                    } else {
                        echo "Failed at Method Class\n";
                        exit();
                    }
                } else {
                    echo "Failed at Controller Class\n";
                    exit();
                }
            } catch (\Exception $e) {
                echo "Failed at Rotuer\n";
                exit();
            }
        } catch (\Exception $e) {
            http_response_code(404);
            exit();
        }
    }
}
