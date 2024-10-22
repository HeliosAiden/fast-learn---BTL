<?php

require_once './Api.php';
$model = 'Course';
$api = new Api($model);

header("Content-Type: application/json");

// Get the request method (POST, PUT, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Route the request based on the HTTP method
switch ($method) {
    case 'GET':
        $api -> check_user_permission($model, 'select');
        $api -> get_controller() -> get_course();
        break;

    case 'POST':
        $api -> check_user_permission($model, 'insert');
        $api -> get_controller() -> create_course();
        break;

    case 'PUT':
        $api -> check_user_permission($model, 'update');
        $api-> get_controller() -> update_course();
        break;

    case 'DELETE':
        $api -> check_user_permission($model, 'delete');
        $api-> get_controller() -> delete_course();
        break;

    default:
        // Return an error for unsupported HTTP methods
        $api-> get_controller() -> errorResponse('unsupported HTTP methods', 405);
        break;
}

?>