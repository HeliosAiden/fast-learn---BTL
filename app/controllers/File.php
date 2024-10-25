<?php

class File extends Controller
{
    public function __construct()
    {
        $this->__model = $this->model('FileModel');
    }

    public function retrieve_file($file_id) {
        $response = $this -> __model -> select_condition(['id' => $file_id]);
        if (!empty($response)) {
            return $response[0];
        }
    }

}