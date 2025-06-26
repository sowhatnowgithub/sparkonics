<?php

class ApiRouter {
	protected $routes = [];	
	public function routeCreate($uri, $controllerAction, $method) {
		$this->routes[$method][$uri] = $controllerAction;
			
	}
}
