<?php
$__ALL_PERMISSION = ['select, insert, update, delete'];
$__NO_DELETE = ['select, insert, update'];
$__NO_INSERT = ['select, update, delete'];
$__NO_UPDATE = ['select, insert, delete'];
$__SELECT_ONLY = ['select'];
$__INSERT_ONLY = ['insert'];
$__UPDATE_ONLY = ['update'];
$__SELECT_ONLY = ['select'];

$config['permission'] = [
    'Admin' => [
        'Course' => $__ALL_PERMISSION,
        'Subject' => $__ALL_PERMISSION,
        'User' => $__ALL_PERMISSION,
        'CourseFeedback' => $__ALL_PERMISSION,
        'CourseQuestion' => $__ALL_PERMISSION,
        'UserInfo' => $__ALL_PERMISSION,
        'CourseMaterial' => $__ALL_PERMISSION,
        'Post' => $__ALL_PERMISSION,
        'Notification' => $__ALL_PERMISSION,
        'Enrollment' => $__ALL_PERMISSION
    ],
    'Teacher' => [
        'Course' => $__ALL_PERMISSION,
        'CourseMaterial' => $__ALL_PERMISSION,
        'UserInfo' => $__UPDATE_ONLY,
        'Answer' => $__ALL_PERMISSION,
        'Subject' => $__NO_DELETE,
        'Post' => $__SELECT_ONLY
    ],
    'Student' => [
        'Course' => $__SELECT_ONLY,
        'CourseFeedback' => $__ALL_PERMISSION,
        'UserInfo' => $__UPDATE_ONLY,
        'CourseQuestion' => $__SELECT_ONLY,
        'Subject' => $__SELECT_ONLY,
        'Post' => $__SELECT_ONLY
    ],
    'Guest' => [
        'CourseFeedback' => $__SELECT_ONLY,
        'Course' => $__SELECT_ONLY,
        'Post' => $__SELECT_ONLY,
        'CourseQuestion' => $__SELECT_ONLY,
        'Answer' => $__SELECT_ONLY,
        'Subject' => $__SELECT_ONLY,
        'User' => $__INSERT_ONLY,
    ]
];