<?php

require_once './Api.php';
$api = new Api('User');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->current_password) && isset($data->new_password) && isset($data->confirm_new_password)) {
    $current_password = $data->current_password;
    $new_password = $data->new_password;
    $confirm_new_password = $data->confirm_new_password;

    $user_data = $api -> get_controller() -> perform_change_password($current_password, $new_password, $confirm_new_password);
    header('Content-Type: application/json');
    if (!$user_data) {
        $api -> get_controller() -> errorResponse('Thay mật khẩu thất bại');
    }
    echo json_encode([
        'status' => 'success',
        'message' => 'Thay đổi mật khẩu thành công'
    ]);
}