<?php
require_once './Api.php';
require_once _DIR_ROOT . '/core/Jwt.php';

$api = new Api('User');
$user_info_api = new API('UserInfo');

// Get user credentials from request (POST method)
$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->password) && isset($data->role)) {

    $username = $data->username;
    $password = $data->password;
    $role = $data->role;

    $user_data = $api->get_controller()->perform_login($username, $password, $role);

    // Validate user credentials (query from DB)
    if (!empty($user_data)) {
        $data = ['username' => $username];

        if (isset($user_data['id'])) {
            $data['user_id'] = $user_data['id'];
        }
        if (isset($user_data['role'])) {
            $data['user_role'] = $user_data['role'];
        }
        if (isset($user_data['state'])) {
            if ($user_data['state'] == 'Active') {
                $data['user_state'] = $user_data['state'];
            } else {
                $api-> get_controller() -> errorResponse('User is not active.', 403);
            }
        }
        if (isset($user_data['email'])) {
            $data['user_email'] = $user_data['email'];
        }
        $user_info = $user_info_api -> get_controller() -> retrieve_user_info($user_data['id']);
        if (isset($user_info)) {
            $data['user_info'] = $user_info;
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
