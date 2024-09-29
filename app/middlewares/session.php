<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'vendor/autoload.php';

class Session
{
    private $secret_key = ''; // Secret key for signing the JWT token
    function __construct()
    {
        global $jwt_config;
        $this->secret_key = $jwt_config['secret_key'];
    }

    // Validate the JWT token and check for expiration
    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret_key, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            // Invalid or expired token
            return null;
        }
    }

    // Middleware to check user session and handle inactivity
    public function checkSession()
    {
        // Check if the JWT token is stored in the cookie
        if (!isset($_COOKIE['jwt_token'])) {
            http_response_code(401);
            echo "Unauthorized: No token provided.";
            exit();
        }

        // Get the token from the cookie
        $token = $_COOKIE['jwt_token'];
        $decodedToken = $this->validateToken($token);

        if ($decodedToken) {
            // Check for inactivity timeout
            if (isset($_COOKIE['last_activity']) && (time() - $_COOKIE['last_activity'] > 300)) {
                // Inactivity timeout (5 minutes)
                $this->logout(); // Log the user out by clearing the cookies
                http_response_code(403);
                echo "Session expired due to inactivity.";
                exit();
            }

            // Reset the inactivity timer by updating the 'last_activity' cookie
            setcookie('last_activity', time(), time() + 300, "/");

        } else {
            // Invalid or expired token
            http_response_code(403);
            echo "Session expired or invalid token.";
            exit();
        }
    }

    // Logout the user and clear the cookies
    public function logout()
    {
        setcookie('jwt_token', '', time() - 3600, "/"); // Clear the token cookie
        setcookie('last_activity', '', time() - 3600, "/"); // Clear the last activity cookie
    }
}
