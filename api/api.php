<?php
require_once "../vendor/autoload.php";
use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use Sowhatnow\Api\Routes\ApiRouter;
use Sowhatnow\Env;
// Routes declaration

$router = new ApiRouter();
// Routes for events
require Env::BASE_PATH . "/api/Routes/Routes.php";
$host = Env::API_HOST;
$port = Env::API_PORT;

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
    $postData = [];
    $returnData = [];
    if (!isset($request->files)) {
        $postData = $request->post;
    } else {
        if (isset($request->post)) {
            $postData = [
                "files" => $request->files["ImageFile"],
                "post" => $request->post,
            ];
        } else {
            $postData = $request->files["ImageFile"];
        }
    }
    if ($request->server["request_method"] === "GET") {
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
    } elseif ($request->server["request_method"] == "POST") {
        $returnData = $router->routeAction(
            $request->server["request_uri"],
            $request->server["request_method"],
            $postData
        );
    }

    if (isset($returnData["ImagePath"])) {
        $response->sendFile($returnData["ImagePath"]);
    } elseif (isset($returnData)) {
        $response->header("Content-Type", "application/json");
        $response->header("Access-Control-Allow-Origin", "*");
        $response->header("X-RateLimit-Limit", "1000");
        $response->header("Allow", "GET, POST, PUT, DELETE");
        $response->header("X-Frame-Options", "SAMEORIGIN");
        $response->header("X-RateLimit-Remaining", "999");
        $response->end(json_encode($returnData));
    }
});

$server->on("Shutdown", function (Server $server) {
    echo "Server is being shutdown\n";
});

$server->on("Task", function (Server $server, $task) {
    var_dump($task);
});

$server->start();
