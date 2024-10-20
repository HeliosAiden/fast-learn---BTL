<?php

class User extends Controller
{

    public function __construct()
    {
        $this->__model = $this->model('UserModel');
    }

    public function list()
    {
        $all_users = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Tất cả người dùng hiện tại", $page_dir, ['all_users' => $all_users]);
        $this->render_layout('test', $page_data);
        return $page_data;
    }

    public function detail($id)
    {
        $data = $this->__model->get_detail($id);
        echo "Bạn đã đăng ký thành công!";
        echo "<br/>";
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function register()
    {
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Đăng ký người dùng mới", $page_dir);
        $this->render_layout('test_blank', $page_data);
        return $page_data;
    }

    public function students()
    {
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Đăng ký người dùng mới", $page_dir);
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function teachers()
    {
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Đăng ký người dùng mới", $page_dir);
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function login()
    {
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Đăng nhập tài khoản", $page_dir);
        $this->render_layout('test_blank', $page_data);
        return $page_data;
    }

    public function reset_password()
    {
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Cài lại mật khẩu", $page_dir);
        $this->render_layout('test_blank', $page_data);
        return $page_data;
    }

    public function perform_login($username, $password, $role = 'Student')
    {
        $response = $this->__model->login($username, $password, $role);
        return $response;
    }

    public function perform_change_password($current_password, $new_password, $confirm_new_password)
    {
        $password_hash = $this->get_current_user_password_hash();

        if (!password_verify($current_password, $password_hash)) {
            $this->errorResponse(`$password_hash khác $current_password`);
            return null;
        }
        if ($new_password !== $confirm_new_password) {
            $this->errorResponse('Mật mới không trùng với mật khẩu xác thực');
            return null;
        }
        if ($current_password === $new_password) {
            $this->errorResponse('Mật mới không trùng với mật khẩu cũ');
            return null;
        }
        $user_id = $this->get_user_id();
        return $this->__model->change_password($new_password, $user_id);
    }

    public function create_user()
    {
        $data = $this->getInput();
        if (!$data || !isset($data['username']) || !isset($data['password']) || !isset($data['email']) || !isset($data['role'])) {
            $this->errorResponse();
        }

        $user_id = $this->__model->register($data['username'], $data['password'], $data['email'], $data['role']);
        if ($user_id) {
            if ($data['role'] == 'Student') {
                // echo json_encode($user_id);
                $this->active_user($user_id);
            }
            $this->jsonResponse([
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => $data
            ]);
        } else {
            $this->errorResponse();
        }
    }

    public function get_user()
    {
        $response = $this->__model->select_all();
        if ($response) {
            $this->jsonResponse([
                'status' => 'success',
                'data' => $response
            ]);
        } else {
            $this->errorResponse();
        }
    }

    public function update_user()
    {
        $data = $this->getInput();
        if (!$data) {
            $this->errorResponse();
        }
        $user_id = $this->get_id_from_header();
        if (isset($data['state'])) {
            $response = $this->__model->update_user_state($user_id, $data['state']);
            if ($response) {
                $this->jsonResponse([
                    'status' => 'success',
                    'data' => $response
                ]);
            } else {
                $this->errorResponse("No changes have been made");
            }
        }
    }

    public function retrieve_user($user_id)
    {
        $response = $this->__model->select_all($user_id);
    }

    public function update_user_info($user_info_id)
    {
        $user_info = $this->get_user_info();
        if (isset($user_info)) {
            exit;
        }
        $user_id = $this->get_user_id();
        return $this->__model->update_user_info($user_id, $user_info_id);
    }

    public function active_user($user_id)
    {
        $this->__model->active_user($user_id);
    }

    protected function get_current_user_password_hash()
    {
        $user_id = $this->get_user_id();
        return $this->__model->get_current_user_password_hash($user_id);
    }

    public function get_users_with_condition($condition = [], $keys = [], $exeption = [])
    {
        return $this->__model->select_condition($condition, $keys, $exeption);
    }
}
