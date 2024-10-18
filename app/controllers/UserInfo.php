<?php

class UserInfo extends Controller
{
    public function __construct()
    {
        $this->__model = $this->model('UserInfoModel');
    }

    public function index()
    {
        $all_user_infos = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Thông tin người dùng", $page_dir, ['all_user_infos' => $all_user_infos]);
        $this->render_layout('test', $page_data);
        return $page_data;
    }

    public function get_user_info()
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

    public function create_user_info()
    {
        $data = $this->getInput();
        $user_id = $this->get_user_id();
        if (!$data || !isset($data['name']) || !isset($data['subject_id'])) {
            $this->errorResponse();
        }
        if (!isset($user_id)) {
            $this->errorResponse('Bad request: no user ID found');
        }

        $user_info_data = $this->__model->create_user_info(
            $data['name'],
            $data['subject_id'],
            $user_id,
            $data['description'],
            $data['fee'],
            $data['start_date'],
            $data['end_date'],
        );
        if ($user_info_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'user_info created successfully',
                    'data' => $user_info_data
                ]
            );
        } else {
            $this->errorResponse('Create new user_info fail');
        }
    }

    public function update_user_info() {
        $data = $this->getInput();
        $id = $this -> get_id_from_header();
        $user_id = $this->get_user_id();
        if (!isset($user_id)) {
            $this->errorResponse('No user id');
        }

        $user_info_data = $this->__model->update_user_info($id, $user_id, $data['name'], $data['description'], $data['fee']);
        if ($user_info_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Subject edit successfully',
                    'data' => $user_info_data
                ]
            );
        }
    }

    public function delete_user_info() {
        $id = $this -> get_id_from_header();

        $user_info_data = $this->__model->delete_user_info($id);
        if ($user_info_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Delete subject successfully',
                    'data' => $user_info_data
                ]
            );
        } else {
            $this->errorResponse();
        }
    }
}
