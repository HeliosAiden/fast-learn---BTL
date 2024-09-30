<?php
require_once './Api.php';
require_once _DIR_ROOT . '/app/utils/Jwt.php';

$api = new Api('User');

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
        $data = ['username' => $username];

        if (isset($user_data['id'])) {
            $data['user_id'] = $user_data['id'];
        }
        if (isset($user_data['role'])) {
            $data['user_role'] = $user_data['role'];
        }

        $JWTToken = new JWTToken();
        // Encode JWT
        $token = $JWTToken->generate_token($data);
        // Send response
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Obtain token successfully',
            'token' => $token
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid credentials']);
    }
}
