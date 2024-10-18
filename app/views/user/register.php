<div class="register-form mt-4" id="register-form" style="width: 40%; margin:auto;"></div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackBar.js' ?>";

    const snackBar = new SnackBarMixin()

    const formConfigs = {
        title: "Đăng ký người dùng",
        fields: [
            {
                label: "Tên người dùng",
                type: "text",
                name: "username",
                placeholder: "Nhập tên người dùng",
            },
            {
                label: "Vai trò",
                type: "select",
                name: "role",
                options: [
                    { label: "Học sinh", value: "Student" },
                    { label: "Giáo viên", value: "Teacher" }
                ]
            },
            {
            label: "Email",
            type: "email",
            name: "email",
            placeholder: "Nhập email"
            },
            {
            label: "Mật khẩu",
            type: "password",
            name: "password",
            placeholder: "Nhập mật khẩu"
            },
            {
            label: "Xác nhận mật khẩu",
            type: "password",
            name: "confirm_password",
            placeholder: "Xác nhận mật khẩu của bạn"
            }
        ],
        buttonArea: [
            {
                id: 'registerButton',
                label: 'Đăng ký',
                class: 'btn btn-primary mx-2',
                icon: {
                    class: 'fa-solid fa-user-plus me-2',
                    position: 'start'
                }
            },
            {
                id: "loginPage",
                label: "Trang đăng nhập",
                class: 'btn btn-success mx-2',
                tag: 'a',
                href: '<?php echo _WEB_ROOT . '/user/login' ?>',
                target: '_self',
                icon: {
                    class: 'fa-solid fa-user-plus me-2',
                    position: 'start'
                }
            }
        ]
    }

    // Gửi thông tin
    const registerForm = new FormMixin(formConfigs)
    registerForm.render("#register-form")

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
                snackBar.showMessage('Đăng ký thành công', 'success');
                httpMixin.handleLogout()
            } else {
                snackBar.showMessage('Đăng ký không thành công', 'danger');
            }
        }
    }
    const submitButton = document.getElementById("registerButton")
    submitButton.addEventListener("click", handleSubmitForm)
</script>