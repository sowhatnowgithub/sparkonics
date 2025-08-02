<?php
require_once "/home/fac/sparkonics/public_html/vendor/autoload.php";

use Sowhatnow\Api\Routes\ApiRouter;
use Sowhatnow\Env;

$router = new ApiRouter();

// Include route declarations


require Env::BASE_PATH . "/api/Routes/Routes.php";

// Handle CORS Preflight



if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Authorization, Content-Type, Accept");
    http_response_code(204);
    exit;
}

// Simulate OpenSwoole Request Object
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$queryString = $_SERVER['QUERY_STRING'] ?? null;

// Remove /api prefix if present


$uri = preg_replace('#^/api#', '', $uri);

$postData = [];
if (!empty($_FILES)) {
    $postData = ['files' => $_FILES['ImageFile'] ?? null, 'post' => $_POST];
} elseif (!empty($_POST)) {
    $postData = $_POST;
}

// Authentication


require Env::BASE_PATH . "/api/Authenticate.php";

if (!$invalidKey) {
    if ($method === "GET") {
        $result = $queryString
            ? $router->routeAction($uri, $method, $queryString)
            : $router->routeAction($uri, $method);
    } elseif ($method === "POST") {
        $result = $router->routeAction($uri, $method, $postData);
    } else {
        $result = ["error" => "Unsupported method"];
    }

    // Send response
if (isset($result["ImagePath"])) {
    $imagePath = $result["ImagePath"];

    if (file_exists($imagePath) && is_readable($imagePath)) {
        if (ob_get_level()) {
            ob_end_clean(); // Clean output buffer
        }

        // Avoid any previously sent headers
        header_remove();
        clearstatcache();

        $mimeType = mime_content_type($imagePath) ?: 'application/octet-stream';
        $size = filesize($imagePath);

        header("Content-Type: $mimeType");
        header("Content-Length: $size");
        header("Content-Disposition: inline; filename=\"" . basename($imagePath) . "\"");
        header("Cache-Control: public, max-age=31536000");
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + 31536000) . " GMT");

	readfile($imagePath);

        exit;
    } else {
        http_response_code(404);
        header("Content-Type: application/json");
        echo json_encode(["error" => "Image not found or not readable"]);
        exit;
    }
}

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("X-RateLimit-Limit: 1000");
    header("X-RateLimit-Remaining: 999");
    header("Allow: GET, POST, PUT, DELETE");
    header("X-Frame-Options: SAMEORIGIN");
    echo json_encode($result);
} else {
    header("Content-Type: application/json");
    echo json_encode($errorMessage);
}


