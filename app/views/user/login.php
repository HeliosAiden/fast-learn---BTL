<div id="login-container" style="margin: auto; width: 40%" ></div>

<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";

    const loginFormConfigs = {
        title: "Đăng nhập tài khoản",
        fields: [
            {
                type: "select",
                name: "role",
                options: [
                    { label: "Sinh viên", value: "student" },
                    { label: "Giáo viên", value: "teacher" },
                    { label: "Quản trị hệ thống", value: "admin" }
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
        submitButton: {
            id: "loginBtn",
            label: "Đăng nhập",
            icon: {
                class: 'fa-solid fa-door-open',
                position: 'start'
            }
        },
        class: 'text-center'
    }

    const loginForm = new FormMixin(loginFormConfigs)
    loginForm.render('#login-container')

    let url = '/app/apis/login.php'

    function setJwtCookie(token) {
        const expiryDays = 1; // Cookie expiration time in days
        const date = new Date();
        date.setTime(date.getTime() + (expiryDays * 24 * 60 * 60 * 1000));  // Set expiry to 1 day later
        const expires = "expires=" + date.toUTCString();

        // Set the cookie with the JWT token
        // When using HTTPS then use Secure option
        // document.cookie = "jwtToken=" + token + ";" + expires + ";path=/;SameSite=Strict;Secure";
        document.cookie = "jwtToken=" + token + ";" + expires + ";path=/;SameSite=Strict";
    }

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

        if (response.status == 'success') {
            // Store the JWT token in localStorage & cookie
            localStorage.setItem('jwtToken', response.token);
            setJwtCookie(response.token)
            window.location.replace('<?php echo _WEB_ROOT . '/user/list' ?>');
        }


    }

    const loginButton = document.getElementById('loginBtn')
    loginButton.addEventListener('click', handleLogin)
</script>