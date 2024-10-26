<?php

class Course extends Controller
{
    protected $__file_model = null;

    public function __construct()
    {
        $this->__model = $this->model('CourseModel');
        $this->__file_model = $this->model('FileModel');
    }

    public function index()
    {
        $all_courses = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Tất cả các khóa học hiện tại", $page_dir, ['all_courses' => $all_courses]);
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function list()
    {
        $all_courses = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Thông tin các khóa học hiện tại", $page_dir, ['all_courses' => $all_courses]);
        $role = $this->get_user_role();
        if ($role == 'Guest') {
            $this->render_layout('guest', $page_data);
            return $page_data;
        }
    }

    public function detail($id = '')
    {
        $all_courses = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $current_course = null;
        foreach ($all_courses as $course) {
            if ($course['id'] == $id) {
                $current_course = $course;
            }
        }
        $page_data = $this->get_page_data("Chi tiết khóa học.", $page_dir, ['all_courses' => $all_courses, 'current_course' => $current_course]);
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function registered()
    {
        $all_courses = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Khóa học của tôi.", $page_dir, ['all_courses' => $all_courses]);
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function get_course()
    {
        $data = $this->__model->select_all();
        if ($data) {
            $this->jsonResponse([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            $this->jsonResponse([
                'status' => 'success',
                'data' => []
            ]);
        }
    }

    public function create_course()
    {
        $data = $this->getInput();

        if (!empty($data)) {
            if (!$data || !isset($data['name']) || !isset($data['subject_id']) || !isset($data['teacher_id'])) {
                $this->errorResponse();
            }

            $course_data = $this->__model->create_course(
                $data['name'],
                $data['subject_id'],
                $data['teacher_id'],
                $data['description'],
                $data['fee'],
                $data['start_date'],
                $data['end_date'],
            );
            if ($course_data) {
                $this->jsonResponse(
                    [
                        'status' => 'success',
                        'message' => 'Course created successfully',
                        'data' => $course_data
                    ]
                );
            } else {
                $this->errorResponse('Create new course fail');
            }
        } else {
            if (!isset($_POST['name'])) {
                $this->errorResponse('Missing name');
            }
            if (!isset($_POST['teacher_id'])) {
                $this->errorResponse('Missing teacher ID');
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
            $course_data = $this->__model->create_course(
                $_POST['name'],
                $_POST['subject_id'],
                $_POST['teacher_id'],
                $_POST['description'] ?? '',
                $_POST['fee'] ?? 0,
                $_POST['start_date'] ?? null,
                $_POST['end_date'] ?? null,
                $file_id
            );
            if ($course_data) {
                $this->jsonResponse(
                    [
                        'status' => 'success',
                        'message' => 'Course created successfully'
                    ]
                );
            }
        }
    }

    public function update_course()
    {
        $data = $this->getInput();
        $id = $this->get_id_from_header();
        $user_id = '';
        if (!isset($data['teacher_id'])) {
            $user_id = $this->get_user_id();
            if (!isset($user_id)) {
                $this->errorResponse('No user ID found');
            }
        } else {
            $user_id = $data['teacher_id'];
        }

        $course_data = $this->__model->update_course($id, $user_id, $data['name'], $data['description'], $data['fee']);
        if ($course_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Subject edit successfully',
                    'data' => $course_data
                ]
            );
        }
    }

    public function delete_course()
    {
        $id = $this->get_id_from_header();

        $course_data = $this->__model->delete_course($id);
        if ($course_data) {
            $this->jsonResponse(
                [
                    'status' => 'success',
                    'message' => 'Delete subject successfully',
                    'data' => $course_data
                ]
            );
        } else {
            $this->errorResponse();
        }
    }

    public function get_all_courses()
    {
        return $this->__model->select_all();
    }
}
