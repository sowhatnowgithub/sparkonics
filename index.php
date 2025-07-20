<?php

// index.php

require_once "vendor/autoload.php";
use Sowhatnow\Routes\Router;
use Sowhatnow\Env;

require_once "enum.php";

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];
$router = new Router();
$router->get("/admin/home", ["AdminController", "Home"]);
$router->get("/admin/", ["AdminController", "index"]);
$router->get("/admin/members", ["MembersController", "MembersControl"]);
$router->get("/admin/dashboard", ["AdminController", "Dashboard"]);
$router->get("/admin/log", ["AdminController", "LogUser"]);
$router->get("/admin/backupdb", ["AdminController", "BackUp"]);
$router->get("/admin/logout", ["AdminController", "Logout"]);
$router->get("/admin/websitecontrol", ["AdminController", "WebsiteControl"]);
$router->get("/admin/scheduler", ["SchedulerController", "SchedulerPage"]);
$router->post("/admin/register", ["MembersController", "RegisterMember"]);
$router->post("/admin/auth", ["AdminController", "Authenticate"]);
$router->post("/admin/apicontrol", ["AdminController", "ApiHandler"]);
$router->post("/admin/getform", ["AdminController", "GetForm"]);
$router->post("/admin/member/delete", ["MembersController", "MemberDelete"]);
$router->post("/admin/member/access", [
    "MembersController",
    "GrantAccessMemeber",
]);
$router->post("/admin/member/updaterole", [
    "MembersController",
    "UpdateMemberRole",
]);
$router->post("/admin/member/updateimage", [
    "MembersController",
    "UpdateImage",
]);
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
