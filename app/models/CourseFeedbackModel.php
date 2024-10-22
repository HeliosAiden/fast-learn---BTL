<?php
class CourseFeedbackModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'course_feedbacks';
        $this->init_table_id();
    }

    public function create_course_feedback($student_id, $course_id, $feedback = '', $rating = 0) {
        $data = [
            'student_id' => $student_id,
            'course_id' => $course_id,
            'feedback' => $feedback,
            'rating' => $rating,
        ];
        return $this -> db -> insert($this->__table, $data);
    }
}