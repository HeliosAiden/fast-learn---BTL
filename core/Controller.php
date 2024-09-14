<?php
class Controller
{
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

    public function render($view, $data = []) {
        $view_url = _DIR_ROOT . '/app/views/' . $view . '.php';
        if (file_exists($view_url)) {
            require_once $view_url;
        } 
    }
}
