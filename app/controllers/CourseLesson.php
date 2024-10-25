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
        $data = $this->getInput();

        $lessons = $this->__model->select_condition(['course_id' => empty($data) ? $_POST['course_id'] : $data['course_id']]);
        $index = count($lessons == null ? [] : $lessons) + 1; // TODO: cái này cần update, có thể gặp lỗi nếu chỉ mục ko tuần tự

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
                        'message' => 'Course lesson created successfully',
                        'data' => $course_lesson_data
                    ]
                );
            } else {
                $this->errorResponse('Create new course lesson fail');
            }
        }
    }

    public function update_course_lesson()
    {
        $course_lesson_id = $this->get_id_from_header();
        $data = $this->getInput();
        $row = $this->__model->update_course_lesson($course_lesson_id, $data['name'] ?? '', $data['description'] ?? '', $data['index'] ?? null);
        if ($row) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Course lesson updated successfully',
                ]
            );
        } else {
            $this->errorResponse('Update course lesson fail');
        }
    }

    public function delete_course_lesson()
    {
        $course_lesson_id = $this->get_id_from_header();
        // Does this course have file_id ?
        $file_id = $this -> check_for_file_id($course_lesson_id);
        if (isset($file_id)) {
            $file_data = $this -> __file_model -> get_file_with_condition(['id' => $file_id]);
            if (isset($file_data)) {
                $this -> deleteFile($file_data['file_path']);
            }
            $this -> __file_model -> delete_file($file_id);
        }

        $row = $this->__model->delete_course_lesson($course_lesson_id);
        if ($row) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Course lesson deleted successfully',
                ]
            );
        } else {
            $this->errorResponse('Update course lesson fail');
        }
    }

    protected function check_for_file_id($id) {
        $row = $this -> __model -> select_condition(['id' => $id]);
        if (!empty($row)) {
            $selected_lesson = $row[0];
            if (isset($selected_lesson['file_id'])) {
                return $selected_lesson['file_id'];
            }
        }
        return null;
    }

    protected function delete_file($id) {
        $row = $this -> __file_model -> delete_file($id);
        if (!isset($row)) {
            $this->errorResponse('Delete file record fail');
        }
    }


    public function get_lessons($course_id)
    {
        return $this->__model->select_condition(['course_id' => $course_id]);
    }
}
