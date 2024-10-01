<?php

class Subject extends Controller {
    public function __construct()
    {
        $this->__model = $this->model('SubjectModel');
    }

    public function index()
    {
        $all_subjects = $this -> __model -> select_all();
        $page_dir = $this -> get_page_dir(__FUNCTION__);
        $page_data = $this -> get_page_data("Tất cả các môn học hiện tại", $page_dir, ['all_subjects' => $all_subjects]);
        $this -> render_layout('test', $page_data);
        return $page_data;
    }

    public function get_subject() {
        $response = $this -> __model -> select_all();
        if ($response) {
            $this->jsonResponse([
                'status' => 'success',
                'data' => $response
            ]);
        } else {
            $this -> jsonResponse([
                'status' => 'success',
                'data' => []
            ]);
        }
    }
}

?>