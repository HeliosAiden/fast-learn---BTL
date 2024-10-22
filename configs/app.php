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

$config['default_admin'] = [
    'username' => $_ENV['ADMIN_USERNAME'],
    'password' => $_ENV['ADMIN_PASSWORD'],
    'email' => $_ENV['ADMIN_EMAIL'],
];