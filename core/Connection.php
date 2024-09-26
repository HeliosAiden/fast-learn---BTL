<?php

class DB_Connection
{
    private static $instance = null;
    private $__connection = null;

    private function __construct($config)
    {
        // Kết nối db
        try {
            $dsn = 'mysql:dbname=' . $config['db'] . ';host=' . $config['host'];

            // cấu hình $options
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ];

            $this -> __connection = new PDO($dsn, $config['user'], $config['password'], $options);
        } catch (PDOException $exception) {
            if ($exception !== null) {
                die('Database connection error: ' . $exception->getMessage());
            }
        }
    }

    public static function get_instance($config)
    {
        if (self::$instance == null) {
            self::$instance = new DB_Connection($config);
        }
        return self::$instance->__connection;
    }
}
