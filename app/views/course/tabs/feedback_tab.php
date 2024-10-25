<?php
$course_feedback_api = new API('CourseFeedback');
$student_feedback_api = $teacher_api = new Api('User');
$all_course_feedbacks = $course_feedback_api->get_controller()->get_all_course_feedbacks();

$user_course_feedback = $course_feedback_api->get_controller()->get_course_feedback_from_user($current_course['id']);

$students = $student_feedback_api->get_controller()->get_users_with_condition(['role' => 'Student'], ['id', 'username', 'email', 'state'], ['state' => 'Removed']);
// echo '<pre>';
// print_r($all_course_feedbacks);
// echo '</pre>';
$user_id = $this->get_user_id();
$students_course_feedbacks = array_filter($all_course_feedbacks, function ($feedback) use ($user_id) {
    return $feedback['student_id'] !== $user_id;
});

$students_course_feedbacks = array_slice($students_course_feedbacks, 0, 5)

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
<div class="tab-pane fade" id="feedback-tab" role="tabpanel" aria-labelledby="li-feedback-tab">
    <div class="card-body">
        <div class="row mt-3">
            <?php if ($this->get_user_role() == 'Student'): ?>
                <h4 class="mb-2">Đánh giá của tôi</h4>
                <?php if (isset($user_course_feedback)): ?>
                    <div class="card position-relative text-left p-5 border rounded-3" style="max-width: 96%; margin: auto 2%;">
                        <blockquote>"<?php echo $user_course_feedback['feedback'] ?>"</blockquote>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mt-1 fw-normal"><?php echo $this->get_user_name() ?></h5>
                            </div>
                            <div class="col-md-6">
                                <div class="star-rating" style="float: right;">
                                    <?php
                                    $max_rating = 5;
                                    $current_rating = $user_course_feedback['rating'];
                                    $remaining_rating = $max_rating - $current_rating;

                                    for ($i = 1; $i <= $current_rating; $i++) {
                                        echo '<i class="fas fa-star star selected" data-value="' . $i . '"></i>';
                                    }
                                    for ($i = 1; $i <= $remaining_rating; $i++) {
                                        echo '<i class="fas fa-star star" data-value="' . $current_rating + $i . '"></i>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label for="rating">Chất lượng khóa học:</label>
                            <div class="star-rating">
                                <!-- Hidden input to store the actual rating value -->
                                <input type="hidden" name="rating" id="rating" value="0" required>

                                <!-- Star icons -->
                                <i class="fas fa-star star user-select" data-value="1"></i>
                                <i class="fas fa-star star user-select" data-value="2"></i>
                                <i class="fas fa-star star user-select" data-value="3"></i>
                                <i class="fas fa-star star user-select" data-value="4"></i>
                                <i class="fas fa-star star user-select" data-value="5"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label for="feedback">Phản hồi về khóa học:</label>
                            <textarea name="feedback" id="feedback" rows="4" required style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-2 mb-3">
                        <button id="save_user_feedback" class="btn btn-success" disabled>Đánh giá</button>
                    </div>
                <?php endif ?>
            <?php endif ?>
            <h4 class="mb-3">Đánh giá của khóa học</h4>
            <?php foreach ($students_course_feedbacks as $feedback) {
                $student_username = 'Không xác định';
                foreach ($students as $student) {
                    if ($student['id'] == $feedback['student_id']) {
                        $student_username = $student['username'];
                    }
                }
                echo '
                <div class="card position-relative text-left p-5 border rounded-3 mb-3" style="max-width: 96%; margin: auto 2%;">
        <blockquote>"' . $feedback['feedback'] . '"</blockquote>
        <div class="row">
            <div class="col-md-6">
                <h5 class="mt-1 fw-normal">' . $student_username . '</h5>
            </div>
            <div class="col-md-6">
                <div class="star-rating" style="float: right;">
                    ';
                $max_rating = 5;
                $current_rating = $feedback['rating'];
                $remaining_rating = $max_rating - $current_rating;

                for ($i = 1; $i <= $current_rating; $i++) {
                    echo '<i class="fas fa-star star selected" data-value="' . $i . '"></i>';
                }
                for ($i = 1; $i <= $remaining_rating; $i++) {
                    echo '<i class="fas fa-star star" data-value="' . $current_rating + $i . '"></i>';
                }
                echo '
                </div>
            </div>
        </div>
    </div>
            ';
            } ?>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>"
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    // Handle star rating click event
    document.querySelectorAll('.star-rating .star.user-select').forEach(star => {
        star.addEventListener('click', function() {
            const ratingValue = this.getAttribute('data-value');

            // Set the hidden rating input value
            document.getElementById('rating').value = ratingValue;

            // Highlight the selected stars
            document.querySelectorAll('.star-rating .star.user-select').forEach(s => {

                s.classList.remove('selected');
                if (s.getAttribute('data-value') <= ratingValue) {
                    s.classList.add('selected');
                }
            });
        });
    });

    function checkActiveRatingButton() {
        let rating = document.getElementById('rating').value
        let feedback = document.getElementById('feedback').value

        if (rating !== 0 || feedback !== '') {
            document.getElementById('save_user_feedback').disabled = false;
        }
    }

    const handleSendUserRating = async () => {
        let rating = document.getElementById('rating').value
        let feedback = document.getElementById('feedback').value
        let course_id = '<?php echo $current_course['id'] ?>'

        let data = {
            'rating': rating,
            'feedback': feedback,
            'course_id': course_id
        }

        let url = 'app/apis/course_feedback.php'
        const response = await httpMixin.postMixin(url, data)
        if (response.status == 'success') {
            swal({
                title: "Đánh giá khóa học thành công!",
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
            swal(response.message ?? "Đánh giá khóa học thất bại!", {
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
        document.getElementById('rating').addEventListener('change', checkActiveRatingButton)
        document.getElementById('feedback').addEventListener('input', checkActiveRatingButton)
        document.getElementById('save_user_feedback').addEventListener('click', handleSendUserRating)
    });
</script>