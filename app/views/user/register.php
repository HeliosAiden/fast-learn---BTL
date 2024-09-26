<div class="register-form">
    <h2 class="form-title">User Registration</h2>
    <!-- Username -->
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    </div>

    <!-- Retype Password -->
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype password" required>
    </div>

    <!-- Submit button -->
    <div class="d-grid">
        <button id="submitBtn" type="submit" class="btn btn-primary btn-block">Register</button>
    </div>

</div>
<script type="module">
    import httpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";

    let url = "<?php echo _WEB_ROOT . '/app/apis/user.php' ?>"
    const handleButtonClick = () => {
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
    submitButton.addEventListener("click", handleButtonClick)
</script>