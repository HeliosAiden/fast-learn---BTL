<?php

class Home extends Controller
{

    public $model_home;

    public function __construct()
    {
        $this->model_home = $this->model('UserModel');
    }

    public function index()
    {
        $data = $this->model_home->get_list();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function detail($id) {
        $data = $this->model_home->get_detail($id);
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }
}
