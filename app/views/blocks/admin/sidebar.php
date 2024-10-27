<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="<?php echo _WEB_ROOT ?>/" class="logo">
                <img
                    src="<?php echo _WEB_ROOT ?>/public/assets/images/fast-learn-logo.png"
                    alt="navbar brand"
                    class="navbar-brand me-2"
                    height="20" />
                <h2 class="m-0 text-primary" style="color: #6861ce !important">FastLearn.</h2>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Start Sidebar Navbar -->
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <?php if ($this->get_user_role() == 'Admin') : ?>
                    <li class="nav-item active">
                        <a
                            href="<?php echo _WEB_ROOT ?>/"
                            class="collapsed"
                            aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Trang chủ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#charts">
                            <i class="fas fa-user-friends"></i>
                            <p>Người dùng</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="charts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="<?php echo _WEB_ROOT ?>/hoc-sinh">
                                        <span class="sub-item">Học sinh</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo _WEB_ROOT ?>/giao-vien">
                                        <span class="sub-item">Giáo viên</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif ?>
                <li class="nav-item">
                    <?php if ($this->get_user_role() == 'Admin') : ?>
                        <a href="<?php echo _WEB_ROOT ?>/khoa-hoc">
                            <i class="fas fa-book-open"></i>
                            <p>Quản lí khóa học</p>
                        </a>
                    <?php else: ?>
                        <a data-bs-toggle="collapse" href="#course">
                            <i class="fas fa-book-open"></i>
                            <p>Khóa học</p>
                            <span class="caret"></span>
                        </a>
                    <?php endif ?>
                    <?php if ($this->get_user_role() == 'Student') : ?>
                        <div class="collapse" id="course">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="<?php echo _WEB_ROOT ?>/khoa-hoc">
                                        <span class="sub-item">Tất cả các khóa học</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo _WEB_ROOT ?>/khoa-hoc/da-dang-ky">
                                        <span class="sub-item">Khóa học đã đăng ký</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif ?>
                    <?php if ($this->get_user_role() == 'Teacher') : ?>
                        <div class="collapse" id="course">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="<?php echo _WEB_ROOT ?>/khoa-hoc/quan-ly">
                                        <span class="sub-item">Khóa học giảng dạy</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo _WEB_ROOT ?>/khoa-hoc/quan-ly">
                                        <span class="sub-item">Danh sách học viên</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif ?>

                </li>
                <li class="nav-item">
                    <a
                        href="<?php echo _WEB_ROOT ?>/user-info/"
                        class="collapsed"
                        aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <p>Thông tin cá nhân</p>
                    </a>
                    <a
                        href="<?php echo _WEB_ROOT ?>/reset-password/"
                        class="collapsed"
                        aria-expanded="false">
                        <i class="fas fa-lock"></i>
                        <p>Đổi mật khẩu</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- End Sidebar Navbar -->
</div>
<!-- End Sidebar -->