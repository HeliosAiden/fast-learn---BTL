<?php
require_once './Api.php';
require_once _DIR_ROOT . '/app/utils/Jwt.php';

if (isset($_COOKIE['jwtToken'])) {
    $token = $_COOKIE['jwtToken'];

    $JWT_Token = new JWTToken();

    try {
        // Decode the token
        $new_token = $JWT_Token -> refresh_token($token);
        setcookie('jwtToken', $new_token, $JWT_Token -> get_expiration_time(), '/');  // Expire the cookie

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        setcookie('jwtToken', '', time() - 3600, '/');  // Expire the cookie
        header("Location: $default_login_url");
        exit();
    }
}