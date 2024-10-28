<?php
require _DIR_ROOT . '/app/apis/Api.php';

$teacher_api = new Api('User');
$subject_api = new Api('Subject');
$enrollment_api = new API('CourseEnrollment');
$file_api = new API('File');
$feedback_api = new API('CourseFeedback');

$courses = $this->get_all_courses();

$subjects = $subject_api->get_controller()->get_all_subjects();

$teachers = $teacher_api->get_controller()->get_users_with_condition(['role' => 'Teacher'], ['id', 'username', 'email', 'state'], ['state' => 'Removed']);

$enrollments = $enrollment_api->get_controller()->get_all_course_enrollment();

$unregistered_courses = [];

$user_id = $this->get_user_id();

$filtered_enrollments = array_filter($enrollments, function ($enrollment) use ($user_id) {
    return $enrollment['student_id'] === $user_id;
});

$enrolled_courses_ids = array_map(function ($enrollment) {
    return $enrollment['course_id'];
}, $filtered_enrollments);

$unregistered_courses = array_filter($courses, function ($course) use ($enrolled_courses_ids) {
    return !in_array($course['id'], $enrolled_courses_ids);
});

if (empty($filtered_enrollments)) {
    $unregistered_courses = $courses;
}


?>
<style>
    .star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
    }

    .star.selected {
        color: gold;
    }
