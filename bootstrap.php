<?php
define('_DIR_ROOT', str_replace("\\", '/',__DIR__));

require_once 'configs/routes.php';

// Xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://' . $_SERVER['HTTP_HOST'];
}

$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));
$web_root = $web_root . $folder;

define('_WEB_ROOT', $web_root);

require_once 'app/app.php'; // Load Apps
require_once 'core/Controller.php'; // Load Base Controller
require_once 'core/Route.php'; // Load Base Router


?>