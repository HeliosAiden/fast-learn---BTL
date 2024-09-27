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
