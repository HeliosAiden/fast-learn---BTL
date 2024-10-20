<div class="wrapper">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Đăng ký</h3>
                    </div>
                    <div class="card-body">
                        <!-- Role Field -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Quyền</label>
                            <select class="form-select" id="role" name="role" required value="Student">
                                <option value="Student">Học sinh</option>
                                <option value="Teacher">Giáo viên</option>
                            </select>
                        </div>

                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Địa chỉ email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button id="register_btn" class="btn btn-success my-2">Đăng ký</button>
                            <a href="<?php echo _WEB_ROOT ?>/dang-nhap" class="btn btn-primary my-2">Trang đăng nhập</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";


    const handleSubmitForm = async () => {
        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

        let url = '/app/apis/user.php'
        const usernameInput = document.getElementById("username").value
        const roleSelectInput = document.getElementById("role").value
        const emailInput = document.getElementById("email").value
        const passwordInput = document.getElementById("password").value
        const confirmPasswordInput = document.getElementById("confirm_password").value
        const data = {
            username: usernameInput,
            password: passwordInput,
            role: roleSelectInput,
            email: emailInput
        }
        if (passwordInput == confirmPasswordInput) {
            const response = await httpMixin.postMixin(url, data)
            if (response.status == 'success') {
                swal("Đăng ký tài khoản thành công!", {
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
        } else {
            swal('Mật khẩu xác thực phải trùng với mật khẩu!', {
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
    const submitButton = document.getElementById("register_btn")
    submitButton.addEventListener("click", handleSubmitForm)
</script>