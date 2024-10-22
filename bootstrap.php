<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

define('_DIR_ROOT', str_replace("\\", '/', __DIR__));

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Get the host (domain)
$host = $_SERVER['HTTP_HOST'];

// Construct the origin
$root = $protocol . $host;

define('__URL_ROOT__', $root);
define('__URL_DIR__', basename(__DIR__));
define('__URL_ORIGIN__', __URL_ROOT__ . '/' . __URL_DIR__);


// Xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://' . $_SERVER['HTTP_HOST'];
}

$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));
$web_root = $web_root . $folder;

define('_WEB_ROOT', $web_root);

/*
*   Tự động load configs
*
*/

$config_dir = scandir(_DIR_ROOT . '/configs');
if (!empty($config_dir)) {
    foreach ($config_dir as $item) {
        if ($item !== '.' && $item !== '..' && file_exists(_DIR_ROOT . '/configs/' . $item)) {
            require_once _DIR_ROOT .  '/configs/' . $item;
        }
    }
}

require_once 'core/Route.php'; // Load Base Router
require_once 'app/App.php'; // Load Apps

// Kiểm tra config & load database
if (!empty($config['database'])) {
    $db_config = array_filter($config['database']);
    if (!empty($db_config)) {
        require _DIR_ROOT . '/core/Connection.php';
        require _DIR_ROOT . '/core/Database.php';
    }
}
if (!empty($config['hashing'])) {
    $hashing_config = array_filter($config['hashing']);
}
if (!empty($config['jwt'])) {
    $jwt_config = array_filter($config['jwt']);
}
if (!empty($config['permission'])) {
    $permission_config = array_filter($config['permission']);
}

require_once 'core/Model.php'; // Load Base Model
require_once 'core/Controller.php'; // Load Base Controller
