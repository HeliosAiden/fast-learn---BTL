<?php
require_once str_replace("\\", '/', dirname(__DIR__, 2)) . "/bootstrap.php";

class Api
{
    protected $__controller = null;

    function __construct($file)
    {
        $this -> __controller = $this -> init_controller($file);
    }

    public function init_controller($file)
    {
        $file_url = _DIR_ROOT . '/app/controllers/' . $file . '.php';
        if (file_exists($file_url)) {
            require_once $file_url;
            if (class_exists($file)) {
                $file = new $file();
                return $file;
            }
        }

        return null;
    }

    public function get_controller() {
        return $this -> __controller;
    }

    public function get_user_permission($role) {
        // $this -> __controller ->
    }
}
