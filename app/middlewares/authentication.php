<?php
require_once _DIR_ROOT . '/app/middlewares/Jwt.php';

$headers = apache_request_headers(); // Get the headers
$default_login_url = _WEB_ROOT . '/dang-nhap';
$default_home_url = _WEB_ROOT . '/';

global $UNAUTHORIZED_URLS;

function is_url_allowed($currentUri, $allowedUri) {
    return in_array($currentUri, $allowedUri);
}

// echo '<pre>';
// print_r($headers);
// echo '</pre>';

$current_URI = str_replace(__URL_DIR__ . '/', '', $_SERVER['REQUEST_URI']);

$current_URL = _WEB_ROOT . $current_URI;

if (isset($_COOKIE['jwtToken'])) {
    // Extract token from the Authorization header
    $token = $_COOKIE['jwtToken'];

    $JWT_Token = new JWTToken();

    try {
        // Decode the token
        $decoded_token = $JWT_Token -> decode_token($token);
        // Token is valid, you can access user data if needed
        $userData = $decoded_token->data;
        $exp = $decoded_token->exp;

        // Redirect to home page if already logged in
        if (is_url_allowed($current_URL, $UNAUTHORIZED_URLS)) {
            header("Location: $default_home_url");
            exit();
        }
        // Redirect to home page if token expored
        if ($exp < time()) {
            header("Location: $default_home_url");
            exit();
        }

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        setcookie('jwtToken', '', time() - $JWT_Token-> get_expiration_duration(), '/');  // Expire the cookie
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
