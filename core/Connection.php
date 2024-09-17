<?php

class DB_Connection
{
    private static $instance = null, $connection = null;

    public function __construct($config)
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

            $connection = new PDO($dsn, $config['user'], $config['password'], $options);
            self::$connection = $connection;
        } catch (PDOException $exception) {
            if ($exception !== null) {
                die('Connection failed: ' . $exception->getMessage());
            }
        }
    }

    public static function get_instance($config)
    {
        if (self::$instance == null) {
            new DB_Connection($config);
            self::$instance = self::$connection;
        }
        return self::$instance;
    }
}
