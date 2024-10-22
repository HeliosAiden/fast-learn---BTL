<?php
$course_feedback_api = new API('CourseFeedback');
$all_course_feedbacks = $course_feedback_api->get_controller()->get_all_course_feedbacks();

$user_course_feedback = $course_feedback_api->get_controller()->get_course_feedback_from_user($current_course['id']);

?>
<div class="tab-pane fade" id="feedback-tab" role="tabpanel" aria-labelledby="li-feedback-tab">
    <div class="card-body">
        <div class="row mt-3">
            <div class="form-group">
                <label for="rating">Đánh giá khóa học (1-5):</label>
                <select name="rating" id="rating" required>
                    <option value="">Đánh giá khóa học</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

        </div>

        <!--
If user doesn't have feedback
then display a feedback form at the top of the tab
else display user's feedback

// Display feedback tables

-->
    </div>
</div>