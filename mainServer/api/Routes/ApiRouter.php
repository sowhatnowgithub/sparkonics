<?php
namespace Sowhatnow\Api\Routes;
class ApiRouter
{
    protected $routes = [];
    protected $regexes = [];
    //@param $uri
    // @param $controllerAction
    // @param $method
    // @param $arg_exist
    // @param $regexpattern
    public function routeCreate(
        $uri,
        $controllerAction,
        $method,
        $arg_exist = false
    ): void {
        $this->routes[$method][$uri]["controllerAction"] = $controllerAction;
        $this->routes[$method][$uri]["arg"] = $arg_exist;
    }
    // @param $regex
    // @param $name
    // @param $controllerAction
    // @param $method
    // @param $arg_exist
    public function routeCreateRegex(
        $regex,
        $name,
        $controllerAction,
        $method,
        $arg_exist = false
    ): void {
        $this->regexes[$name]["method"] = $method;
        $this->regexes[$name]["regex"] = $regex;
        $this->regexes[$name]["controllerAction"] = $controllerAction;
        $this->regexes[$name]["arg"] = $arg_exist;
    }
    //@param $uri
    // @param $method
    // @param $queryString
    // @param $args
    // @return array
    public function routeAction($uri, $method, $args = null): array
    {
        $out = [];
        if (isset($this->routes[$method][$uri])) {
            $out = $this->routeActionHelper(
                $args,
                $this->routes[$method][$uri]
            );
            return $out;
        } else {
            foreach ($this->regexes as $regex) {
                if (
                    $method == $regex["method"] &&
                    preg_match($regex["regex"], $uri, $matches)
                ) {
                    $route = [
                        "controllerAction" => $regex["controllerAction"],
                        "arg" => $regex["arg"],
                    ];

                    $out = $this->routeActionHelper($matches[1], $route);
                    break;
                }
            }
            return $out;
        }
        return ["Error" => "Failed to fetch"];
    }
    //@param $args
    // @param $route
    // @return array
    public function routeActionHelper($args, $route): array
    {
        parse_str($args, $args);

        try {
            list($actionName, $actionMethod) = $route["controllerAction"];
            $controllerClass = "Sowhatnow\\Api\\Controllers\\{$actionName}";
            $arg_exist = $route["arg"];
            if (class_exists($controllerClass)) {
                if (method_exists($controllerClass, $actionMethod)) {
                    $eventsModel = new $controllerClass();
                    $out = [];
                    if ($arg_exist) {
                        $out = $eventsModel->$actionMethod($args);
                    } else {
                        $out = $eventsModel->$actionMethod();
                    }
                    if (isset($out)) {
                        return $out;
                    } else {
                        return ["Error" => "Failed to fetch"];
                    }
                } else {
                    echo "Method is not present with in the $controllerClass\n";
                }
            } else {
                echo "ControllerAction is not present\n";
            }
        } catch (\Exception $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
}
