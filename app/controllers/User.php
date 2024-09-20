<?php

class User extends Controller
{

    public $model_user;

    public function __construct()
    {
        $this->model_user = $this->model('UserModel');
    }

    public function index()
    {
        $data = $this->model_user->get_list();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function detail($id) {
        $data = $this->model_user->get_detail($id);
        echo "Bạn đã đăng ký thành công!";
        echo "<br/>";
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }

    public function register($username, $password, $email) {
        $data = $this->model_user->register($username, $password, $email);
        echo '<pre>';
            print_r($data);
        echo '</pre>';
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
