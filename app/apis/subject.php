<?php

require_once './Api.php';

$api = new Api('Subject');

header("Content-Type: application/json");

// Get the request method (POST, PUT, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Route the request based on the HTTP method
switch ($method) {
    case 'GET':
        $api -> get_controller() -> get_subject();
        break;

    case 'POST':
        $api -> get_controller() -> create_subject();
        break;

    case 'PUT':
        $api-> get_controller() -> update_subject();
        break;

    case 'DELETE':
        $api-> get_controller() -> delete_subject();
        break;

    default:
        // Return an error for unsupported HTTP methods
        $api-> get_controller() -> errorResponse('unsupported HTTP methods', 405);
        break;
}

?>