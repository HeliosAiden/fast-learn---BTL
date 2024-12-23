<!-- Add Course Modal -->
<div class="modal" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm khóa học</h5>
                <button type="button" class="btn-close close_add_modal"></button>
            </div>
            <div class="modal-body">
                <!-- Course Name (Required) -->
                <div class="mb-3">
                    <label for="course_add_name" class="form-label">Tên khóa học<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="course_add_name" name="course_add_name" required>
                    <div class="invalid-feedback">
                        Vui lòng cung cấp tên khóa học
                    </div>
                </div>

                <!-- Course Description (Optional) -->
                <div class="mb-3">
                    <label for="course_add_description" class="form-label">Mô tả khóa học</label>
                    <textarea class="form-control" id="course_add_description" name="course_add_description" rows="3"></textarea>
                </div>

                <!-- Course Fee (Optional) -->
                <div class="mb-3">
                    <label for="course_add_fee" class="form-label">Học phí</label>
                    <input type="number" class="form-control" id="course_add_fee" name="course_add_fee" step="0.01" min="0">
                </div>

                <!-- Teacher ID (Required) -->
                <div class="mb-3">
                    <label for="course_add_teacher_id" class="form-label">Giáo viên đứng lớp<span class="text-danger">*</span></label>
                    <select class="form-select" id="course_add_teacher_id" name="course_add_teacher_id" required>
                        <option value="" disabled selected>Chỉ định 1 giáo viên</option>
                    </select>
                </div>

                <!-- Subject ID (Required) -->
                <div class="mb-3">
                    <label for="course_add_subject_id" class="form-label">Môn học <span class="text-danger">*</span></label>
                    <select class="form-select" id="course_add_subject_id" name="course_add_subject_id" required>
                        <option value="" disabled selected>Chọn 1 môn học</option>

                    </select>
                </div>
                <div class="row mb-3">

                    <!-- Start Date (Optional) -->
                    <div class="col-md-6">
                        <label for="course_add_start_date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="course_add_start_date" name="course_add_start_date">
                    </div>

                    <!-- End Date (Optional) -->
                    <div class="col-md-6">
                        <label for="course_add_end_date" class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="course_add_end_date" name="course_add_end_date">
                    </div>
                </div>
                <div class="mb-3">
                    <div id="uploadInput" class="input-group mt-2">
                        <input type="file" class="form-control" id="imageUpload" accept="image/*" style="display: none;">
                        <label for="uploadImg" id="uploadBtn" class="label-input-file btn btn-black btn-round me-2">
                            <span class="btn-label">
                                <i class="fa fa-file-image"></i>
                            </span>
                            Tải ảnh bìa của khóa học
                        </label>
                        <div id="imageName" class="mt-3"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_add_modal">Đóng</button>
                <button type="button" id="add_course" class="btn btn-success" disabled>Tạo khóa học</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";

    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
    let subjectUrl = 'app/apis/subject.php'
    let subjectResponse = await httpMixin.getMixin(subjectUrl)
    let subjects = subjectResponse.data

    let userUrl = 'app/apis/user.php'
    let userResponse = await httpMixin.getMixin(userUrl)
    let users = userResponse.data

    let teachers = []
    users.forEach(user => {
        if (user.role == 'Teacher' && user.state == 'Active') {
            teachers.push(user)
        }
    })

    function checkAddForm() {
        const name = document.getElementById("course_add_name").value.trim();
        const subjectId = document.getElementById("course_add_subject_id").value.trim();
        const teacherId = document.getElementById("course_add_teacher_id").value.trim();
        document.getElementById('add_course').disabled = !name || !subjectId || !teacherId;
    }

    function openAddModal() {
        document.getElementById("course_add_name").value = '';

        // Disable the "Add Student" button initially
        document.getElementById('add_course').disabled = true;

        // Add event listeners to track changes
        document.getElementById("course_add_name").addEventListener('input', checkAddForm);
        document.getElementById("course_add_subject_id").addEventListener('change', checkAddForm);
        document.getElementById("course_add_teacher_id").addEventListener('change', checkAddForm);

        let selectSubjectElement = document.getElementById('course_add_subject_id')
        subjects.forEach((subject, index) => {
            let label = subject.name
            let value = subject.id
            let option = document.createElement('option')
            let id = `subject-${index+1}`
            option.id = id
            option.value = value
            option.innerHTML = label
            if (!selectSubjectElement.querySelector(`#${id}`)) {
                selectSubjectElement.appendChild(option)
            }
        });

        let selectTeacherElement = document.getElementById('course_add_teacher_id')
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

        var addModal = new bootstrap.Modal(document.getElementById('addModal'));
        addModal.show();
    }

    function closeAddModal() {
        var addModal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
        addModal.hide();
    }

    const submitCreateCourse = async () => {
        let name = document.getElementById("course_add_name").value;
        let description = document.getElementById("course_add_description").value;
        let fee = document.getElementById("course_add_fee").value;
        let subject_id = document.getElementById("course_add_subject_id").value;
        let teacher_id = document.getElementById("course_add_teacher_id").value;
        let start_date = document.getElementById("course_add_start_date").value;
        let end_date = document.getElementById("course_add_end_date").value;
        let fileInput = document.getElementById('imageUpload');

        let url = 'app/apis/course.php'

        console.log(fileInput.files.length)


        if (fileInput.files.length > 0) {
            const formData = new FormData();
            formData.append('uploaded_file', fileInput.files[0]);
            formData.append('name', name);
            formData.append('description', description ?? '');
            formData.append('subject_id', subject_id);
            formData.append('teacher_id', teacher_id);
            formData.append('fee', fee ?? 0);
            formData.append('start_date', start_date ?? null);
            formData.append('end_date', end_date ?? null);

            const response = await httpMixin.postMixin(url, formData)
            if (response.status == 'success') {
                swal({
                    title: "Thêm bài học thành công!",
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
                closeAddLessonModal()
                window.location.reload()
            } else {
                swal(response.message ?? "Thêm bài học thất bại!", {
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
        } else {
            var data = {
                name: name,
                description: description ?? '',
                fee: fee ?? 0,
                subject_id: subject_id,
                teacher_id: teacher_id,
                start_date: start_date ?? null,
                end_date: end_date ?? null,
            };
            const response = await httpMixin.postMixin(url, data)
            if (response.status == 'success') {
                swal({
                    title: "Thêm môn học thành công!",
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
                closeAddModal()
                window.location.reload()
            } else {
                swal(response.message ?? "Thêm môn học thất bại!", {
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
    }

    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('imageUpload');
    const fileNameDisplay = document.getElementById('imageName');

    uploadBtn.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        const file = fileInput.files[0];
        if (file) {
            fileNameDisplay.textContent = `Ảnh được chọn: ${file.name}`;
        } else {
            fileNameDisplay.textContent = 'Không có ảnh nào được chọn';
        }
    });

    document.getElementById('open_add_modal').addEventListener('click', openAddModal)
    document.querySelectorAll('.close_add_modal').forEach(btn => {
        btn.addEventListener('click', closeAddModal)
    })
    document.getElementById('add_course').addEventListener('click', () => {
        closeAddModal()
        submitCreateCourse()
    })
</script>