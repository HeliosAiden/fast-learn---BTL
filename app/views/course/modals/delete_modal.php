<!-- Delete Course Modal -->
<div class="modal" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa khóa học</h5>
                <button type="button" class="btn-close close-delete-modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn xóa khóa học trên ?</p>
                <input type="hidden" id="delete-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-delete-modal">Hủy</button>
                <button type="button" id="delete-course-btn" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
    const snackBar = new SnackBarMixin()
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    function closeDeleteModal() {
        var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        const modalBody = document.querySelector('#deleteModal .modal-body')
        modalBody.removeChild(modalBody.lastChild)
        deleteModal.hide();
    }

    const submitDeleteSubject = async () => {
        const id = document.getElementById('delete-id').value
        let endpoint = `app/apis/course.php`
        const response = await httpMixin.deleteMixin(endpoint, id)
        if (response.status == 'success') {
            snackBar.showMessage('Xóa môn học thành công', response.status)
        } else {
            snackBar.showMessage(response.message ?? 'Xóa môn học thất bại', 'danger')
        }
    }

    document.querySelectorAll('.close-delete-modal').forEach(btn => {
        btn.addEventListener('click', closeDeleteModal)
    })
    document.getElementById('delete-course-btn').addEventListener('click', () => {
        closeDeleteModal()
        submitDeleteSubject()
        // window.location.reload();
    })
</script>