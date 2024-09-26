<?php

class User extends Controller
{

    public function __construct()
    {
        $this->__model = $this->model('UserModel');
    }

    public function list()
    {
        $all_users = $this -> __model -> select_all();
        $page_dir = $this -> get_page_dir(__FUNCTION__);
        $page_data = $this -> get_page_data("Tất cả người dùng hiện tại", $page_dir, ['all_users' => $all_users]);
        $this -> render_layout('test', $page_data);
        return $page_data;
    }

    public function detail($id) {
        $data = $this->__model->get_detail($id);
        echo "Bạn đã đăng ký thành công!";
        echo "<br/>";
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }

    public function register() {
        $page_dir = $this -> get_page_dir(__FUNCTION__);
        $page_data = $this -> get_page_data("Đăng ký người dùng mới", $page_dir);
        $this -> render_layout('test', $page_data);
        return $page_data;
    }

    public function login($username, $password) {
        $data = $this->__model->login($username, $password);
        echo "Bạn đã đăng nhập!";
        echo "<br/>";
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }

    public function create_user() {
        $data = $this->getInput();
        if (!$data || !isset($data['username'], $data['password'])) {
            $this->errorResponse('Invalid input');
        }

        $response = $this -> __model -> register($data['username'], $data['password']);
        if ($response[1]) {
            $this->jsonResponse([
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => $data
            ]);
        } else {
            $this -> errorResponse();
        }
    }

    public function get_user() {
        $response = $this -> __model -> select_all();
        if ($response[1]) {
            $this->jsonResponse([
                'status' => 'success',
                'data' => $response[0]
            ]);
        } else {
            $this -> errorResponse();
        }
    }
}