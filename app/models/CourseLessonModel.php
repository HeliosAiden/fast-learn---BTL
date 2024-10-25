<?php

class CourseLessonModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'course_lessons';
        $this->init_table_id();
    }

    function create_course_lesson($name, $course_id, $lesson_index, $file_id = null, $video_url = null, $description = '')
    {
        $data = [
            'name' => $name,
            'course_id' => $course_id,
            'lesson_index' => $lesson_index,
        ];
        if (isset($file_id)) {
            $data['file_id'] = $file_id;
        }
        if (isset($video_url)) {
            $data['video_url'] = $video_url;
        }
        if (isset($description)) {
            $data['description'] = $description;
        }
        return $this->db->insert($this->__table, $data);
    }

    function update_course_lesson($id, $name = '', $description = '', $index = null)
    {
        $condition = ['id' => $id];
        $data = [];
        if (isset($name)) {
            $data['name'] = $name;
        }
        if (isset($description)) {
            $data['description'] = $description;
        }
        if (isset($index)) {
            $data['index'] = $index;
        }
        return $this->db->update($this->__table, $data, $condition);
    }

    function delete_course_lesson($id)
    {
        return $this->db->delete($this->__table, ['id' => $id]);
    }
}
