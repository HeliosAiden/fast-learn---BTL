<!-- Edit Course Modal -->
<div class="modal" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa khóa học</h5>
                <button type="button" class="btn-close close-edit-modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-form-id">
                <!-- Course Name (Required) -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tên khóa học<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">
                        tên khóa học
                    </div>
                </div>

                <!-- Course Description (Optional) -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả khóa học</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <!-- Course Fee (Optional) -->
                <div class="mb-3">
                    <label for="fee" class="form-label">Học phí</label>
                    <input type="number" class="form-control" id="fee" name="fee" step="0.01" min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-edit-modal">Đóng</button>
                <button type="button" id='edit_course_btn' class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </div>
    </div>
    <script type="module">
        import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
        import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
        const snackBar = new SnackBarMixin()
        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
        // ** Edit Modal Form ** //

    function closeEditModal() {
        var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        editModal.hide();
    }

    const submitEditSubject = async () => {
        let id = document.getElementById('edit-form-id').value;
        let name = document.getElementById('name').value;
        let description = document.getElementById('description').value;
        let fee = document.getElementById('fee').value;

        var data = {
            name: name,
            description: description,
            fee: fee,
        };

        let endpoint = 'app/apis/course.php'
        const response = await httpMixin.putMixin(endpoint, data, id)

        if (response.status == 'success') {
            snackBar.showMessage('Thay đổi khóa học thành công', response.status)
        } else {
            snackBar.showMessage(response.message ?? 'Thay đổi khóa học thất bại', 'danger')
        }
    }

    document.querySelectorAll('.close-edit-modal').forEach(btn => {
        btn.addEventListener('click', closeEditModal)
    })
    document.getElementById('edit_course_btn').addEventListener('click', () => {
        closeEditModal()
        submitEditSubject()
        // window.location.reload();
    })
    </script>
</div>