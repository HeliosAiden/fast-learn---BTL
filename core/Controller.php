<?php
class Controller
{

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

    public function get_page_data($page_title, $dir, $data = [])
    {
        $page_data = ['page_title' => $page_title, 'dir' => $dir, 'controller' => $this];
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $page_data[$key] = $value;
            }
        }
        return $page_data;
    }

    public function get_page_dir($page_action)
    {
        $page_controller = get_class($this);
        $page_controller = strtolower($page_controller);
        $page_dir = $page_controller . '/' . $page_action;
        return $page_dir;
    }

    // Method to send JSON response
    public function jsonResponse($data, $status = 200)
    {
        if (!headers_sent()) {
            header("Content-Type: application/json");
        }
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    // Method to get input data from request (JSON)
    public function getInput()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    public function createFile()
    {
        if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === UPLOAD_ERR_OK) {
            $file_temporal_path = $_FILES['uploaded_file']['tmp_name'];
            $file_name = $_FILES['uploaded_file']['name'];
            $file_size = $_FILES['uploaded_file']['size'];
            $file_type = $_FILES['uploaded_file']['type'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];

            $file_category = 'others';
            if (in_array($file_extension, $allowedExtensions)) {

                switch ($file_extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        $file_category = 'images';
                        break;
                    case 'mp4':
                    case 'avi':
                    case 'mov':
                        $file_category = 'videos';
                        break;
                    case 'pdf':
                    case 'doc':
                    case 'docx':
                    case 'txt':
                        $file_category = 'docs';
                        break;
                    case 'xls':
                    case 'xlsx':
                        $file_category = 'excels';
                        break;
                    default:
                        $file_category = 'others';
                }
            }

            $file_dir = '/app/uploads/' . $file_category . '/';
            $upload_dir = _DIR_ROOT . $file_dir;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $new_file_name = time() . '_' . basename($file_name);

            $file_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_temporal_path, $file_path)) {
                $file_data = [
                    'file_name' => $new_file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_path' => $file_dir . $new_file_name,
                ];
                return $file_data;
            }
        }
        $this->errorResponse('Can not access to $_FILES');
    }

    public function deleteFile($file_path)
    {
        $file_path = _DIR_ROOT . $file_path;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Method to handle errors
    public function errorResponse($message = 'Bad request', $status = 400)
    {
        $this->jsonResponse([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }

    public function check_user_permission($model, $action)
    {
        global $permission_config;
        $role = $this->get_user_role();
        if (empty($permission_config[$role])) {
            $this->errorResponse('No role found for the user', 403);
            exit;
        }
        if (empty($permission_config[$role][$model])) {
            $this->errorResponse('You do not have permission to access this resource', 403);
            exit;
        }
        if (!str_contains($permission_config[$role][$model][0], $action)) {
            $this->errorResponse('You do not have permission to perform this action', 403);
            exit;
        }
        return true;
    }

    public function get_id_from_header()
    {
        $headers = getallheaders();
        if (isset($headers['X-Object-Id'])) {
            return $headers['X-Object-Id'];
        }
        $this->errorResponse('Bad request: No Id provided');
    }

    private function get_jwt_payload()
    {
        if (isset($_COOKIE['jwtToken'])) {
            // Extract token from the Authorization header
            $token = $_COOKIE['jwtToken'];

            $JWT_Token = new JWTToken();

            try {
                $payload = $JWT_Token->decode_token($token);
                return $payload;
            } catch (Exception $e) {
                // Handle invalid or expired JWT token
                header('HTTP/1.1 401 Unauthorized');
                echo 'Unauthorized: ' . 'Token is invalid or expired';
                exit;
            }
        }
        return null;
    }

    private function get_user_data()
    {
        $jwt_payload = $this->get_jwt_payload();

        if (isset($jwt_payload)) {
            $user_data = $jwt_payload->data;
            return $user_data;
        }
        return null;
    }

    public function get_user_role()
    {
        $user_data = $this->get_user_data();
        if (isset($user_data)) {
            return $user_data->user_role;
        }
        return 'Guest';
    }

    public function get_user_id()
    {
        $user_data = $this->get_user_data();
        if (isset($user_data)) {
            return $user_data->user_id;
        }
        return null;
    }

    public function get_user_email()
    {
        $user_data = $this->get_user_data();
        if (isset($user_data)) {
            return $user_data->user_email;
        }
        return null;
    }

    public function get_user_info()
    {
        $user_data = $this->get_user_data();
        if (isset($user_data)) {
            return $user_data->user_info;
        }
        return null;
    }

    public function get_user_name()
    {
        $user_data = $this->get_user_data();
        if (isset($user_data)) {
            return $user_data->username;
        }
        return null;
    }

    public function get_user_state()
    {
        $user_data = $this->get_user_data();
        if (isset($user_data)) {
            return $user_data->user_state;
        }
        return null;
    }
}
