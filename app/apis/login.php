<?php
require 'vendor/autoload.php';

use \Firebase\JWT\JWT;

require_once './Api.php';
$api = new Api('User');

global $jwt_config;

$secretKey = $jwt_config['secret_key'];
$issuedAt = time();
$expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour


// Get user credentials from request (POST method)
$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->password)) {


    $username = $data->username;
    $password = $data->password;

    $response = $api->get_controller()->login($username, $password);

    // Validate user credentials (query from DB)
    if ($response) {
        // Generate JWT token
        $payload = [
            'iss' => __URL_ORIGIN__,  // issuer
            'iat' => $issuedAt,          // issued at time
            'exp' => $expirationTime,    // expiration time
            'data' => [
                'username' => $username
            ]
        ];
        if (isset($response['id']) ) {
            $payload['data']['user_id'] = $response['id'];
        }

        // Encode JWT
        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        // Send response
        echo json_encode([
            'status' => 'success',
            'token' => $jwt
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid credentials']);
    }
}
