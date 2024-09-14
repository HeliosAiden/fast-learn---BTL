<?php

class App
{

    private $__controller, $__action, $__params, $__routes;

    function __construct()
    {
        global $routes;

        $this -> __routes = new Route();
        if (!empty($routes)) {
            $this->__controller = $routes['default_controller'];
        }
        $this->__action = 'index';
        $this->__params = [];
        $this->handle_url();
    }

    function get_url()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }


    public function handle_url()
    {

        $url = $this->get_url();
        
        $this -> __routes -> handle_route($url);
        $urlArray = array_filter(explode('/', $url));
        $urlArray = array_values($urlArray);

        // handle controller
        if (!empty($urlArray[0])) {
            $this->__controller = ucfirst($urlArray[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        $file_url = 'app/controllers/' . ($this->__controller) . '.php';
        if (file_exists($file_url)) {
            require_once $file_url;
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
            } else {
                $this->load_errors();
            }
            unset($urlArray[0]);
        } else {
            $this->load_errors();
        }

        // handle action
        if (!empty($urlArray[1])) {
            $this->__action = $urlArray[1];
            unset($urlArray[1]);
        }

        // handle param
        $this->__params = array_values($urlArray);
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->load_errors();
        }
    }

    public function load_errors($name = '404')
    {
        require_once 'errors/' . $name . '.php';
    }
}
