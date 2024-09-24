<?php

class User extends Controller
{

    public $model_user;

    public function __construct()
    {
        $this->model_user = $this->model('UserModel');
    }

    public function list()
    {
        $all_users = $this -> model_user -> select_all();
        $page_action = __FUNCTION__;
        $page_dir = $this -> get_page_dir($page_action);
        $page_data = $this -> get_page_data("Tất cả người dùng hiện tại", $page_dir, ['$all_users' => $all_users]);
        $this -> render_layout('test', $page_data);
        return $page_data;
    }

    public function detail($id) {
        $data = $this->model_user->get_detail($id);
        echo "Bạn đã đăng ký thành công!";
        echo "<br/>";
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }

    public function register() {
        $page_action = __FUNCTION__;
        $page_dir = $this -> get_page_dir($page_action);
        $page_data = $this -> get_page_data("Đăng ký người dùng mới", $page_dir);
        $this -> render_layout('test', $page_data);
        return $page_data;
    }

    public function login($username, $password) {
        $data = $this->model_user->login($username, $password);
        echo "Bạn đã đăng nhập!";
        echo "<br/>";
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }
}
