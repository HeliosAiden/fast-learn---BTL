<?php

require_once './Api.php';
$model = 'UserInfo';
$api = new Api($model);
$user_api = new API('User');

header("Content-Type: application/json");

// Get the request method (POST, PUT, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Route the request based on the HTTP method
switch ($method) {
    case 'GET':
        $api -> check_user_permission($model, 'select');
        $api -> get_controller() -> get_user_info();
        break;

    case 'POST':
        $api -> check_user_permission($model, 'insert');
        $user_info_id = $api -> get_controller() -> create_user_info();
        $response = $user_api -> get_controller() -> update_user_info($user_info_id);
        if (isset($response)) {
            $api -> get_controller() -> jsonResponse([
                'status' => 'success',
                'message' => 'Create & update user info successfully'
            ]);
        } else {
            $api -> get_controller() -> errorResponse('Something went wrong', 500);
        }
        break;

    case 'PUT':
        $api -> check_user_permission($model, 'update');
        $api-> get_controller() -> update_user_info();
        break;

    case 'DELETE':
        $api -> check_user_permission($model, 'delete');
        $api-> get_controller() -> delete_user_info();
        break;

    default:
        // Return an error for unsupported HTTP methods
        $api-> get_controller() -> errorResponse('unsupported HTTP methods', 405);
        break;
}

?>