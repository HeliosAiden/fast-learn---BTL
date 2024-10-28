<?php
require_once _DIR_ROOT . '/app/apis/Api.php';

$teacher_api = new Api('User');
$subject_api = new Api('Subject');
$enrollment_api = new API('CourseEnrollment');
$lesson_api = new API('CourseLesson');
$file_api = new API('File');
$feedback_api = new API('CourseFeedback');

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

$lessons = $lesson_api -> get_controller() -> get_lessons($current_course['id']);

$hide_card = false;
// If user == 'Student' and found enrollment with $user_id and $current_course => true
// If user_role == 'Teacher' or user+role == 'Admin'
if ($this -> get_user_role() == 'Teacher' || $this -> get_user_role() == 'Admin') {
    $hide_card = true;
}
$student_enrollments = $enrollment_api->get_controller() -> get_course_enrollment_students($current_course['id']);
foreach($student_enrollments as $enrollment) {
    if ($enrollment['student_id'] == $this -> get_user_id()) {
        $hide_card = true;
    }
}

?>
<style>
    .feedback-tab {
        margin: 20px;
    }

    .feedback-form {
        margin-bottom: 20px;
    }

    .star-rating {
        display: flex;
        gap: 5px;
    }

    .star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
    }

    .star.selected {
        color: gold;
    }

    .feedback-card {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }
</style>
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
                                <li class="nav-item submenu" role="presentation"> <a class="nav-link" data-bs-toggle="tab" href="#feedback-tab" role="tab" id="li-feedback-tab" aria-selected="false" tabindex="-1">Đánh giá</a></li>
                                <?php if($hide_card) : ?>
                                <li class="nav-item submenu" role="presentation"> <a class="nav-link" data-bs-toggle="tab" href="#lesson-tab" role="tab" id="li-lesson-tab" aria-selected="false" tabindex="-1">Bài học</a> </li>
                                <li class="nav-item submenu" role="presentation"> <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="false" tabindex="-1">Tài liệu</a> </li>
                                <?php endif ?>
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
                            <?php
                            $image_path = '/app/uploads/images/courses/default.png';
                            if(isset($current_course['file_id'])) {
                                $file_obj = $file_api -> get_controller() -> retrieve_file($current_course['file_id']);
                                $image_path = $file_obj['file_path'];
                            }
                            $course_feed_backs = $feedback_api -> get_controller() -> get_course_feedbacks($current_course['id']);
                            $stars = 0;
                            $sum = 0;
                            foreach($course_feed_backs as $feedback) {
                                $sum += $feedback['rating'];
                            }
                            $total_rating = intdiv($sum, count($course_feed_backs));
                            $remaining_rating = 5 - $total_rating;
                            echo '<img class="img-fluid" src="' . _WEB_ROOT . $image_path .'" alt="course-image" style="object-fit:cover; width:100%">'
                            ?>

                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0"><?php echo number_format($current_course['fee'], 0, '.', ',') ?> VNĐ</h3>
                            <div class="mb-3">
                                <?php
                                    for($i = 0; $i< $total_rating; $i++) {
                                        echo '<small class="fas fa-star star selected"></small>';
                                    }
                                    for($j = 0; $j<$remaining_rating; $j++) {
                                        echo '<small class="fas fa-star star"></small>';
                                    }
                                ?>
                                <small>(<?php echo count($course_feed_backs) ?>)</small>
                            </div>
                            <h5 class="mb-4"><?php echo $current_course['name'] ?></h5>
                        </div>
                        <button id="course-enroll-btn" class="btn btn-secondary w-100">Đăng ký khóa học</button>
                    </div>
                    <div class="card-footer">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number"><?php echo count($lessons) ?></div>
                                <div class="title">Bài học</div>
                            </div>
                            <div class="col">
                                <div class="number"><?php echo count($student_enrollments); ?></div>
                                <div class="title">Học viên</div>
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