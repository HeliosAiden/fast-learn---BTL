<?php

class CourseEnrollment extends Controller
{
    public function __construct()
    {
        $this->__model = $this -> model('CourseEnrollmentModel');
    }

    public function create_course_enrollment() {
        $data = $this->getInput();
        if (!isset($data) && !isset($data['student_id']) && !isset($data['course_id'])) {
            $this -> errorResponse();
        }

        $course_enrollment_data = $this -> __model -> create_course_enrollment($data['student_id'], $data['course_id']);
        if ($course_enrollment_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Enroll course successfully',
                    'data' => $course_enrollment_data
                ]
            );
        } else {
            $this -> errorResponse('Something wen wrong', 500);
        }
    }

    public function get_all_course_enrollment() {
        return $this -> __model -> select_all();
    }
}