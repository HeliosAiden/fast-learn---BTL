<div id="login-container" style="margin: auto; width: 20%" ></div>

<script type="module">
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackBar.js' ?>";
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";

    const loginFormConfigs = {
        title: {
            label: 'Đăng nhập tài khoản',
            class: 'mb-4',
            tag: 'h2'
        },
        fields: [
            {
                type: "select",
                name: "role",
                options: [
                    { label: "Sinh viên", value: "Student" },
                    { label: "Giáo viên", value: "Teacher" },
                    { label: "Quản trị hệ thống", value: "Admin" }
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
        buttonArea: [
            {
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
    loginForm.render('#login-container')

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