<?php
require_once "../vendor/autoload.php";
use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use Sowhatnow\Api\Routes\ApiRouter;

// Routes declaration

$router = new ApiRouter();
$router->routeCreate(
    "/api/events", // uri
    ["EventsPageController", "FetchAllEvents"], // action controller
    "GET", // request method
    false // args exist or not
);
$router->routeCreate(
    "/api/events/add",
    ["EventsPageController", "AddEvent"],
    "GET",
    true
);
$router->routeCreate(
    "/api/events/modify",
    ["EventsPageController", "ModifyEvent"],
    "GET",
    true
);
$router->routeCreateRegex(
    '~^/api/events/delete/([a-zA-Z0-9_-]+)$~',
    "deleteEvent",
    ["EventsPageController", "DeleteEvent"],
    "GET",
    true
);
$router->routeCreateRegex(
    '~^/api/events/([a-zA-Z0-9_-]+)$~',
    "fetchEvent",
    ["EventsPageController", "FetchEvent"],
    "GET",
    true
);

$host = "0.0.0.0";
$port = 1978;

$server = new Server($host, $port);

$settings = [
    //'daemonize' => 1,
    //	'chroot' => '',
    //	'open_cpu_affinity' => []
    "worker_num" => 4,
    "task_worker_num" => 4,
    "task_enable_coroutine" => true,
    "enable_coroutine" => true,
    "http_compression" => true,
    "http_compression_level" => 2,
    "compression_min_length" => 128,
];
$server->set($settings);

$server->on("Start", function (Server $server) use ($host, $port) {
    echo "Sever started at $host at $port\n";
});

$server->on("Request", function (Request $request, Response $response) use (
    $router
) {
    $response->header("Content-Type", "application/json");
    $response->header("Access-Control-Allow-Origin", "*");
    $response->header("X-RateLimit-Limit", "1000");
    $response->header("Allow", "GET, POST, PUT, DELETE");
    $response->header("X-Frame-Options", "SAMEORIGIN");
    $response->header("X-RateLimit-Remaining", "999");
    $returnData = [];
    if (isset($request->server["query_string"])) {
        $returnData = $router->routeAction(
            $request->server["request_uri"],
            $request->server["request_method"],
            $request->server["query_string"]
        );
    } else {
        $returnData = $router->routeAction(
            $request->server["request_uri"],
            $request->server["request_method"]
        );
    }
    $response->end(json_encode($returnData));
});

$server->on("Shutdown", function (Server $server) {
    echo "Server is being shutdown\n";
});

$server->on("Task", function (Server $server, $task) {
    var_dump($task);
});

$server->start();
