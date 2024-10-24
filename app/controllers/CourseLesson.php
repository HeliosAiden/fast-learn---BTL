<?php

class CourseLesson extends Controller
{

    protected $__file_model = null;

    public function __construct()
    {
        $this->__model = $this->model('CourseLessonModel');
        $this->__file_model = $this->model('FileModel');
    }

    public function create_course_lesson()
    {
        $data = $this -> getInput();


        $lessons = $this->__model->select_condition(['course_id' => empty($data) ? $_POST['course_id'] : $data['course_id']]);
        $index = count($lessons == null ? [] : $lessons) + 1;

        if (!empty($data)) {
            $course_lesson_id = $this->__model->create_course_lesson($data['name'], $data['course_id'], $index, null, $data['video_url'], $data['description'] ?? '');
            if ($course_lesson_id) {
                $course_lesson_data = [
                    'video_url' => $data['video_url'],
                    'name' => $data['name'],
                    'course_id' => $data['course_id'],
                    'description' => $data['description'],
                ];
                $this->jsonResponse(
                    [
                        'status' => 'success',
                        'message' => 'Course created successfully',
                        'data' => $course_lesson_data
                    ]
                );
            } else {
                $this->errorResponse('Create new course lesson fail');
            }
        } else {

            if (!isset($_POST['name'])) {
                $this->errorResponse('Missing name');
            }
            if (!isset($_POST['course_id'])) {
                $this->errorResponse('Missing course ID');
            }
            $user_id = $this->get_user_id();
            if (!isset($user_id)) {
                $this->errorResponse('Can not get user ID');
            }

            // Missing $name, $file_path, $file_type, $file_size
            $file_data = $this->createFile();
            if (!isset($file_data)) {
                $this->errorResponse('Can not store file in filesystem');
            }
            if (!isset($file_data['file_name']) || !isset($file_data['file_path']) || !isset($file_data['file_size']) || !isset($file_data['file_type'])) {
                $this->errorResponse();
            }

            $file_id = $this->__file_model->create_file($user_id, $file_data['file_name'], $file_data['file_path'], $file_data['file_type'], $file_data['file_size']);

            if (!isset($file_id)) {
                $this->errorResponse('Can not recognize the file ID');
            }

            $course_lesson_id = $this->__model->create_course_lesson($_POST['name'], $_POST['course_id'], $index, $file_id, null, $data['description'] ?? '');
            if ($course_lesson_id) {
                $course_lesson_data = [
                    'file_id' => $file_id,
                    'name' => $_POST['name'],
                    'course_id' => $_POST['course_id'],
                    'description' => $_POST['description'],
                ];
                $this->jsonResponse(
                    [
                        'status' => 'success',
                        'message' => 'Course created successfully',
                        'data' => $course_lesson_data
                    ]
                );
            } else {
                $this->errorResponse('Create new course lesson fail');
            }
        }
    }
}
