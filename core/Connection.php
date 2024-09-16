<?php

class DB_Connection
{
    private static $instance = null;

    private function __construct()
    {
        // Kết nối db  
        echo 'Kết nối cơ sở dữ liệu';
    }

    public static function get_instance()
    {
        if (self::$instance == null) {
            self::$instance == new DB_Connection();
        }

        return self::$instance;
    }
}
