<?php
require_once _DIR_ROOT . '/app/apis/Api.php';

$teacher_api = new Api('User');
$subject_api = new Api('Subject');
$enrollment_api = new API('CourseEnrollment');

$current_course = $data['current_course'];

$subjects = $subject_api->get_controller()->get_all_subjects();

$teachers = $teacher_api->get_controller()->get_users_with_condition(['role' => 'Teacher'], ['id', 'username', 'email', 'state'], ['state' => 'Removed']);

$teacher_name = '';
$teacher_email = '';
foreach ($teachers as $teacher) {
    if ($teacher['id'] == $current_course['teacher_id']) {
        $teacher_name = $teacher['username'];
        $teacher_email = $teacher['email'];
    }
}
$subject_name = '';
foreach ($subjects as $subject) {
    if ($subject['id'] == $current_course['subject_id']) {
        $subject_name = $subject['name'];
    }
}

$hide_card = false;
// If user == 'Student' and found enrollment with $user_id and $current_course => true
// If user_role == 'Teacher' or user+role == 'Admin'
if ($this -> get_user_role() == 'Teacher' || $this -> get_user_role() == 'Admin') {
    $hide_card = true;
}
$enrollments = $enrollment_api->get_controller()->get_all_course_enrollment();
foreach($enrollments as $enrollment) {
    if ($enrollment['student_id'] == $this -> get_user_id() && $enrollment['course_id'] == $current_course['id']) {
        $hide_card = true;
    }
}

?>

<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Thông tin khóa học</h3>
        <div class="row">
            <div class="<?php if ($hide_card) {
                echo 'col-md-12';
            } else {
                echo 'col-md-8';
            } ?>">
                <div class="card card-with-nav">
                    <div class="card-header">
                        <div class="row row-nav-line">
                            <ul class="nav nav-tabs nav-line nav-color-secondary w-100 ps-4" role="tablist">
                                <li class="nav-item submenu" role="presentation"> <a class="nav-link show active" data-bs-toggle="tab" href="#info-tab" id="li-info-tab" role="tab" aria-selected="true">Giới thiệu</a> </li>
                                <li class="nav-item submenu" role="presentation"> <a class="nav-link" data-bs-toggle="tab" href="#feedback-tab" role="tab" id="li-feedback-tab" aria-selected="false" tabindex="-1">Đánh giá</a> </li>
                                <li class="nav-item submenu" role="presentation"> <a class="nav-link" data-bs-toggle="tab" href="#lesson-tab" role="tab" id="li-lesson-tab" aria-selected="false" tabindex="-1">Bài học</a> </li>
                                <li class="nav-item submenu" role="presentation"> <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="false" tabindex="-1">Tài liệu</a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content mt-4 mb-3" id="pills-without-border-tabContent">
                        <?php require __DIR__ . '/tabs/info_tab.php' ?>
                        <?php require __DIR__ . '/tabs/feedback_tab.php' ?>
                        <?php require __DIR__ . '/tabs/lesson_tab.php' ?>

                    </div>
                </div>
            </div>
            <?php if (!$hide_card): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="<?php echo _WEB_ROOT ?>/app/uploads/images/courses/default.png" alt="default-image" style="object-fit:cover; width:100%">
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0"><?php echo number_format($current_course['fee'], 0, '.', ',') ?> VNĐ</h3>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(123)</small>
                            </div>
                            <h5 class="mb-4"><?php echo $current_course['name'] ?></h5>
                        </div>
                        <button id="course-enroll-btn" class="btn btn-secondary w-100">Đăng ký khóa học</button>
                    </div>
                    <div class="card-footer">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number">25</div>
                                <div class="title">Bài học</div>
                            </div>
                            <div class="col">
                                <div class="number">30</div>
                                <div class="title">Người đăng ký học</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>"
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    const handleEnrollment = async () => {
        let url = 'app/apis/course_enrollment.php'
        let student_id = '<?php echo $this->get_user_id() ?>';
        let course_id = '<?php echo $current_course['id'] ?>';
        let data = {
            student_id: student_id,
            course_id: course_id
        }
        const response = await httpMixin.postMixin(url, data)
        if (response.status == 'success') {
            swal({
                title: "Đăng ký khoa học thành công!",
                icon: "success",
                buttons: {
                    confirm: {
                        text: "Xác nhận",
                        value: true,
                        visible: true,
                        className: "btn btn-success",
                        closeModal: true,
                    },
                },
            });
        } else {
            swal(response.message ?? "Đăng ký khóa học thất bại!", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                        closeModal: true,
                        visible: true
                    },
                },
            });
        }
    }

    $(document).ready(function() {
        document.getElementById('course-enroll-btn').addEventListener('click', handleEnrollment)
    });
</script>