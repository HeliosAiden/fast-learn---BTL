<?php
require str_replace("\\", '/', dirname(__DIR__, 2)) . "/bootstrap.php";
require 'vendor/autoload.php';  // Autoload composer packages
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

global $jwt_config;

$secretKey = $jwt_config['secret_key'];

// Get Authorization header
$headers = apache_request_headers();

if (isset($headers['Authorization'])) {
    $token = str_replace('Bearer ', '', $headers['Authorization']);

    try {
        // Decode JWT token
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

        // Token is valid, proceed with the request
        // You can pass the decoded user data (like user ID) to other scripts
        $userData = $decoded->data;  // Access user data from the token
    } catch (Exception $e) {
        // Token is invalid
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        exit();
    }
} else {
    // No token provided
    http_response_code(401);
    echo json_encode(['message' => 'No token provided']);
    exit();
}
