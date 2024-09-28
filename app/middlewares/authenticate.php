<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


$headers = apache_request_headers(); // Get the headers

$default_login_uri = '/' . __URL_DIR__ . '/user/login';
$default_home_uri = '/' . __URL_DIR__ . '/';

// Debug through headers
// echo '<pre>';
// print_r($headers);
// echo '</pre>';

if (isset($_COOKIE['jwtToken'])) {
    // Extract token from the Authorization header
    global $jwt_config;
    $secretKey = $jwt_config['secret_key'];
    $token = $_COOKIE['jwtToken'];

    try {
        // Decode the token
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        // Token is valid, you can access user data if needed
        $userData = $decoded->data;

        if ($_SERVER['REQUEST_URI'] == $default_login_uri) {
            header("Location: $default_home_uri");
        }

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        exit();
    }
} else if ($_SERVER['REQUEST_URI'] !== $default_login_uri) {
    header("Location: $default_login_uri");
    exit();
}
