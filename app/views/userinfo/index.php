<?php
$user_info = $this->retrieve_user_info();
$user_role = $this->get_user_role();
$user_email = $this->get_user_email();
$user_state = $this->get_user_state();
$username = $this->get_user_name();

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
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Tên</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user_info['firstname'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Họ</label>
                            <input type="text" class="form-control" id="lastname" name="Lastname" value="<?php echo $user_info['lastname'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Giới tính</label>
                            <select class="form-select" id="gender" value="<?php echo $user_info['gender'] ?? 'Male' ?>">
                                <option value="Male">Nam</option>
                                <option value="Female">Nữ</option>
                                <option value="Others">Khác</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Ngày tháng năm sinh</label>
                            <input type="date" class="form-control" id="dob" name="datepicker" value="<?php echo $user_info['date_of_birth'] == '00-00-0000' ? '' : $user_info['date_of_birth'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label>Số điện thoại</label>
                            <input type="text" class="form-control" id="phone_number" value="<?php echo $user_info['phone_number'] ?? '' ?>" name="phone" placeholder="+84">
                        </div>
                    </div>
                </div>
                <div class="row mt-3 mb-1">
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label>Giới thiệu bản thân</label>
                            <textarea class="form-control" name="about" id="about" placeholder="Viết đôi dòng về bản thân mình" rows="3"><?php echo $user_info['about'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3 mb-3">
                    <button id="save_user_info_btn" class="btn btn-success" disabled>Lưu</button>
                    <button id="reset_user_info_btn" class="btn btn-danger" disabled>Hủy thay đổi</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module">
    // If $user_info is null then create a new user info
    // If not, update the user info

    const user_info = <?php echo json_encode($user_info) ?>;
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>"

    // Add event listener to the element
    function detectFieldChanges(inputIds, submitButtonId, cancelButtonId) {
        const initialValues = {};

        // Capture initial values of specified input fields
        inputIds.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                initialValues[id] = element.value;
            }
        });

        // Function to check if any field has changed
        const checkForChanges = () => {
            let hasChanged = false;
            inputIds.forEach(id => {
                const element = document.getElementById(id);
                if (element && element.value !== initialValues[id]) {
                    hasChanged = true; // A change has been detected
                }
            });
            // Enable or disable the submit button
            const submitButton = document.getElementById(submitButtonId);
            const cancelButton = document.getElementById(cancelButtonId);
            if (submitButton) {
                submitButton.disabled = !hasChanged; // Enable if changed, disable if not
            }
            if (cancelButton) {
                cancelButton.disabled = !hasChanged; // Enable if changed, disable if not
            }
        };

        // Add event listeners to each input element
        inputIds.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                const eventType = (element.type === 'checkbox' || element.type === 'radio' || element.tagName === 'SELECT') ? 'change' : 'input';
                element.addEventListener(eventType, checkForChanges);
            }
        });
    }

    function resetFields(inputIds) {
        inputIds.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                // Resetting to the initial value stored in the element
                element.value = element.defaultValue;
                // If it's a select element, you may want to set the selected option
                if (element.tagName === 'SELECT') {
                    element.selectedIndex = 0; // Adjust index based on your default option
                }
            }
        });
    }

    console.log(user_info)


    const handleSaveButton = async () => {
        let firstName = document.getElementById('firstname').value
        let lastName = document.getElementById('lastname').value
        let dob = document.getElementById('dob').value
        let phoneNumber = document.getElementById('phone_number').value
        let about = document.getElementById('about').value
        let gender = document.getElementById('gender').value

        let data = {
            'firstname': firstName ?? '',
            'lastname': lastName ?? '',
            'gender': gender ?? null,
            'phone_number': phoneNumber ?? '',
            'about': about ?? '',
            'date_of_birth': dob ?? null,
        }

        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
        let url = '/app/apis/user_info.php'


        if (user_info) {
            let user_info_id = user_info['id']
            const response = await httpMixin.putMixin(url, data, user_info_id)
            console.log(response)
            if (response.status == 'success') {
                swal({
                    title: "Cập nhật thông tin thành công!",
                    icon: "success",
                    buttons: {
                        confirm: {
                            text: "Xác nhận",
                            value: true,
                            visible: true,
                            className: "btn btn-success",
                            closeModal: true,
                        },
                    },
                });
                window.location.reload()
            } else {
                swal(response.message ?? "Something went wrong!", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                            closeModal: true,
                            visible: true
                        },
                    },
                });
            }
        } else {
            const response = await httpMixin.postMixin(url, data)
            console.log(response)
            if (response.status == 'success') {
                swal({
                    title: "Cập nhật thông tin thành công!",
                    icon: "success",
                    buttons: {
                        confirm: {
                            text: "Xác nhận",
                            value: true,
                            visible: true,
                            className: "btn btn-success",
                            closeModal: true,
                        },
                    },
                });
            } else {
                swal(response.message ?? "Something went wrong!", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                            closeModal: true,
                            visible: true
                        },
                    },
                });
            }
        }
    }

    const fieldIds = ['firstname', 'lastname', 'gender', 'dob', 'about', 'gender', 'phone_number']

    document.addEventListener('DOMContentLoaded', function() {
        detectFieldChanges(fieldIds, 'save_user_info_btn', 'reset_user_info_btn');
        document.getElementById('reset_user_info_btn').addEventListener('click', function() {
            resetFields(fieldIds);
        });
        document.getElementById('save_user_info_btn').addEventListener('click', handleSaveButton)
    });
</script>