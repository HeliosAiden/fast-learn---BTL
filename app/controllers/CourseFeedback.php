<?php

class CourseFeedback extends Controller
{
    public function __construct()
    {
        $this->__model = $this -> model('CourseFeedbackModel');
    }

    public function create_course_feedback() {
        $data = $this->getInput();
        $user_id = $this -> get_user_id();
        if (!$data || !isset($data['course_id'])) {
            $this->errorResponse();
        }
        $course_feedback = $this -> __model -> create_course_feedback(
            $user_id,
            $data['course_id'],
            $data['feedback'] ?? '',
            $data['rating'] ?? 0
        );
        if ($course_feedback) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Course feedback created successfully',
                    'data' => $course_feedback
                ]
            );
        } else {
            $this->errorResponse('Create course feedback fail');
        }
    }

    public function get_all_course_feedbacks() {
        return $this -> __model -> select_all();
    }

    public function get_course_feedback_from_user($current_course_id) {
        $student_id = $this -> get_user_id();
        $condition = [
            'student_id' => $student_id,
            'course_id' => $current_course_id
        ];
        $response = $this -> __model -> select_condition($condition);
        if (!empty($response)) {
            return $response[0];
        }
    }

    public function get_course_feedbacks($course_id) {
        return $this -> __model -> select_condition(['course_id' => $course_id]);
    }
}