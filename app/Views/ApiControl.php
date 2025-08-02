<?php

$ch = curl_init();
$baseUrl = $formData["baseUrl"];
$data = [];

$isFileUpload = false;
// Handle form data and check for file input
if (
    isset($_FILES["ImageFile"]) &&
    $_FILES["ImageFile"]["error"] === UPLOAD_ERR_OK
) {
    $isFileUpload = true;
    $fileTmpPath = $_FILES["ImageFile"]["tmp_name"];
    $fileName = $_FILES["ImageFile"]["name"];
    $fileType = $_FILES["ImageFile"]["type"];

    // Attach file using CURLFile

    $data["ImageFile"] = new CURLFile($fileTmpPath, $fileType, $fileName);
}
foreach ($formData as $Name => $dat) {
    if ($Name != "baseUrl" && $Name != "action" && $Name != "method") {
        $data[$Name] = $dat;
    }
}

if ($formData["action"] === "Add" || $formData["action"] === "Modify") {
    if ($formData["method"] === "POST") {
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_POST, true);

        if ($isFileUpload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // leave as array
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
    } elseif ($formData["request_method"] === "GET") {
        $query = http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, $baseUrl . "?" . $query);
    }
} elseif ($formData["action"] === "FetchAll") {
    curl_setopt($ch, CURLOPT_URL, $baseUrl);
} elseif ($formData["action"] === "Fetch") {
    $id = 1;
    foreach ($data as $dat) {
        $id = $dat;
    }

    curl_setopt($ch, CURLOPT_URL, $baseUrl . $id);
} elseif ($formData["action"] === "Delete") {
    $id = 1;
    foreach ($data as $dat) {
        $id = $dat;
    }

    curl_setopt($ch, CURLOPT_URL, $baseUrl . $id);
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Adjust headers
$headers = [];
if (!$isFileUpload) {
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
}
require "Authenticate.php";
$headers[] = $authorisationDetails;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Curl error: " . curl_error($ch);
} else {
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    if (strpos($contentType, "application/json") !== false) {
        $data = json_decode($response, true);
        print_r($data);
    } elseif (strpos($contentType, "image/") !== false) {
        header("Content-Type: $contentType");
        echo $response;
        exit();
    } else {
	    echo $response;
	    exit;
    }
}

curl_close($ch);
