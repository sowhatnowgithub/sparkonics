<?php

// index.php

require_once "vendor/autoload.php";
use Sowhatnow\App\Controllers\HomeController;
use Sowhatnow\Routes\Router;
use Sowhatnow\Env;

require_once "enum.php";

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];
$router = new Router();

$router->get("/admin", ["AdminController", "index"]);
$router->post("/admin/auth", ["AdminController", "Authenticate"]);
$router->post("/admin/apicontrol", ["AdminController", "ApiHandler"]);
$router->post("/admin/getform", ["AdminController", "GetForm"]);

$userType = userTypes::Public;
foreach ($router->routes["GET"] as $routes => $actions) {
    if (strpos($routes, $uri) !== false) {
        $userType = userTypes::Admin;
        break;
    }
}
foreach ($router->routes["POST"] as $routes => $actions) {
    if (strpos($routes, $uri) !== false) {
        $userType = userTypes::Admin;
        break;
    }
}
if ($userType === userTypes::Public) {
    if (php_sapi_name() === "cli-server") {
        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $fullPath = Env::BASE_PATH . "/public" . $path;
        if (is_file($fullPath)) {
            $mimeType = mime_content_type($fullPath);
            if (strpos($fullPath, ".css") !== false) {
                header("Content-Type: text/css");
            } else {
                header("Content-Type: $mimeType");
            }
            header("Content-Length: " . filesize($fullPath));
            readfile($fullPath);
            return false;
        } else {
            $indexHtml = Env::BASE_PATH . "/public/index.html";
            if (file_exists($indexHtml)) {
                header("Content-Type: text/html");
                readfile($indexHtml);
                exit();
            }
        }
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $router->routeAction(
            $_SERVER["REQUEST_URI"],
            $_SERVER["REQUEST_METHOD"],
            $_POST
        );
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        $router->routeAction(
            $_SERVER["REQUEST_URI"],
            $_SERVER["REQUEST_METHOD"]
        );
    }
}
