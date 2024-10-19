<div class="wrapper">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Đổi mật khẩu</h3>
                    </div>
                    <div class="card-body">

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter your password" required>
                        </div>
                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password" name="current_password" placeholder="Enter your password" required>
                        </div>
                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="confirm_new_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="current_password" placeholder="Enter your password" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button id="change_password_btn" class="btn btn-success my-2">Đổi mật khẩu</button>
                            <a href="<?php echo _WEB_ROOT ?>/" class="btn btn-primary my-2">Về trang chính</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";

    const handleChangePassword = async () => {
        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

        let url = '/app/apis/change_password.php'
        const currentPassword = document.getElementById("current_password").value
        const newPassword = document.getElementById("new_password").value
        const confirmNewPassword = document.getElementById("confirm_new_password").value

        const data = {
            current_password: currentPassword,
            new_password: newPassword,
            confirm_new_password: confirmNewPassword,
        }
        if (currentPassword == newPassword) {
            swal('Mật khẩu mới không được trùng với mật khẩu cũ!', {
                buttons: {
                    cancel: {
                        className: "btn btn-danger",
                        visible: true,
                        text: 'close'
                    },
                },
            });
        }
        if (newPassword !== confirmNewPassword) {
            swal('Mật khẩu mới phải trùng với mật khẩu xác thực!', {
                buttons: {
                    cancel: {
                        className: "btn btn-danger",
                        visible: true,
                        text: 'Đóng'
                    },
                },
            });
        }
        const response = await httpMixin.postMixin(url, data)
        if (response.status == 'success') {
            swal("Đổi mật khẩu thành công!", {
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            window.location.href = '<?php echo _WEB_ROOT ?>/dang-nhap/'
        } else {
            swal(response.message ?? 'Đăng ký thất bại!', {
                buttons: {
                    cancel: {
                        className: "btn btn-danger",
                        visible: true,
                        text: 'close'
                    },
                },
            });
        }
    }
    const changePasswordBtn = document.getElementById("change_password_btn")
    changePasswordBtn.addEventListener("click", handleChangePassword)
</script>