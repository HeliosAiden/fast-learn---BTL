<!-- Edit Lesson Modal -->
<div class="modal" id="edit-lesson-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa bài học</h5>
                <button type="button" class="btn-close close-edit-modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-modal-value">
                <div class="mb-3">
                    <label for="edit_lesson_name" class="form-label">Tên bài học<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_lesson_name" name="edit_lesson_name" required>
                    <div class="invalid-feedback">
                        tên bài học
                    </div>
                </div>
                <div class="mb-3">
                    <label for="edit_lesson_description" class="form-label">Mô tả bài học</label>
                    <textarea class="form-control" id="edit_lesson_description" name="edit_lesson_description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="edit_lesson_index" class="form-label">Số thứ tự bài học<span class="text-danger">*</span></label>
                    <input class="form-control" id="edit_lesson_index" name="edit_lesson_index"></input>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-edit-modal">Đóng</button>
                <button type="button" id='edit_course_btn' class="btn btn-success">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>"
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    const closeEditLessonModal = () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('edit-lesson-modal'));
        modal.hide()
    }

    const handleChangeLesson = async () => {
        let name = document.getElementById("edit_lesson_name").value
        let description = document.getElementById("edit_lesson_description").value
        let index = document.getElementById("edit_lesson_index").value
        let id = document.getElementById("edit-modal-value").value

        let url = '/app/apis/course_lesson.php'

        let data = {
            name: name,
            description: description,
            index: index
        }

        const response = await httpMixin.patchMixin(url, data, id)
        if (response.status == 'success') {
            swal({
                title: "Cập nhật bài học thành công!",
                icon: "success",
                buttons: {
                    confirm: {
                        text: "Xác nhận",
                        value: true,
                        visible: true,
                        className: "btn btn-success",
                        closeModal: true,
                    },
                },
            });
            closeEditLessonModal()
            window.location.reload()
        } else {
            swal(response.message ?? "Cập nhật bài học thất bại!", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                        closeModal: true,
                        visible: true
                    },
                },
            });
        }
    }


    $(document).ready(function() {
        document.querySelectorAll('.close-edit-modal').forEach(btn => {
            btn.addEventListener('click', closeEditLessonModal)
        })
        document.getElementById('edit_course_btn').addEventListener('click', () => {
            handleChangeLesson()
        })
    })
</script>