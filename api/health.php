<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache');

$response = [
    'status' => 'healthy',
    'timestamp' => time(),
    'service' => 'sparkonics-api'
];

echo json_encode($response);
