<?php
require_once 'vendor/autoload.php'; 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function checkPermission($requiredRole) {
    global $jwt_config;
    $secretKey = $jwt_config['secret_key'];

    // Check if the JWT token exists in the cookies
    if (!isset($_COOKIE['jwt_token'])) {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized: No token provided';
        exit;
    }

    // Get the JWT token from the cookie
    $token = $_COOKIE['jwt_token'];

    try {
        // Decode the JWT token
        $decoded_token = JWT::decode($token, new Key($secretKey, 'HS256'));

        // Retrieve the user role from the decoded token
        $userRole = $decoded_token->data->user_role ?? null;

        // Check if the user's role matches the required role
        if ($userRole && $userRole === $requiredRole) {
            // Grant access
            return true;
        } else {
            // Deny access
            header('HTTP/1.1 403 Forbidden');
            echo 'Forbidden: You do not have permission to access this resource';
            exit;
        }
    } catch (Exception $e) {
        // Handle invalid or expired JWT token
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized: ' . $e->getMessage();
        exit;
    }
}
