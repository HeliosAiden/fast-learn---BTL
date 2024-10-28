<?php

// If $user_role == 'Student' -> display all lesson related to $current_course
// If $user_role == 'Teacher' -> display all lesson related to $current_course as table and allow create new course
// If $user_role == 'Admin' -> display all lesson related to $current_course as table and not allow to create new course

?>

<?php
$lesson_api = new Api('CourseLesson');
$file_api = new Api('File');
$lessons = $lesson_api->get_controller()->get_lessons($current_course['id']);

?>
<style>
    .mfp-container {
        display: flex;
        justify-content: center;
        align-items: center;

        .mfp-close {
            color: white !important;
        }
    }
</style>
<div class="tab-pane fade" id="lesson-tab" role="tabpanel" aria-labelledby="li-lesson-tab">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <?php if ($this->get_user_role() == 'Student'): ?>
                <h4 class="card-title">Danh sách các bài học</h4>
            <?php else: ?>
                <h4 class="card-title">Các bài học đang quản lý</h4>
            <?php endif ?>
            <?php if ($this->get_user_role() == 'Teacher'): ?>
                <button
                    class="btn btn-primary btn-round ms-auto"
                    data-bs-toggle="modal"
                    id="open_add_lesson_modal">
                    <i class="fa fa-plus"></i>
                    Thêm bài học
                </button>
            <?php endif ?>
        </div>
    </div>
    <div class="card-body">
        <?php if ($this->get_user_role() == 'Student'): ?>
            <div class="row">
                <div class="col col-md-2">
                    <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd" id="lesson-tab-content-btn-group" role="tablist" aria-orientation="vertical">
                        <?php
                        if (!empty($lessons)) {
                            usort($lessons, function ($a, $b) {
                                return $a['lesson_index'] <=> $b['lesson_index'];
                            });
                            foreach ($lessons as $index => $lesson) {
                                echo '<a ';
                                echo 'class="nav-link';
                                if ($index == 0) {
                                    echo ' active';
                                } else {
                                    echo '';
                                }
                                echo '" ';
                                echo 'id="btn-lesson-index-' . $lesson['lesson_index'] . '" ';
                                echo 'data-bs-toggle="pill" ';
                                echo 'role="tab" ';
                                echo 'href="#tab-lesson-index-' . $lesson['lesson_index'] . '" ';
                                echo 'aria-controls="tab-lesson-index-' . $lesson['lesson_index'] . '" ';
                                echo '>';
                                echo 'Bài số ' . $lesson['lesson_index'];
                                echo '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col col-md-10" style="border-left: 1px solid #6861ce">
                    <div class="tab-content" id="lesson-tab-content">
                        <?php
                        if (!empty($lessons)) {
                            foreach ($lessons as $index => $lesson) {
                                echo '<div ';
                                echo 'class="tab-pane fade ';
                                if ($index == 0) {
                                    echo 'active show"';
                                } else {
                                    echo '"';
                                }
                                echo 'id="tab-lesson-index-' . $lesson['lesson_index'] . '" ';
                                echo 'role="tabpanel" ';
                                echo 'aria-labelledby="btn-lesson-index-' . $lesson['lesson_index'] . '"';
                                echo '>';
                                echo '<h5>' . $lesson['name'] . '</h5>';
                                if ($lesson['description']) {
                                    echo '<p class="my-2">' . $lesson['description'] . '</p>';
                                }
                                if (isset($lesson['video_url'])) {
                                    echo '
                                    <iframe width="720" height="400" src="' . $lesson['video_url'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>
                                ';
                                }
                                if (isset($lesson['file_id'])) {
                                    $file_obj = $file_api->get_controller()->retrieve_file($lesson['file_id']);
                                    switch ($file_obj['file_type']) {
                                        case 'video/mp4':
                                            $file_type = 'video';
                                            break;
                                        default:
                                            break;
                                    }
                                    echo '<video controls width="720">
                                            <source src="' . _WEB_ROOT . $file_obj['file_path'] . '" type="' . $file_obj['file_type'] . '">
                                            Your browser does not support the video tag.
                                        </video>';
                                }


                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($this->get_user_role() == 'Teacher'): ?>
            <?php require_once __DIR__ . '/../modals/add_lesson_modal.php' ?>

            <!-- Edit Lesson modal -->
            <?php require_once __DIR__ . '/../modals/edit_lesson_modal.php' ?>
            <script>
                function openEditModal(button) {
                    let lesson_id = button.getAttribute('data-lesson-id')
                    let lesson_name = button.getAttribute('data-lesson-name')
                    let lesson_description = button.getAttribute('data-lesson-description')
                    let lesson_index = button.getAttribute('data-lesson-index')
                    document.getElementById('edit-modal-value').value = lesson_id
                    document.getElementById('edit_lesson_name').value = lesson_name
                    document.getElementById('edit_lesson_description').value = lesson_description
                    document.getElementById('edit_lesson_index').value = lesson_index

                    const modal = new bootstrap.Modal(document.getElementById('edit-lesson-modal'));
                    modal.show()
                }
            </script>

            <?php require_once __DIR__ . '/../modals/remove_lesson_modal.php' ?>

            <!-- Delete Lesson modal -->
            <script>
                function openDeleteModal(button) {
                    let lesson_id = button.getAttribute('data-lesson-id')
                    document.getElementById('delete-lesson-id').value = lesson_id
                    const modal = new bootstrap.Modal(document.getElementById('delete-lesson-modal'));
                    modal.show()
                }
            </script>

            <div class="table-responsive">
                <table id="lesson-table" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">Số thứ tự</th>
                            <th class="sorting">Tiêu đề</th>
                            <th class="sorting">Content</th>
                            <th style="width: 10%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($lessons)) {
                            foreach ($lessons as $lesson) {
                                echo '
                                <tr>
                                    <td>' . $lesson['lesson_index'] . '</td>
                                    <td>' . $lesson['name'] . '</td>
                                    <td>';
                                if (isset($lesson['file_id'])) {
                                    $file_type = '';
                                    $file_obj = $file_api->get_controller()->retrieve_file($lesson['file_id']);
                                    switch ($file_obj['file_type']) {
                                        case 'video/mp4':
                                            $file_type = 'video';
                                            break;
                                        default:
                                            break;
                                    }
                                    echo '
                                    <a data-file-type="' . $file_type . '" href="' . _WEB_ROOT . $file_obj['file_path'] . '" class="btn btn-link video-popup">
                                        <span class="btn-label">
                                            <i class="fa fa-link"></i>
                                        </span>
                                        <span>' . $file_obj['file_name'] . '</span>
                                    </a>
                                    ';
                                }
                                if (isset($lesson['video_url'])) {
                                    echo '
                                    <a href="' . $lesson['video_url'] . '" class="btn btn-link " target="blank">
                                        <span class="btn-label">
                                            <i class="fa fa-link"></i>
                                        </span>
                                        <span>Video link</span>
                                    </a>
                                ';
                                }
                                echo '</td>
                                <td style="width:10%">
                                    <div class="form-button-action" style="float:right">
                                        <button
                                            type="button"
                                            data-bs-toggle="tooltip"
                                            class="btn btn-link btn-primary btn-lg"
                                            data-original-title="Edit lesson"
                                            data-lesson-id="' . $lesson['id'] . '"
                                            data-lesson-name="' . $lesson['name'] . '"
                                            data-lesson-index="' . $lesson['lesson_index'] . '"
                                            data-lesson-description="' . $lesson['description'] . '"
                                            onclick="openEditModal(this)"
                                            >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            type="button"
                                            data-bs-toggle="tooltip"
                                            class="btn btn-link btn-danger btn-lg"
                                            data-original-title="Remove lesson"
                                            data-lesson-id="' . $lesson['id'] . '"
                                            onclick="openDeleteModal(this)"
                                            >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                                </tr>
                            ';
                            }
                        } ?>
                    </tbody>
                </table>
            </div>

        <?php endif ?>
        <?php if ($this->get_user_role() == 'Admin'): ?>
            <div class="table-responsive">
                <table id="lesson-table" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">Số thứ tự</th>
                            <th class="sorting">Tiêu đề</th>
                            <th class="sorting">Content</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($lessons)) {
                            foreach ($lessons as $lesson) {
                                echo '
                                <tr>
                                    <td>' . $lesson['lesson_index'] . '</td>
                                    <td>' . $lesson['name'] . '</td>
                                    <td>';
                                if (isset($lesson['file_id'])) {
                                    $file_type = '';
                                    $file_obj = $file_api->get_controller()->retrieve_file($lesson['file_id']);
                                    switch ($file_obj['file_type']) {
                                        case 'video/mp4':
                                            $file_type = 'video';
                                            break;
                                        default:
                                            break;
                                    }
                                    echo '
                                    <a data-file-type="' . $file_type . '" href="' . _WEB_ROOT . $file_obj['file_path'] . '" class="btn btn-link video-popup">
                                        <span class="btn-label">
                                            <i class="fa fa-link"></i>
                                        </span>
                                        <span>' . $file_obj['file_name'] . '</span>
                                    </a>
                                        ';
                                }
                                if (isset($lesson['video_url'])) {
                                    echo '
                                    <a href="' . $lesson['video_url'] . '" class="btn btn-link " target="blank">
                                        <span class="btn-label">
                                            <i class="fa fa-link"></i>
                                        </span>
                                        <span>Video link</span>
                                    </a>
                                ';
                                }
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </div>
</div>
<script>
    $('.video-popup').on('click', function(e) {
        e.preventDefault(); // Prevent the default link action

        // Get the URL from the href attribute
        const fileUrl = $(this).attr('href');
        const fileType = $(this).attr('data-file-type');
        let fileContent;

        if (fileType == 'video') {
            // External video (YouTube or Vimeo), use iframe
            fileContent = `<iframe width="1280" height="720" src="${fileUrl}" frameborder="0" allowfullscreen style="position: relative; left: 10vw"></iframe>`;
        }

        // Open Magnific Popup with the video content
        $.magnificPopup.open({
            items: {
                src: `<div class="mfp-video">${fileContent}</div>`,
                type: 'inline'
            },
            closeBtnInside: true
        });
    });
    $(document).ready(function() {
        // Add Row
        $("#lesson-table").DataTable({
            pageLength: 5,
        });
    });
</script>