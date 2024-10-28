<?php

$user_info = $data['current_user_info'];
$user_role = $data['current_user']['role'];
$user_email = $data['current_user']['email'];
$user_state = $data['current_user']['state'];
$username = $data['current_user']['username'];
$user_role_text = '';
switch ($user_role) {
    case 'Student':
        $user_role_text = 'Học sinh';
        break;
    case 'Teacher':
        $user_role_text = 'Giáo viên';
        break;
    case 'Admin':
        $user_role_text = 'Quản trị viên';
        break;
    default:
        $user_role_text = 'Không xác định';
        break;
}
$user_state_text = '';
switch ($user_state) {
    case 'Active':
        $user_state_text = 'Đang hoạt động';
        break;
    case 'Inactive':
        $user_state_text = 'Chưa duyệt';
        break;
    case 'Locked':
        $user_state_text = 'Đã khóa';
        break;
    default:
        $user_state_text = 'Không xác định';
        break;
}

if (isset($data['current_user_info'])) {

    $user_gender = $data['current_user_info']['gender'];

    $user_gender_text = 'Không xác định';
    switch ($user_gender) {
        case 'Male':
            $user_gender_text = 'Nam';
            break;
        case 'Femail':
            $user_gender_text = 'Nữ';
            break;
        case 'Others':
            $user_gender_text = 'Giới tính thứ 3';
            break;
        default:
            break;
    }
}

?>
<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Thông tin người dùng</h3>
        <div class="card card-with-nav">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username của tài khoản" value="<?php echo $username ?? '' ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="địa chỉ email" value="<?php echo $user_email ?? '' ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-default">
                            <label>Quyền hạn</label>
                            <input type="text" class="form-control" id="role" name="datepicker" value="<?php echo $user_role_text ?? '' ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-default">
                            <label>Trạng thái</label>
                            <input type="text" class="form-control" id="state" name="datepicker" value="<?php echo $user_state_text ?? '' ?>" disabled>
                        </div>
                    </div>
                </div>
                <?php if (isset($data['current_user_info'])) : ?>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Tên</label>
                            <p class="mt-2 mb-0"><?php echo $user_info['firstname'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Họ</label>
                            <p class="mt-2 mb-0"><?php echo $user_info['lastname'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Giới tính</label>
                            <p class="mt-2 mb-0"><?php echo $user_gender_text ?></p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Ngày tháng năm sinh</label>
                            <p class="mt-2 mb-0"><?php echo $user_info['date_of_birth'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Số điện thoại</label>
                            <p class="mt-2 mb-0"><?php echo $user_info['phone_number'] ?? '' ?></p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 mb-1">
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label>Giới thiệu bản thân</label>
                            <p class="mt-2 mb-0"><?php echo $user_info['about'] ?? '' ?></p>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>