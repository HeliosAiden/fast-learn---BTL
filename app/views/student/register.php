<div class="register-form">
    <h2 class="form-title">Student Registration</h2>
    <form action="register_process.php" method="POST">
        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
        </div>

        <!-- Retype Password -->
        <div class="mb-3">
            <label for="retype_password" class="form-label">Retype Password</label>
            <input type="password" class="form-control" id="retype_password" name="retype_password" placeholder="Retype password" required>
        </div>

        <!-- Submit button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
    </form>
</div>