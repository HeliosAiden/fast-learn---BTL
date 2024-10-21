<?php

// If $role == 'Admin' show full course table
// If $role !== 'Admin' && $role == 'Student' || 'Teacher'
// show $courses

class Course extends Controller
{
    public function __construct()
    {
        $this->__model = $this->model('CourseModel');
    }

    public function index()
    {
        $all_courses = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Tất cả các khóa học hiện tại", $page_dir, ['all_courses' => $all_courses]);
        $this->render_layout('admin', $page_data);
        return $page_data;
    }

    public function detail($id = '') {
        $all_courses = $this->__model->select_all();
        $page_dir = $this->get_page_dir(__FUNCTION__);
        $page_data = $this->get_page_data("Chi tiết khóa học.", $page_dir, ['all_courses' => $all_courses]);
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
    }

    public function update_course() {
        $data = $this->getInput();
        $id = $this -> get_id_from_header();
        $user_id = $this->get_user_id();
        if (!isset($user_id)) {
            $this->errorResponse('No user id');
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

    public function delete_course() {
        $id = $this -> get_id_from_header();

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

    public function get_all_courses() {
        return $this -> __model -> select_all();
    }
}
