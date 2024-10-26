<?php
if ($this->get_user_role() == 'Admin') {
}
?>

<!-- Edit Course Modal -->
<div class="modal" id="edit-course-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa khóa học</h5>
                <button type="button" class="btn-close close-edit-modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_course_id">
                <!-- Course Name (Required) -->
                <div class="mb-3">
                    <label for="edit_course_name" class="form-label">Tên khóa học<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_course_name" name="edit_course_name" required>
                    <div class="invalid-feedback">
                        tên khóa học
                    </div>
                </div>

                <!-- Course Description (Optional) -->
                <div class="mb-3">
                    <label for="edit_course_description" class="form-label">Mô tả khóa học</label>
                    <textarea class="form-control" id="edit_course_description" name="edit_course_description" rows="8"></textarea>
                </div>

                <!-- Course Fee (Optional) -->
                <div class="mb-3">
                    <label for="edit_course_fee" class="form-label">Học phí</label>
                    <input type="number" class="form-control" id="edit_course_fee" name="edit_course_fee" step="0.01" min="0">
                </div>

                <?php if ($this->get_user_role() == 'Admin') : ?>
                    <!-- Teacher ID (Required) -->
                    <div class="mb-3">
                        <label for="course_edit_teacher_id" class="form-label">Giáo viên đứng lớp<span class="text-danger">*</span></label>
                        <select class="form-select" id="course_edit_teacher_id" name="course_edit_teacher_id" required>
                        </select>
                    </div>
                <?php endif ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-edit-modal">Đóng</button>
                <button type="button" id='edit_course_btn' class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </div>
    </div>
    <script type="module">
        import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
        let teachers = []

        if (document.getElementById("course_edit_teacher_id")) {

            let userUrl = 'app/apis/user.php'
            let userResponse = await httpMixin.getMixin(userUrl)
            let users = userResponse.data

            users.forEach(user => {
                if (user.role == 'Teacher' && user.state == 'Active') {
                    teachers.push(user)
                }
            })

            let selectTeacherElement = document.getElementById('course_edit_teacher_id')
            teachers.forEach((teacher, index) => {
                let label = teacher.username
                let value = teacher.id
                let option = document.createElement('option')
                let id = `teacher-${index+1}`
                option.id = id
                option.value = value
                option.innerHTML = label
                
                if (!selectTeacherElement.querySelector(`#${id}`)) {
                    selectTeacherElement.appendChild(option)
                }
            })
        }

        // ** Edit Modal Form ** //

        function closeEditModal() {
            var editModal = bootstrap.Modal.getInstance(document.getElementById("edit-course-modal"));
            editModal.hide();
        }

        const submitEditSubject = async () => {
            let id = document.getElementById('edit_course_id').value;
            let name = document.getElementById('edit_course_name').value;
            let description = document.getElementById('edit_course_description').value;
            let fee = document.getElementById('edit_course_fee').value;

            var data = {
                name: name,
                description: description,
                fee: fee,
            };

            if (document.getElementById("course_edit_teacher_id")) {
                let teacher_id = document.getElementById("course_edit_teacher_id").value;
                data['teacher_id'] = teacher_id
            }

            let endpoint = 'app/apis/course.php'
            const response = await httpMixin.putMixin(endpoint, data, id)

            if (response.status == 'success') {
                swal({
                    title: "Lưu thay đổi môn học thành công!",
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
                closeEditModal()
                window.location.reload()
            } else {
                swal(response.message ?? "Lưu thay đổi môn học thất bại!", {
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

        document.querySelectorAll('.close-edit-modal').forEach(btn => {
            btn.addEventListener('click', closeEditModal)
        })
        document.getElementById('edit_course_btn').addEventListener('click', () => {
            submitEditSubject()
        })
    </script>
</div>