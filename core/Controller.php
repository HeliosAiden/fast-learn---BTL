<?php
class Controller {

    protected $__model;
    protected $__permission;

    public function model($model)
    {
        $file_url = _DIR_ROOT . '/app/models/' . $model . '.php';
        if (file_exists($file_url)) {
            require_once $file_url;
            if (class_exists($model)) {
                $model = new $model();
                return $model;
            }
        }

        return false;
    }

    public function render($view, $data = [])
    {
        extract($data);

        $view_url = _DIR_ROOT . '/app/views/' . $view . '.php';
        if (file_exists($view_url)) {
            require_once $view_url;
        }
    }

    public function extract_data($data = [])
    {
        extract($data);
    }

    public function render_layout($view, $data = [])
    {
        extract($data);
        $view_url = _DIR_ROOT . '/app/views/layouts/' . $view . '.php';
        if (file_exists($view_url)) {
            require_once $view_url;
        }
    }

    protected function get_page_data($page_title, $dir, $data = [])
    {
        $page_data = ['page_title' => $page_title, 'dir' => $dir, 'controller' => $this];
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $page_data[$key] = $value;
            }
        }
        return $page_data;
    }

    protected function get_page_dir($page_action)
    {
        $page_controller = get_class($this);
        $page_controller = strtolower($page_controller);
        $page_dir = $page_controller . '/' . $page_action;
        return $page_dir;
    }

    // Method to send JSON response
    protected function jsonResponse($data, $status = 200) {
        header("Content-Type: application/json");
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    // Method to get input data from request (JSON)
    protected function getInput() {
        return json_decode(file_get_contents('php://input'), true);
    }

    // Method to handle errors
    protected function errorResponse($message = 'Bad request', $status = 400) {
        $this->jsonResponse([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }

    public function get_permissions($user_role) {
        global $permission_config;
        if (!empty($permission_config[$user_role])) {
            return $permission_config[$user_role];
        }
        return [];
    }
}
