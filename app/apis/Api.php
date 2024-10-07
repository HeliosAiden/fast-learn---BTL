<?php
require_once str_replace("\\", '/', dirname(__DIR__, 2)) . "/bootstrap.php";
require_once _DIR_ROOT . '/app/middlewares/Jwt.php';

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

    public function check_user_permission($model, $action) {
        global $permission_config;
        $role = $this -> get_user_role();
        if (empty($permission_config[$role])) {
            $this -> __controller -> errorResponse('No role found for the user', 403);
            exit;
        }
        if (empty($permission_config[$role][$model])){
            $this -> __controller -> errorResponse('You do not have permission to access this resource', 403);
            exit;
        }
        if (!str_contains($permission_config[$role][$model][0], $action)) {
            $this -> __controller -> errorResponse('You do not have permission to perform this action', 403);
            exit;
        }
        return true;
    }

    public function get_user_role() {
        if (isset($_COOKIE['jwtToken'])) {
            // Extract token from the Authorization header
            $token = $_COOKIE['jwtToken'];

            $JWT_Token = new JWTToken();

            try {
                $decoded_token = $JWT_Token->decode_token($token);
                return $decoded_token->data->user_role ?? null;

            } catch (Exception $e) {
                // Handle invalid or expired JWT token
                header('HTTP/1.1 401 Unauthorized');
                echo 'Unauthorized: ' . 'Token is invalid or expired';
                exit;
            }
        }
        return null;
    }
}