</style>
<?php if ($this->get_user_role() == 'Admin'): ?>
    <div class="container">
        <?php require_once __DIR__ . '/modals/edit_modal.php' ?>
        <script>
            function openEditModal(button) {
                let course_id = button.getAttribute('data-course-id')
                let course_name = button.getAttribute('data-course-name')
                let course_description = button.getAttribute('data-course-description')
                let course_fee = button.getAttribute('data-course-fee')
                document.getElementById('edit_course_id').value = course_id
                document.getElementById('edit_course_name').value = course_name
                document.getElementById('edit_course_description').value = course_description
                document.getElementById('edit_course_fee').value = course_fee

                const modal = new bootstrap.Modal(document.getElementById('edit-course-modal'));
                modal.show()
            }
        </script>
        <?php require_once __DIR__ . '/modals/delete_modal.php' ?>
        <script>
            function openDeleteModal(button) {
                let course_id = button.getAttribute('data-course-id')
                let course_name = button.getAttribute('data-course-name')
                let subject_name = button.getAttribute('data-subject-name')
                let teacher_id = button.getAttribute('data-course-teacher-id')
                document.getElementById('delete_course_id').value = course_id
                document.getElementById('delete_course_name').innerHTML = course_name
                document.getElementById('delete_course_subject_name').innerHTML = subject_name
                if (document.getElementById('course_edit_teacher_id')) {
                    document.getElementById('course_edit_teacher_id').value = teacher_id
                }
                const modal = new bootstrap.Modal(document.getElementById('delete-course-modal'));
                modal.show()
            }
        </script>
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Tất cả các khóa học đang quản lý</h4>
                        <button
                            class="btn btn-primary btn-round ms-auto"
                            data-bs-toggle="modal"
                            id="open_add_modal">
                            <i class="fa fa-plus"></i>
                            Thêm khóa học
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <?php require_once __DIR__ . '/modals/add_modal.php' ?>

                        <table
                            id="courses-table"
                            class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="sorting">Tên khóa học</th>
                                    <th class="sorting">Giảng viên</th>
                                    <th class="sorting">Môn học</th>
                                    <th class="sorting">Ngày bắt đầu</th>
                                    <th class="sorting">Ngày kết thúc</th>
                                    <th style="width: 10%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($courses)) {
                                    foreach ($courses as $row) {
                                        $subject_name = 'Không xác định';
                                        foreach ($subjects as $subject) {
                                            if ($row['subject_id'] == $subject['id']) {
                                                $subject_name = $subject['name'];
                                            }
                                        }

                                        $teacher_name = 'Không xác định';
                                        foreach ($teachers as $teacher) {
                                            if ($row['teacher_id'] == $teacher['id']) {
                                                $teacher_name = $teacher['username'];
                                            }
                                        }

                                        echo '
                                <tr>
                                    <td><a class="btn btn-link" href="' . _WEB_ROOT . '/khoa-hoc/chi-tiet/' . $row['id'] . '" >' . $row['name'] . '</a></td>
                                    <td>' . $teacher_name . '</td>
                                    <td>' . $subject_name . '</td>
                                    <td>' . $row['start_date'] . '</td>
                                    <td>' . $row['end_date'] . '</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button
                                                type="button"
                                                data-bs-toggle="tooltip"
                                                class="btn btn-link btn-primary btn-lg"
                                                data-original-title="Edit course"
                                                data-course-id="' . $row['id'] . '"
                                                data-course-name="' . $row['name'] . '"
                                                data-course-description="' . $row['description'] . '"
                                                data-course-fee="' . $row['fee'] . '"
                                                onclick="openEditModal(this)"
                                                >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                type="button"
                                                data-bs-toggle="tooltip"
                                                class="btn btn-link btn-danger btn-lg"
                                                data-original-title="Delete course"
                                                data-course-id="' . $row['id'] . '"
                                                data-course-name="' . $row['name'] . '"
                                                data-subject-name="' . $subject_name . '"
                                                data-course-teacher-id="' . $row['teacher_id'] . '"
                                                onclick="openDeleteModal(this)"
                                                >
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                ';
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        $(document).ready(function() {
            // Add Row
            $("#courses-table").DataTable({
                pageLength: 5,
            });
        });

        function testButton(button, attr = 'data-course-id') {
            let user_id = button.getAttribute(attr)
            console.log("course id: " + user_id)
        }
    </script>
<?php else: ?>
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tất cả các khóa học</h4>
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
                                <?php foreach ($unregistered_courses as $course) {
                                    $teacher_name = 'Không xác định';
                                    foreach ($teachers as $teacher) {
                                        if ($course['teacher_id'] == $teacher['id']) {
                                            $teacher_name = $teacher['username'];
                                        }
                                    }
                                    $image_path = '/public/assets/images/software-engineering.jpg';
                                    if (isset($course['file_id'])) {
                                        $file_obj = $file_api->get_controller()->retrieve_file($course['file_id']);
                                        $image_path = $file_obj['file_path'];
                                    }
                                    $student_enrollments = $enrollment_api->get_controller()->get_course_enrollment_students($course['id']);
                                    echo '
                                        <div class="col-md-4 mb-4">
                                            <div class="position-relative overflow-hidden">
                                                <img class="img-fluid" src="' . _WEB_ROOT . $image_path . '" alt="default-image" style="object-fit:cover; width:100%">
                                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                                    <a href="' . _WEB_ROOT . '/khoa-hoc/chi-tiet/' . $course['id'] . '" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Tìm hiểu thêm</a>
                                                    <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 register-course-btn" data-course-id="' . $course['id'] . '" style="border-radius: 0 30px 30px 0;">Đăng ký ngay</a>
                                                </div>
                                            </div>
                                            <div class="text-center p-4 pb-0">
                                                <h3 class="mb-0">' . number_format($course['fee'], 0, '.', ',') . ' VNĐ</h3>
                                                ';
                                    $course_feed_backs = $feedback_api->get_controller()->get_coursefeed_backs($course['id']);
                                    if (!empty($course_feed_backs)) {
                                        $stars = 0;
                                        $sum = 0;
                                        foreach ($course_feed_backs as $feedback) {
                                            $sum += $feedback['rating'];
                                        }
                                        $total_rating = intdiv($sum, count($course_feed_backs));
                                        $remaining_rating = 5 - empty($course_feed_backs) ? $total_rating : 0;

                                        echo '
                                                    <div class="mb-3">
                                                    ';
                                        for ($i = 0; $i < $total_rating; $i++) {
                                            echo '<small class="fas fa-star star selected"></small>';
                                        }
                                        for ($j = 0; $j < $remaining_rating; $j++) {
                                            echo '<small class="fas fa-star star"></small>';
                                        }
                                        echo '
                                                    <small>(' . count($course_feed_backs) . ')</small>
                                                    </div>
                                                    ';
                                    } else {
                                        for ($j = 0; $j < 5; $j++) {
                                            echo '<small class="fas fa-star star"></small>';
                                        }
                                    }

                                    echo '  <h5 class="mb-4">' . $course['name'] . '</h5>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>' . $teacher_name . '</small>
                                                <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>' . count($student_enrollments) . ' Học viên</small>
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
                            foreach ($unregistered_courses as $course) {
                                if ($course['subject_id'] == $subject['id']) {
                                    array_push($filtered_course, $course);
                                }
                            }
                            foreach ($filtered_course as $course) {
                                $image_path = '/public/assets/images/software-engineering.jpg';
                                if (isset($course['file_id'])) {
                                    $file_obj = $file_api->get_controller()->retrieve_file($course['file_id']);
                                    $image_path = $file_obj['file_path'];
                                }
                                $student_enrollments = $enrollment_api->get_controller()->get_course_enrollment_students($course['id']);
                                echo '
                                    <div class="col-md-4 mb-4">
                                        <div class="position-relative overflow-hidden">
                                            <img class="img-fluid" src="' . _WEB_ROOT . $image_path . '" alt="default-image" style="object-fit:cover; width:100%">
                                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                                <a href="' . _WEB_ROOT . '/khoa-hoc/chi-tiet/' . $course['id'] . '" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Tìm hiểu thêm</a>
                                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 register-course-btn" data-course-id="' . $course['id'] . '" style="border-radius: 0 30px 30px 0;">Đăng ký ngay</a>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 pb-0">
                                            <h3 class="mb-0">' . number_format($course['fee'], 0, '.', ',') . ' VNĐ</h3>
                                            <div class="mb-3">
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small>(123)</small>
                                            </div>
                                            <h5 class="mb-4">' . $course['name'] . '</h5>
                                        </div>
                                        <div class="d-flex border-top">
                                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>' . $teacher_name . '</small>
                                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>' . count($student_enrollments) . ' Học viên</small>
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
<?php endif ?>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>"
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    const handleEnrollment = async (courseBtn) => {
        let url = 'app/apis/course_enrollment.php'
        let student_id = '<?php echo $this->get_user_id() ?>';
        let course_id = courseBtn.getAttribute('data-course-id')
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
            window.location.reload()
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
        document.querySelectorAll('.register-course-btn').forEach(button => button.addEventListener('click', (event) => handleEnrollment(event.target)))
    });
</script>