<?php

// Include Composer's autoloader
require _DIR_ROOT . '\vendor\autoload.php';

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(_DIR_ROOT);
$dotenv->load();

$config['database'] = [
    'host' => $_ENV['DB_HOST'],
    'db' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD']
];


?>