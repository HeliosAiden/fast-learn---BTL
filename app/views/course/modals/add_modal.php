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
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
    const snackBar = new SnackBarMixin()

    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
    let subjectUrl = '/app/apis/subject.php'
    let subjectResponse = await httpMixin.getMixin(subjectUrl)
    let subjects = subjectResponse.data

    function checkAddForm() {
        const name = document.getElementById("course_add_name").value.trim();
        const subjectId = document.getElementById("course_add_subject_id").value.trim();
        document.getElementById('add_course').disabled = !name || !subject_id;
    }

    function openAddModal() {
        document.getElementById("course_add_name").value = '';

        // Disable the "Add Student" button initially
        document.getElementById('add_course').disabled = true;

        // Add event listeners to track changes
        document.getElementById("course_add_name").addEventListener('input', checkAddForm);
        document.getElementById("course_add_subject_id").addEventListener('change', checkAddForm);

        let selectElement = document.getElementById('course_add_subject_id')
        subjects.forEach((subject, index) => {
            console.log(subject)
            console.log(index)
            let label = subject.name
            let value = subject.id
            let option = document.createElement('option')
            let id = `subject-${index+1}`
            option.id = id
            option.value = value
            option.innerHTML = label
            if (!selectElement.querySelector(`#${id}`)) {
                selectElement.appendChild(option)
            }
        });

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
        let start_date = document.getElementById("course_add_start_date").value;
        let end_date = document.getElementById("course_add_end_date").value;

        var data = {
            name: name,
            description: description ?? '',
            fee: fee ?? 0,
            subject_id: subject_id,
            start_date: start_date ?? null,
            end_date: end_date ?? null,
        };

        let endpoint = 'app/apis/course.php'
        response = await httpMixin.postMixin(endpoint, data)
        if (response.status == 'success') {
            snackBar.showMessage('Thêm môn học thành công')
        } else {
            snackBar.showMessage(response.message ?? 'Thêm môn học thất bại', 'danger')
        }
    }

    document.getElementById('open_add_modal').addEventListener('click', openAddModal)
    document.querySelectorAll('.close_add_modal').forEach(btn => {
        btn.addEventListener('click', closeAddModal)
    })
    document.getElementById('add_course').addEventListener('click', () => {
        closeAddModal()
        submitCreateCourse()
        window.location.reload();
    })
</script>