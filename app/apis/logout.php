<?php
require_once str_replace("\\", '/', dirname(__DIR__, 2)) . "/bootstrap.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$default_login_uri = __URL_ORIGIN__ . '/user/login';
// Unset the JWT cookie by setting its expiration date in the past
if (isset($_COOKIE['jwtToken'])) {
    global $jwt_config;
    setcookie('jwtToken', '', time() - 36000, '/');  // Expire the cookie
}

// Redirect to login page after logging out
header("Location: " . $default_login_uri);
exit(); // Make sure to call exit after header to stop further script execution

?>
