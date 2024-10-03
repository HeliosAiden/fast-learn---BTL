<?php
require_once _DIR_ROOT . '/app/middlewares/Jwt.php';

$headers = apache_request_headers(); // Get the headers
$default_login_url = _WEB_ROOT . '/dang-nhap';
$default_home_url = _WEB_ROOT . '/';

if (isset($_COOKIE['jwtToken'])) {
    // Extract token from the Authorization header
    $token = $_COOKIE['jwtToken'];

    $JWT_Token = new JWTToken();

    try {
        // Decode the token
        $decoded_token = $JWT_Token->decode_token($token);
        // Token is valid, you can access user data if needed

        $user_role = $decoded_token->data->user_role ?? null;
        if ($user_role && $api -> get_user_permission($user_role)) {
            // Do switch case to check permission here
        } else {
            // Deny access
            header('HTTP/1.1 403 Forbidden');
            echo 'Forbidden: You do not have permission to access this resource';
            echo json_encode(['message' => 'Invalid token']);
            exit;
        }
    } catch (Exception $e) {
        // Handle invalid or expired JWT token
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized: ' . 'Token is invalid or expired';
        exit;
    }
}
