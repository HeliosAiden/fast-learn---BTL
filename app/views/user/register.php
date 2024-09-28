<div class="register-form mt-4" id="register-form" style="width: 40%; margin:auto;"></div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";

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
                    { label: "Học sinh", value: "student" },
                    { label: "Giáo viên", value: "teacher" },
                    { label: "Admin", value: "admin" }
                ]
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
        submitButton: {
            id: "submitBtn",
            label: "Gửi"
        }
    }

    // Gửi thông tin
    const registerForm = new FormMixin(formConfigs)
    registerForm.render("#register-form")

    const handleSubmitForm = () => {
        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

        let url = '/app/apis/user.php'
        const usernameInput = document.getElementById("username").value
        const passwordInput = document.getElementById("password").value
        const confirmPasswordInput = document.getElementById("confirm_password").value
        const data = {
            username: usernameInput,
            password: passwordInput,
            confirm_password: confirmPasswordInput
        }
        httpMixin.postMixin(url, data)
    }
    const submitButton = document.getElementById("submitBtn")
    submitButton.addEventListener("click", handleSubmitForm)
</script>