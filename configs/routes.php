<?php
    // Set the static path
    $routes['default_controller'] = 'home'; // Cần khởi tạo giá trị cho lần chạy App đầu tiên
    $routes['trang-chu'] = 'home';
    $routes['dang-nhap'] = 'user/login';
    $routes['dang-ky'] = 'user/register';

    // $routes['tin-tuc/(.+)'] = 'news/category/$1'; // tin-tuc/1
    // $routes['tin-tuc/.+-(\d+).html'] = 'news/category/$1'; // tin-tuc/1

    $UNAUTHORIZED_URLS = [
        _WEB_ROOT . '/user/login',
        _WEB_ROOT . '/user/register',
        _WEB_ROOT . '/user/forgot-password',
        // Add more URls as needed
    ];

    foreach($routes as $key => $value) {
        array_push($UNAUTHORIZED_URLS, _WEB_ROOT . '/' . $key);
    }

    foreach($UNAUTHORIZED_URLS as $value) {
        array_push($UNAUTHORIZED_URLS, $value . '/');
    }

?>