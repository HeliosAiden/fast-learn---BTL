<?php

class Home extends Controller
{

    public $model_home;

    public function __construct()
    {
        $this->model_home = $this->model('HomeModel');
    }

    public function index()
    {
        // Phân quyền trang dựa trên user permission
        $page_action = __FUNCTION__;
        $page_dir = $this -> get_page_dir($page_action);
        $page_data = $this -> get_page_data("Trang chủ", $page_dir);
        $role = $this -> get_user_role();
        if ($role == 'Guest') {
            $this -> render_layout('guest', $page_data);
        }
        if ($role !== 'Guest') {
            $this -> render_layout('admin', $page_data);
        }
        return $page_data;
    }

    public function detail($id) {
        $data = $this->model_home->get_detail($id);
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }
}
