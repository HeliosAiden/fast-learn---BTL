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
        color: green;
        background-color: white;
        border: 1px solid green;
        padding: 0.5rem 1rem;
        font-weight: bold;
        border-radius: 0.25rem;
    }

    .btn-login:hover {
        background-color: green;
        color: white;
    }

    /* Register button styling */
    .btn-register {
        color: white;
        background-color: transparent;
        border: 1px solid green;
        padding: 0.5rem 1rem;
        font-weight: bold;
        border-radius: 0.25rem;
    }

    .btn-register:hover {
        background-color: green;
        color: white;
    }
</style>
<div style="min-height: 50vh; background-color:black">

    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid justify-content-space-between" style="padding-left: 10%; padding-right: 10%;">
                <!-- Site Logo (Left) -->
                <a class="navbar-brand text-white" href="#">Brand</a>

                <!-- Navbar Links (Center) -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo __URL_ORIGIN__ ?>">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo __URL_ORIGIN__ ?>/gioi-thieu">Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo __URL_ORIGIN__ ?>/khoa-hoc">Khóa học</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo __URL_ORIGIN__ ?>/tin-tuc">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo __URL_ORIGIN__ ?>/lien-he">Liên hệ</a>
                        </li>
                    </ul>
                </div>

                <!-- Login and Register Buttons (Right) -->
                <div class="d-flex">
                    <a href="<?php echo __URL_ORIGIN__ ?>/dang-nhap" class="btn btn-login me-2">Đăng nhập</a>
                    <a href="<?php echo __URL_ORIGIN__ ?>/dang-ky" class="btn btn-register">Đăng ký</a>
                </div>
            </div>
        </nav>
    </header>
</div>