<?php

use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

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
	'compression_min_length' => 128,
];
$server->set($settings);


$server->on('Start', function (Server $server) use($host, $port){ 
	echo "Sever started at $host at $port\n";
});

$server->on('Request', function ( Request $request, Response $response) {
    $response->header("Content-Type", "application/json");
	$response->header("Access-Control-Allow-Origin", "*");
    $response->header("X-RateLimit-Limit", "1000");
	$response->header("Allow", "GET, POST, PUT, DELETE");
	$response->header("X-Frame-Options", "SAMEORIGIN");
    $response->header("X-RateLimit-Remaining", "999");
	$data  = json_encode(["id" => 1,
	                "name"=> "Summer Kickoff",
	                "banner"=> "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee",
	                "description"=> "A festival to start the summer.",
	                "startTime"=> "2025-06-20T14:00",
	                "endTime"=> "2025-06-20T18:00"]);
	$response->end($data);
});

$server->on("Shutdown",function (Server $server) {
	echo "Server is being shutdown\n";
});

$server->on('Task', function (Server $server, $task){
	var_dump($task);
});

$server->start();
