<?php

namespace Sowhatnow\App\Controllers;
use Sowhatnow\Env;
class HomeController
{
    public function index()
    {
        $fullPath = Env::BASE_PATH . "/public/Microservices/index.html";
        if (!file_exists($fullPath)) {
            http_response_code(404);
            echo "404 Not Found";
        }
        // Determine MIME type
        $mimeType = mime_content_type($fullPath);
        header("Content-Type: $mimeType");

        // Optionally set caching headers
        //header("Cache-Control: public, max-age=86400");

        // Output the file content
        readfile($fullPath);
    }
    public function staticFile($file)
    {
        $filePath = realpath($this->basePath . $file);

        // Security: Prevent path traversal (e.g., ../etc/passwd)
        if (
            strpos($filePath, realpath($this->basePath)) !== 0 ||
            !is_file($filePath)
        ) {
            http_response_code(404);
            echo "File not found.";
            return;
        }

        $mimeType = mime_content_type($filePath);
        header("Content-Type: $mimeType");
        readfile($filePath);
    }
}
