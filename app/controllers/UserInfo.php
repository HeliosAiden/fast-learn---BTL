<?php

class UserInfo extends Controller
{
    public function __construct()
    {
        $this->__model = $this->model('UserInfoModel');
    }

    public function index()
    {
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Thông tin người dùng", $page_dir);
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function detail($id) {
        $all_user_infos = $this->__model->select_all();
        $current_user_info = null;
        if (!empty($all_user_infos)) {
            foreach ($all_user_infos as $user_info) {
                if ($user_info['user_id'] == $id) {
                    $current_user_info = $user_info;
                }
            }
        }
        require _DIR_ROOT . '/app/apis/Api.php';
        $user_api = new Api('User');
        $current_user = $user_api -> get_controller() -> retrieve_user($id);
        if (!isset($current_user)) {
            return null;
        }
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Thông tin người dùng", $page_dir, ['current_user_info' => $current_user_info, 'current_user' => $current_user]);
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
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Created user info successfully',
                ]
            );
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
