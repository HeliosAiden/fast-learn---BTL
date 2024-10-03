<?php

// Include Composer's autoloader
require _DIR_ROOT . '\vendor\autoload.php';

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(_DIR_ROOT);
$dotenv->load();

$config['app'] = [];

$config['hashing'] = [
    'algorithm' => $_ENV['ALGORITHM'],
    'cost' => $_ENV['COST'],
];

$config['jwt'] = [
    'secret_key' => $_ENV['SECRET_KEY'],
    'exp_time' => $_ENV['TOKEN_EXP_TIME']
];

$config['permission'] = [
    'Admin' => ['CourseModel', 'SubjectModel', 'UserModel', 'CourseFeedback', 'CourseQuestionModel', 'UserInfoModel', 'CourseMaterialModel', 'PostModel', 'NotificationModel', 'EnrollmentModel'],
    'Teacher' => ['CourseModel', 'CourseMaterialModel', 'UserInfoModel', 'AnswerModel'],
    'Student' => ['CourseModel', 'CourseFeedback', 'UserInfoModel', 'CourseQuestionModel']
];
