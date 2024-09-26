<?php
require_once './Api.php';

$api = new Api('User');

header("Content-Type: application/json");

// Get the request method (POST, PUT, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Route the request based on the HTTP method
switch ($method) {
    case 'GET':
        $api -> get_controller() -> get_user();
        break;

    case 'POST':
        $api -> get_controller() -> create_user();
        break;

    case 'PUT':
        $api-> get_controller() -> updateUser();
        break;

    case 'DELETE':
        $api-> get_controller() -> deleteUser();
        break;

    default:
        // Return an error for unsupported HTTP methods
        $api-> get_controller() -> errorResponse('Failed creating user', 405);
        break;
}