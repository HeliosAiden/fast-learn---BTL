<?php
require 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


$headers = apache_request_headers(); // Get the headers
$default_login_url = _WEB_ROOT . '/dang-nhap';
$default_home_url = _WEB_ROOT . '/';

global $UNAUTHORIZED_URLS;

function is_url_allowed($currentUri, $allowedUri) {
    return in_array($currentUri, $allowedUri);
}

$current_URI = str_replace(__URL_DIR__ . '/', '', $_SERVER['REQUEST_URI']);

$current_URL = _WEB_ROOT . $current_URI;

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

        // Redirect to home page already logged in
        if (is_url_allowed($current_URL, $UNAUTHORIZED_URLS)) {
            header("Location: $default_home_url");
            exit();
        }

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        setcookie('jwtToken', '', time() - 3600, '/');  // Expire the cookie
        header("Location: $default_login_url");
        exit();
    }
} else {
    if (!is_url_allowed($current_URL, $UNAUTHORIZED_URLS)) {
        // Redirect to login page if the URI is not allowed
        header("Location: $default_login_url");
        exit();
    }
}
