<style>
    .login-container {
        max-width: 400px;
        min-width: 250px;
        margin: 50px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .btn-custom {
        background-color: #28a745;
        color: white;
    }

    .btn-custom:hover {
        background-color: #218838;
    }

    .login-link,
    .register-link {
        color: #28a745;
    }

    .login-link:hover,
    .register-link:hover {
        text-decoration: underline;
    }
</style>
<div class="login-container col-6 mx-auto paper">
    <h3 class="text-center" style="margin-bottom: 32px">Đăng nhập</h3>
    <form>
        <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
            <label class="form-check-label" for="rememberMe">Lưu thông tin đăng nhập</label>
        </div>
        <button type="submit" class="btn btn-custom btn-block mt-3">Đăng nhập</button>
    </form>
    <p class="text-center mt-3">Chưa có tài khoản ? <a href="register.php" class="register-link">Đăng ký ngay</a></p>
</div>

<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackBar.js' ?>";

    const loginFormConfigs = {
        title: {
            label: 'Đăng nhập tài khoản',
            class: 'mb-4',
            tag: 'h2'
        },
        fields: [{
                type: "select",
                name: "role",
                options: [{
                        label: "Sinh viên",
                        value: "Student"
                    },
                    {
                        label: "Giáo viên",
                        value: "Teacher"
                    },
                    {
                        label: "Quản trị hệ thống",
                        value: "Admin"
                    }
                ]
            },
            {
                type: "text",
                name: "username",
                placeholder: "Tài khoản"
            },
            {
                type: "password",
                name: "password",
                placeholder: "Nhập mật khẩu"
            }
        ],
        buttonArea: [{
                id: "loginBtn",
                tag: 'button',
                label: "Đăng nhập",
                type: 'submit',
                class: 'btn btn-primary mx-2',
                icon: {
                    class: 'fa-solid fa-door-open me-2',
                    position: 'start'
                }
            },
            {
                id: "registerBtn",
                label: "Trang đăng ký",
                class: 'btn btn-success mx-2',
                tag: 'a',
                href: '<?php echo _WEB_ROOT . '/user/register' ?>',
                target: '_self',
                icon: {
                    class: 'fa-solid fa-user-plus me-2',
                    position: 'start'
                }
            }
        ],
        class: 'text-center'
    }

    const loginForm = new FormMixin(loginFormConfigs)
    // loginForm.render('#login-container')

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
        const snackBar = new SnackBarMixin();

        if (response.status == 'success') {
            snackBar.showMessage('Đăng nhập thành công', 'success');
            // Store the JWT token in localStorage & cookie
            localStorage.setItem('jwtToken', response.token);
            httpMixin.setJwtCookie(response.token)
            window.location.replace('<?php echo _WEB_ROOT . '/user/list' ?>');
        } else {
            snackBar.showMessage('Đăng nhập không thành công', 'danger');
        }
    }


    const loginButton = document.getElementById('loginBtn')
    loginButton.addEventListener('click', handleLogin)
</script>