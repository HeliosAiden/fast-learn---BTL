<?php

// If $user_role == 'Student' -> display all lesson related to $current_course
// If $user_role == 'Teacher' -> display all lesson related to $current_course as table and allow create new course
// If $user_role == 'Admin' -> display all lesson related to $current_course as table and not allow to create new course

?>

<div class="tab-pane fade" id="lesson-tab" role="tabpanel" aria-labelledby="li-lesson-tab">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Các bài học đang quản lý</h4>
            <button
                class="btn btn-primary btn-round ms-auto"
                data-bs-toggle="modal"
                id="open_add_lesson_modal">
                <i class="fa fa-plus"></i>
                Thêm bài học
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if ($this->get_user_role() == 'Student'): ?>

        <?php endif ?>
        <?php if ($this->get_user_role() == 'Teacher'): ?>

            <?php require_once __DIR__ . '/../modals/add_lesson_modal.php' ?>

            <div class="table-responsive">
                <table id="lesson-table" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">Số thứ tự</th>
                            <th class="sorting">Tiêu đề</th>
                            <th class="sorting">Video</th>
                            <th style="width: 10%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="embed-responsive embed-responsive-16by9">
                <video class="embed-responsive-item" controls>
                    <source src="<?php echo _WEB_ROOT ?>/app/uploads/videos/1729751270_y2mate.com - C in 100 Seconds_720pHF.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endif ?>
        <?php if ($this->get_user_role() == 'Admin'): ?>

        <?php endif ?>
    </div>
</div>