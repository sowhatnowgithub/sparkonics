<?php

// index.php

require_once "vendor/autoload.php";

use Sowhatnow\Routes\Router;
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];
$router = new Router();

$router->get("/admin", ["AdminController", "index"]);
$router->post("/admin/auth", ["AdminController", "Authenticate"]);
$router->post("/admin/apicontrol", ["AdminController", "ApiHandler"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $router->routeAction(
        $_SERVER["REQUEST_URI"],
        $_SERVER["REQUEST_METHOD"],
        $_POST
    );
} else {
    $router->routeAction($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
}
