<?php
require_once './Api.php';
require _DIR_ROOT . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

$api = new Api('User');

global $jwt_config;

$secretKey = $jwt_config['secret_key'];
$issuedAt = time();
$expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour


// Get user credentials from request (POST method)
$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->password) && isset($data->role)) {


    $username = $data->username;
    $password = $data->password;
    $role = $data->role;

    $response = $api->get_controller()->perform_login($username, $password, $role);

    // Validate user credentials (query from DB)
    if ($response[1]) {
        $user_data = $response[0];
        // Generate JWT token
        $payload = [
            'iss' => __URL_ORIGIN__,  // issuer
            'iat' => $issuedAt,          // issued at time
            'exp' => $expirationTime,    // expiration time
            'data' => [
                'username' => $username
            ]
        ];
        if (isset($user_data['id']) ) {
            $payload['data']['user_id'] = $user_data['id'];
        }
        if (isset($user_data['role']) ) {
            $payload['data']['user_role'] = $user_data['role'];
        }
        

        // Encode JWT
        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        // Send response
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Obtain token successfully',
            'token' => $jwt
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid credentials']);
    }
}
