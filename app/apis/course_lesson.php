<?php

require_once './Api.php';
$model = 'CourseLesson';
$api = new Api($model);

header("Content-Type: application/json");

// Get the request method (POST, PUT, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Route the request based on the HTTP method
switch ($method) {
    case 'POST':
        $api -> check_user_permission($model, 'insert');
        $api -> get_controller() -> create_course_lesson();
        break;
}