<?php

require_once './Api.php';
$model = 'CourseFeedback';
$api = new Api($model);

header("Content-Type: application/json");

// Get the request method (POST, PUT, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $api -> check_user_permission($model, 'insert');
        $api -> get_controller() -> create_course_feedback();
        break;
}