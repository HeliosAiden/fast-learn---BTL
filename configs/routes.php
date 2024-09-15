<?php

    $routes['default_controller'] = 'home';
    $routes ['san-pham'] = 'product/index';
    $routes ['trang-chu'] = 'home';
    // $routes ['tin-tuc/(.+)'] = 'news/category/$1'; // tin-tuc/1
    $routes ['tin-tuc/.+-(\d+).html'] = 'news/category/$1'; // tin-tuc/1

?>