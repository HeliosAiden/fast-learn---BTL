<style>
    /* Transparent background with white text */
    header {
        backdrop-filter: blur(10px);
        /* Apply blur effect */
        background-color: rgba(255, 255, 255, 0.1);
        /* Semi-transparent background */
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        /* Optional: subtle border */
    }

    /* Center the navbar and ensure padding */
    .navbar-collapse {
        justify-content: center;
    }

    /* Login button styling */
    .btn-login {
        color: white;
        background-color: var(--primary);
        padding: 0.5rem 1rem;
        font-weight: bold;
        border-radius: 0.25rem;
    }

    .btn-login:hover {
        color: white;
        background-color: var(--primary);
        border: 1px solid var(--primary);
    }

    /* Register button styling */
    .btn-register {
        color: var(--primary);
        background-color: transparent;
        border: 1px solid var(--primary);
        padding: 0.5rem 1rem;
        font-weight: bold;
        border-radius: 0.25rem;
    }

    .btn-register:hover {
        background-color: white;
        color: var(--primary);
    }

    .h-42 {
        height: 42px !important;
    }

    .padd-navbar {
        padding: 0 3rem !important;
    }
</style>
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="<?php echo _WEB_ROOT ?>/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="<?php echo _WEB_ROOT ?>/public/assets/images/fast-learn-logo.png" style="width: 80px; height: auto; display: block; margin: 0 auto;">
        <h2 class="m-0 text-primary">FastLearn.</h2>

    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse padd-navbar" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="<?php echo _WEB_ROOT ?>/" class="nav-item nav-link active">Trang chủ</a>
            <a href="<?php echo _WEB_ROOT ?>/gioi-thieu/" class="nav-item nav-link">Giới thiệu</a>
            <a href="<?php echo _WEB_ROOT ?>/cac-khoa-hoc/" class="nav-item nav-link">Các khóa học</a>
            <a href="<?php echo _WEB_ROOT ?>/lien-he/" class="nav-item nav-link">Liên hệ</a>
        </div>
        <a href="<?php echo _WEB_ROOT ?>/dang-nhap/" class="btn btn-login me-2 h-42">Đăng nhập</a>
        <a href="<?php echo _WEB_ROOT ?>/dang-ky/" class="btn btn-register h-42">Đăng ký</a>
    </div>
</nav>
<!-- Navbar End -->