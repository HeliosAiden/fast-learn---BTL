<?php
    // Set the static path
    $routes['default_controller'] = 'home'; // Cần khởi tạo giá trị cho lần chạy App đầu tiên
    $routes['trang-chu'] = 'home';
    $routes['dang-nhap'] = 'user/login';
    $routes['dang-ky'] = 'user/register';
    $routes['mon-hoc'] = 'subject/index';
    $routes['khoa-hoc'] = 'course/index';
    $routes['user-info'] = 'userinfo';
    $routes['reset-password'] = 'user/reset_password';
    $routes['doi-mat-khau'] = 'user/reset_password';
    $routes['hoc-sinh'] = 'user/students';
    $routes['giao-vien'] = 'user/teachers';
    $routes['khoa-hoc/da-dang-ky'] = 'course/registered';
    $routes['khoa-hoc/quan-ly'] = 'course/registered';
    $routes['khoa-hoc/chi-tiet'] = 'course/detail';

    // $routes['tin-tuc/(.+)'] = 'news/category/$1'; // tin-tuc/1
    // $routes['tin-tuc/.+-(\d+).html'] = 'news/category/$1'; // tin-tuc/1

    $UNAUTHORIZED_URLS = [
        _WEB_ROOT . '/user/login',
        _WEB_ROOT . '/user/register',
        _WEB_ROOT . '/user/forgot-password',
        _WEB_ROOT . '/',
        _WEB_ROOT . '/home'
        // Add more URls as needed
    ];
    $routes['unauthorized'] = $UNAUTHORIZED_URLS;

    foreach($UNAUTHORIZED_URLS as $value) {
        if ($value !== _WEB_ROOT . '/') {
            array_push($UNAUTHORIZED_URLS, $value . '/');
        }
    }

?>