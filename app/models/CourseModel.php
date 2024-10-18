<?php
class CourseModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'courses';
        $this->init_table_id();
    }

    function create_course($name, $subject_id, $teacher_id, $description=null, $fee=0, $start_date=null, $end_date=null) {
        $data = [
            'name' => $name,
            'description' => $description,
            'fee' => $fee,
            'subject_id' => $subject_id,
            'teacher_id' => $teacher_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        return $this -> db -> insert($this->__table, $data);
    }

    function update_course($id, $teacher_id=null, $name=null, $description=null, $fee=null, $start_date=null, $end_date=null, $subject_id=null) {
        $data = [];
        if (isset($teacher_id)) {
            $data['teacher_id'] = $teacher_id;
        }
        if (isset($name)) {
            $data['name'] = $name;
        }
        if (isset($description)) {
            $data['description'] = $description;
        }
        if (isset($fee)) {
            $data['fee'] = $fee;
        }
        if (isset($start_date)) {
            $data['start_date'] = $start_date;
        }
        if (isset($end_date)) {
            $data['end_date'] = $end_date;
        }
        if (isset($subject_id)) {
            $data['subject_id'] = $subject_id;
        }
        $condition = [
            'id' => $id
        ];
        return $this -> db -> update($this -> __table, $data, $condition);
    }

    function delete_course($id) {
        return $this -> db -> delete($this -> __table, ['id' => $id]);
    }
}
