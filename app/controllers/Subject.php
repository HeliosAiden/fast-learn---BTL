<?php

class Subject extends Controller
{
    public function __construct()
    {
        $this->__model = $this->model('SubjectModel');
    }

    public function index()
    {
        $all_subjects = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Tất cả các môn học hiện tại", $page_dir, ['all_subjects' => $all_subjects]);
        $this->render_layout('test', $page_data);
        return $page_data;
    }

    public function get_subject()
    {
        $data = $this->__model->select_all();
        if ($data) {
            $this->jsonResponse([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            $this->jsonResponse([
                'status' => 'success',
                'data' => []
            ]);
        }
    }

    public function create_subject()
    {
        $data = $this->getInput();
        if (!$data || !isset($data['name'])) {
            $this->errorResponse();
        }

        $subject_data = $this->__model->create_subject($data['name']);
        if ($subject_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Subject created successfully',
                    'data' => $subject_data
                ]
            );
        } else {
            $this->errorResponse();
        }
    }

    public function update_subject() {
        $data = $this->getInput();
        if (!$data || !isset($data['name']) || !isset($data['id'])) {
            $this->errorResponse();
        }

        $subject_data = $this->__model->update_subject($data['id'], $data['name']);
        if ($subject_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Subject edit successfully',
                    'data' => $subject_data
                ]
            );
        } else {
            $this->errorResponse();
        }
    }

    public function delete_subject() {
        $data = $this->getInput();
        if (!$data || !isset($data['id'])) {
            $this->errorResponse();
        }

        $subject_data = $this->__model->delete_subject($data['id']);
        if ($subject_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Delete subject successfully',
                    'data' => $subject_data
                ]
            );
        } else {
            $this->errorResponse();
        }
    }
}
