<?php
class CourseEnrollmentModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'course_enrollments';
        $this->init_table_id();
    }

    public function create_course_enrollment($student_id, $course_id) {
        $data = ['student_id' => $student_id, 'course_id' => $course_id];
        return $this -> db -> insert($this->__table, $data);
    }
}