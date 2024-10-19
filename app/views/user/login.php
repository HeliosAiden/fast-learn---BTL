<div id="login-container" style="margin: auto; width: 80%">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Đăng nhập</h3>
                    </div>
                    <div class="card-body">

                        <!-- Role Field -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Quyền</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Chọn quyền của mình</option>
                                <option value="Admin">Quản trị viên</option>
                                <option value="Teacher">Giáo viên</option>
                                <option value="Student">Học sinh</option>
                            </select>
                        </div>

                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button id="login_btn" class="btn btn-success my-2">Đăng nhập</button>
                            <a href="<?php echo _WEB_ROOT ?>/dang-ky" class="btn btn-primary my-2">Trang đăng ký</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">

</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";


    let url = '/app/apis/login.php'

    const handleLogin = async () => {
        const roleInput = document.getElementById("role").value
        const usernameInput = document.getElementById("username").value
        const passwordInput = document.getElementById("password").value

        const data = {
            role: roleInput,
            username: usernameInput,
            password: passwordInput
        }

        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
        const response = await httpMixin.postMixin(url, data)
        console.log(response)

        if (response.status == 'success') {
            swal({
              title: "Đăng nhập thành công!",
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
            // Store the JWT token in localStorage & cookie
            localStorage.setItem('jwtToken', response.token);
            httpMixin.setJwtCookie(response.token)
            window.location.replace('<?php echo _WEB_ROOT . '/' ?>');
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


    const loginButton = document.getElementById('login_btn')
    loginButton.addEventListener('click', handleLogin)
</script>