<?php
    class Student extends Controller {
        public $model_student;

        public function __construct()
        {
            $this->model_student = $this->model('StudentModel');
        }

        public function index() {
            $page_action = __FUNCTION__;
            $page_dir = $this -> get_page_dir($page_action);
            $page_data = $this -> get_page_data("Trang sinh viên", $page_dir);
            $this -> render_layout('test', $page_data);
            return $page_data;
        }

        public function list() {
            $page_action = __FUNCTION__;
            $page_dir = $this -> get_page_dir($page_action);
            $data = $this -> model_student -> select_all();
            $page_data = $this -> get_page_data("Liệt kê trang sinh viên", $page_dir);
        }

        public function register() {
            $page_action = __FUNCTION__;
            $page_dir = $this -> get_page_dir($page_action);
            $page_data = $this -> get_page_data("Đăng ký sinh viên mới", $page_dir);
            $this -> render_layout('test', $page_data);
            return $page_data;
        }
    }
?>