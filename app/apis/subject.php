<?php

require_once './Api.php';
$model = 'Subject';
$api = new Api($model);

header("Content-Type: application/json");

// Get the request method (POST, PUT, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Route the request based on the HTTP method
switch ($method) {
    case 'GET':
        $api -> check_user_permission($model, 'select');
        $api -> get_controller() -> get_subject();
        break;

    case 'POST':
        $api -> get_controller() -> create_subject();
        break;

    case 'PUT':
        $api-> get_controller() -> update_subject();
        break;

    case 'DELETE':
        $subject_uuid = $_SERVER['HTTP_X_SUBJECT_ID'] ?? null;
        if (!$subject_uuid) {
            $api-> get_controller() -> errorResponse('Missing subject ID in header', 400);
            exit;
        }
        $api -> check_user_permission($model, 'delete');
        $api-> get_controller() -> delete_subject($subject_uuid);
        break;

    default:
        // Return an error for unsupported HTTP methods
        $api-> get_controller() -> errorResponse('unsupported HTTP methods', 405);
        break;
}

?>