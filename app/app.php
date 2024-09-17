<?php

class App
{

    private $__controller, $__action, $__params, $__routes;

    function __construct()
    {
        global $routes, $config;

        $this->__routes = new Route();
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

        $url = $this->__routes->handle_route($url);

        $url_array = array_filter(explode('/', $url));
        $url_array = array_values($url_array);

        $url_check = '';
        if (!empty($url_array)) {
            foreach ($url_array as $key => $item) {
                $url_check .= $item . '/';
                $file_check = rtrim($url_check, '/');
                $file_arr = explode('/', $file_check);
                $file_arr[count($file_arr) - 1] = ucfirst($file_arr[count($file_arr) - 1]);
                $file_check = implode('/', $file_arr);
                $file_url = 'app/controllers/' . ($file_check) . '.php';


                if (!empty($url_array[$key - 1])) {
                    unset($url_array[$key - 1]);
                }
                if (file_exists($file_url)) {
                    $url_check = $file_check;
                    break;
                }
            }
            $url_array = array_values($url_array);
        }


        // handle controller
        if (!empty($url_array[0])) {
            $this->__controller = ucfirst($url_array[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        // Xử lý khi url rỗng
        if (empty($url_check)) {
            $url_check = $this -> __controller;
        }

        $file_url = 'app/controllers/' . $url_check . '.php';
        if (file_exists($file_url)) {
            require_once $file_url;
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
            } else {
                $this->load_errors();
            }
            unset($url_array[0]);
        } else {
            $this->load_errors();
        }

        // handle action
        if (!empty($url_array[1])) {
            $this->__action = $url_array[1];
            unset($url_array[1]);
        }

        // handle param
        $this->__params = array_values($url_array);
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
