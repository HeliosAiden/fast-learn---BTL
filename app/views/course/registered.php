<?php
require_once _DIR_ROOT . '/app/apis/Api.php';

$teacher_api = new Api('User');
$subject_api = new Api('Subject');
$enrollment_api = new API('CourseEnrollment');

$courses = $this->get_all_courses();

$subjects = $subject_api->get_controller()->get_all_subjects();

$teachers = $teacher_api->get_controller()->get_users_with_condition(['role' => 'Teacher'], ['id', 'username', 'email', 'state'], ['state' => 'Removed']);

$enrollments = $enrollment_api->get_controller()->get_all_course_enrollment();

$registered_courses = [];


if (!empty($enrollments)) {
    foreach ($courses as $course) {
        foreach ($enrollments as $enrollment) {
            if ($course['id'] == $enrollment['course_id'] && $enrollment['student_id'] == $this->get_user_id()) {
                array_push($registered_courses, $course);
            }
        }
    }
}

?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Các khóa học của tôi</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
                    <li class="nav-item submenu" role="presentation">
                        <a class="nav-link active" id="pills-home-all-course" data-bs-toggle="pill" href="#tab-all-course" role="tab" aria-controls="tab-all-course" aria-selected="true">Tất cả</a>
                    </li>
                    <?php
                    foreach ($subjects as $subject) {
                        echo '
                            <li class="nav-item submenu" role="presentation">
                                <a class="nav-link" id="pills-course-' . $subject['id'] . '" data-bs-toggle="pill" href="#tab-' . $subject['id'] . '" role="tab" aria-controls="tab-' . $subject['id'] . '" aria-selected="true">' . $subject['name'] . '</a>
                            </li>
                            ';
                    }
                    ?>
                </ul>
                <div class="tab-content mt-4 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade active show" id="tab-all-course" role="tabpanel" aria-labelledby="pills-home-all-course">
                        <div class="row">
                            <?php foreach ($registered_courses as $course) {
                                $teacher_name = 'Không xác định';
                                foreach ($teachers as $teacher) {
                                    if ($course['teacher_id'] == $teacher['id']) {
                                        $teacher_name = $teacher['username'];
                                    }
                                }
                                $subject_name = "Không xác định";
                                foreach ($subjects as $subject) {
                                    if ($course['subject_id'] == $subject['id']) {
                                        $subject_name = $subject['name'];
                                    }
                                }
                                echo '
                                        <div class="col-md-4 mb-4">
                                            <div class="position-relative overflow-hidden">
                                                <img class="img-fluid" src="' . _WEB_ROOT . '/app/uploads/images/courses/default.png" alt="default-image" style="object-fit:cover; width:100%">
                                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                                    <a href="' . _WEB_ROOT . '/khoa-hoc/chi-tiet/' . $course['id'] . '" class="flex-shrink-0 btn btn-md btn-success px-3 border-end" style="border-radius: 30px">Vào học</a>
                                                </div>
                                            </div>
                                            <div class="text-center p-4 pb-0">
                                            <div class="mb-3">
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small>(123)</small>
                                            </div>
                                            <h3 class="mb-2">' . $course['name'] . '</h3>
                                            <h5 class="mb-4">' . $subject_name . '</h5>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>' . $teacher_name . '</small>
                                                <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                                            </div>
                                        </div>
                                        ';
                            } ?>
                        </div>
                    </div>
                    <?php
                    foreach ($subjects as $subject) {
                        echo '
                                <div class="tab-pane fade show" id="tab-' . $subject['id'] . '" role="tabpanel" aria-labelledby="pills-course-' . $subject['id'] . '">
                                    <div class="row">
                                    ';
                        $filtered_course = [];
                        foreach ($registered_courses as $course) {
                            if ($course['subject_id'] == $subject['id']) {
                                array_push($filtered_course, $course);
                            }
                        }
                        foreach ($filtered_course as $course) {
                            $teacher_name = 'Không xác định';
                            foreach ($teachers as $teacher) {
                                if ($course['teacher_id'] == $teacher['id']) {
                                    $teacher_name = $teacher['username'];
                                }
                            }
                            $subject_name = "Không xác định";
                            foreach ($subjects as $subject) {
                                if ($course['subject_id'] == $subject['id']) {
                                    $subject_name = $subject['name'];
                                }
                            }
                            echo '
                                    <div class="col-md-4 mb-4">
                                            <div class="position-relative overflow-hidden">
                                                <img class="img-fluid" src="' . _WEB_ROOT . '/app/uploads/images/courses/default.png" alt="default-image" style="object-fit:cover; width:100%">
                                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                                    <a href="' . _WEB_ROOT . '/khoa-hoc/chi-tiet/' . $course['id'] . '" class="flex-shrink-0 btn btn-md btn-success px-3 border-end" style="border-radius: 30px">Vào học</a>
                                                </div>
                                            </div>
                                            <div class="text-center p-4 pb-0">
                                            <div class="mb-3">
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small class="fa fa-star text-primary"></small>
                                            <small>(123)</small>
                                            </div>
                                            <h3 class="mb-2">' . $course['name'] . '</h3>
                                            <h5 class="mb-4">' . $subject_name . '</h5>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>' . $teacher_name . '</small>
                                                <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                                            </div>
                                        </div>
                                        ';
                        }

                        echo '
                                    </div>
                                </div>

                            ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>