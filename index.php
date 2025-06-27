<?php

// index.php

require_once "vendor/autoload.php";

use Sowhatnow\Routes\Router;
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];
$router = new Router();

$router->get("/", ["UserController", "test"]);
$router->get("/admin", ["AdminController", "index"]);
$router->dispatch($uri, $method);
