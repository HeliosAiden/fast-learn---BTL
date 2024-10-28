<?php
require_once _DIR_ROOT . '/app/apis/Api.php';

$user_api = new Api('User');
$subject_api = new Api('Subject');
$course_api = new Api('Course');
$enrollment_api = new API('CourseEnrollment');

$students = $user_api->get_controller()->get_users_with_condition(['role' => 'Student'], ['id', 'username', 'email', 'state'], ['state' => 'Removed']);
$teachers = $user_api->get_controller()->get_users_with_condition(['role' => 'Teacher'], ['id', 'username', 'email', 'state'], ['state' => 'Removed']);
$courses = $course_api->get_controller()->get_all_courses();
$enrollments = $enrollment_api->get_controller()->get_all_course_enrollment();

$new_students = $user_api->get_controller()->get_users_with_condition(['role' => 'Student'], ['id', 'username', 'email', 'state'], ['state' => 'Removed'], ['created_at DESC'], 5);
$inactive_users = $user_api->get_controller()->get_users_with_condition(['state' => 'Inactive'], ['id', 'username', 'email', 'state'], [], ['created_at DESC'], 5);
$locked_users = $user_api->get_controller()->get_users_with_condition(['state' => 'Locked'], ['id', 'username', 'email', 'state'], [], ['created_at DESC'], 5);
;

?>
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div
                                    class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Học sinh</p>
                                    <h4 class="card-title"><?php echo count($students) ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div
                                    class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Giáo viên</p>
                                    <h4 class="card-title"><?php echo count($teachers) ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div
                                    class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-book-open"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Khóa học</p>
                                    <h4 class="card-title"><?php echo count($courses) ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div
                                    class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">lượt đăng ký khóa học</p>
                                    <h4 class="card-title"><?php echo count($enrollments) ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Học viên mới</div>
                            <div class="card-tools">
                                <button
                                    class="btn btn-icon btn-clean me-0"
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div
                                    class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="<?php echo _WEB_ROOT ?>/hoc-sinh/">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-list py-4">
                            <?php
                            if (!empty($new_students)) {
                                foreach ($new_students as $student) {
                                    echo '
                                    <div class="item-list">
                                        <div class="avatar">
                                            <img
                                                src="' . _WEB_ROOT . '/public/assets/admin/img/default_user.jpg"
                                                alt="..."
                                                class="avatar-img rounded-circle" />
                                        </div>
                                        <div class="info-user ms-3">
                                            <div class="username">' . $student['username'] . '</div>
                                            <div class="status">' . $student['email'] . '</div>
                                        </div>
                                        <a href="' . _WEB_ROOT . '/thong-tin-ca-nhan/chi-tiet/' . $student['id'] . '" class="btn btn-icon btn-link op-8 me-1">
                                        <i class="fas fa-info"></i>
                                        </a>
                                    </div>
                                    ';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Người dùng chưa kích hoạt</div>
                            <div class="card-tools">
                                <button
                                    class="btn btn-icon btn-clean me-0"
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-list py-4">
                            <?php
                            if (!empty($inactive_users)) {
                                foreach ($inactive_users as $user) {
                                    echo '
                                    <div class="item-list">
                                        <div class="avatar">
                                            <img
                                                src="' . _WEB_ROOT . '/public/assets/admin/img/default_user.jpg"
                                                alt="..."
                                                class="avatar-img rounded-circle" />
                                        </div>
                                        <div class="info-user ms-3">
                                            <div class="username">' . $user['username'] . '</div>
                                            <div class="status">' . $user['email'] . '</div>
                                        </div>
                                        <a href="' . _WEB_ROOT . '/thong-tin-ca-nhan/chi-tiet/' . $user['id'] . '" class="btn btn-icon btn-link op-8 me-1">
                                        <i class="fas fa-info"></i>
                                        </a>

                                    </div>
                                    ';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Người dùng bị khóa</div>
                            <div class="card-tools">
                                <button
                                    class="btn btn-icon btn-clean me-0"
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-list py-4">
                        <?php
                            if (!empty($locked_users)) {
                                foreach ($locked_users as $user) {
                                    echo '
                                    <div class="item-list">
                                        <div class="avatar">
                                            <img
                                                src="' . _WEB_ROOT . '/public/assets/admin/img/default_user.jpg"
                                                alt="..."
                                                class="avatar-img rounded-circle" />
                                        </div>
                                        <div class="info-user ms-3">
                                            <div class="username">' . $user['username'] . '</div>
                                            <div class="status">' . $user['email'] . '</div>
                                        </div>
                                        <a href="' . _WEB_ROOT . '/thong-tin-ca-nhan/chi-tiet/' . $user['id'] . '" class="btn btn-icon btn-link op-8 me-1">
                                        <i class="fas fa-info"></i>
                                        </a>

                                    </div>
                                    ';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>