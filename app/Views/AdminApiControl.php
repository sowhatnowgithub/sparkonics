<?php

$ch = curl_init();
$baseUrl = $formData["baseUrl"];
$data = [];
foreach ($formData as $Name => $dat) {
    if ($Name != "baseUrl" && $Name != "action" && $Name != "method") {
        $data[$Name] = $dat;
    }
}
if ($formData["action"] === "Add" || $formData["action"] === "Modify") {
    if ($formData["request_method"] === "POST") {
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    } elseif ($formData["request_method"] === "GET") {
        $query = http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, $baseUrl . "?" . $query);
    }
} elseif ($formData["action"] === "FetchAll") {
    curl_setopt($ch, CURLOPT_URL, $baseUrl);
} elseif ($formData["action"] === "Fetch" || $formData["action"] === "Delete") {
    $id = 1;
    foreach ($data as $dat) {
        $id = $dat;
    }

    curl_setopt($ch, CURLOPT_URL, $baseUrl . $id);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded",
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Curl error: " . curl_error($ch);
} else {
    $data = json_decode($response, true); // The `true` parameter returns an assoc array
    print_r($data);
}

curl_close($ch);
