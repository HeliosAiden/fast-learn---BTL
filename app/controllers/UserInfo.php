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
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function retrieve_user_info() {
        $user_id = $this -> get_user_id();
        return $this -> __model -> retrieve_user_info($user_id);
    }

    public function get_user_info()
    {
        // If jwt have user_info then get user from jwt
        // If not the query the db
        parent::get_user_info();
    }

    public function create_user_info()
    {
        $data = $this->getInput();
        $user_id = $this->get_user_id();
        if (!isset($user_id)) {
            $this->errorResponse('Bad request: no user ID found');
        }

        $user_info_id = $this->__model->create_user_info(
            $user_id,
            $data['firstname'] ?? '',
            $data['lastname'] ?? '',
            $data['gender'] ?? null,
            $data['phone_number'] ?? '',
            $data['date_of_birth'] ?? null,
            $data['about'] ?? '',
        );
        if ($user_info_id) {
            return $user_info_id;
        } else {
            $this->errorResponse('Create new user info fail');
        }
    }

    public function update_user_info() {
        $data = $this->getInput();
        $id = $this -> get_id_from_header();

        $user_info_id = $this->__model->update_user_info(
            $id,
            $data['firstname'] ?? '',
            $data['lastname'] ?? '',
            $data['gender'] ?? null,
            $data['phone_number'] ?? '',
            $data['date_of_birth'] ?? null,
            $data['about'] ?? '',
        );
        if ($user_info_id) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Update user info successfully',
                    'data' => $user_info_id
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
